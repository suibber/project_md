<?php
 
namespace api\miduoduo\v1\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\HttpException;
use api\common\BaseActiveController;
 
use common\Utils;
use common\models\User;
use common\models\AppReleaseVersion;
use common\models\Device;
use common\models\WeichatUserInfo;
use common\Constants;
use api\common\Utils as AUtils;

/**
 * Entry Controller API
 *
 * @author dawei
 */
class EntryController extends BaseActiveController
{
    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'signup', 'vlogin',
                        'vcode', 'vcode-for-signup', 'report-device',
                        'report-push-id', 'check-update', 't-login',
                    ],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    public function actionReportDevice()
    {
        $device = $this->distillDeviceFromRequest(Yii::$app->request);
        if ($device){
            $device->save();
            return $this->renderJson([
                'success'=> true,
                'message'=> '记录成功',
                ]);
        }
        return $this->renderJson([
            'success'=> false,
            'message'=> '未知的设备信息',
            ]);
    }

    public function distillDeviceFromRequest($request)
    {
        $device_id = Utils::getDeviceId($request);
        $device_info = $request->headers->get('User-Agent');
        $app_version = Utils::getAppVersion($request);
        if (empty($device_id)||empty($device_info)||empty($app_version)){
            return null;
        }
        $device = Device::find()->where(['device_id'=>$device_id])->one();
        if (!$device){
            $device = new Device();
            $device->device_id = $device_id;
        }
        $device->device_info = $device_info;
        $device->app_version = $app_version;
        return $device;
    }

    public function actionReportPushId()
    {
        $push_id = Yii::$app->request->post('push_id');
        if (empty($push_id)){
            return $this->renderJson([
                'success'=> false,
                'message'=> '没有push id信息',
                ]);
        }
        $device = $this->distillDeviceFromRequest(Yii::$app->request);
        if ($device){
            $device->push_id = $push_id;
            $device->save();
            return $this->renderJson([
                'success'=> true,
                'message'=> '记录成功',
                ]);
        }
        return $this->renderJson([
            'success'=> false,
            'message'=> '未知的设备信息',
            ]);
    }

    public function actionCheckUpdate()
    {
        $user_agent = Yii::$app->request->headers->get('User-Agent');
        $device_type = Utils::getDeviceType($user_agent);
        $app_version = Yii::$app->request->headers->get('App-Version');
        if (!$device_type || !$app_version){
            return $this->renderJson([
                'success'=> false,
                'message'=> '未知的设备信息',
                ]);
        }
        $h5v = AppReleaseVersion::find()->where(
            ['app_version'=>$app_version, 'device_type'=>$device_type])
            ->orderBy(['id'=>SORT_DESC])->one();

        $appv = AppReleaseVersion::find()->where(['device_type'=>$device_type])
            ->orderBy(['id'=>SORT_DESC])->one();
        if ($appv && ($app_version=='1.0' || $app_version=='1.1')){
            if ($device_type==Constants::DEVICE_ANDROID) {
                $appv->html_version = "23";
            }
        }

        return $this->renderJson([
            'success'=> true,
            'message'=> '获取成功',
            'result'=> [
                'current_app'=>$h5v?$h5v->toArray():[],
                'newest_app'=>$appv?$appv->toArray():[],
                ]
            ]);
    }

    public function activeDevice($user)
    {
        $device_type = Utils::getDeviceType(Yii::$app->request->get('User-Agent'));
        if ($device_type){
            Device::updateAll(['is_active'=> false], 'user_id=' . $user->id);
            $device = $this->distillDeviceFromRequest(Yii::$app->request);
            $device->user_id = $user->id;
            $device->access_token = $user->access_token;
            $device->is_active = true;
            $device->save();
        }
    }


    public function actionLogin()
    {
        $username = Yii::$app->request->post('phonenum');
        $password = Yii::$app->request->post('password');
        if(!(empty($username) || empty($password))){
            $user = User::find()->with('resume')->with('company')->where([
                'username' => $username,
            ])->one();
            if($user){
                if($user->validatePassword($password)){
                    if (!Utils::isInWechat() || empty($user->access_token)){
                        $user->generateAccessToken();
                    }
                    $user->save();
                    $this->activeDevice($user);
                    return $this->loginSucceed($user, $password);
                }
            }
        }

        return $this->renderJson(['success'=> false,
            'message'=> '用户名密码不正确']);
    }

    public function actionVcode()
    {
        $phonenum = Yii::$app->request->post('phonenum');
        if (!Utils::isPhonenum($phonenum)){
            return $this->renderJson([
                'success'=> false,
                'message'=> "手机号码不正确"
            ]);
        }
        if (Utils::sendVerifyCode($phonenum)){
            return $this->renderJson([
                    'success'=> true,
                    'message'=> "验证码已发送"
            ]);
        }
        return $this->renderJson([
                'success'=> false,
                'message'=> "验证码发送失败, 请稍后重试。"
        ]);
    }

    public function actionVcodeForSignup()
    {
        $phonenum = Yii::$app->request->post('phonenum');

        $user = User::findByUsername($phonenum);
        if ($user){
            return $this->renderJson([
                'success'=> false,
                'message'=> "手机号码已被注册，请直接登陆"
            ]);
        }
        return $this->actionVcode();
    }


    public function actionVlogin()
    {
        $phonenum = Yii::$app->request->post('phonenum');
        $code = Yii::$app->request->post('code');
        $password = Yii::$app->request->post('password');
        $invited_by = Yii::$app->request->post('invited_by');

        if(Utils::validateVerifyCode($phonenum, $code)){
            $user = User::findByUsername($phonenum);
            if (!$user){
                $user = new User();
                $user->username = $phonenum;
                if ($invited_by){
                    $user->invited_by = $invited_by;
                }
                $user->setPassword(rand(1000000, 9999999));
                if (!$user->save()){
                    $message = '';
                    foreach ($user->getErrors() as $key=>$errors){
                        $message .= join('\n', $errors) . "\n";
                    }
                    return $this->renderJson([
                        'success'=> false,
                        'message'=> $message,
                    ]);
                }
            }
            if (!Utils::isInWechat() || empty($user->access_token)){
                $user->generateAccessToken();
            }
            $this->activeDevice($user);

            if ($password){
                $user->setPassword($password);
            }
            $user->invited_by   = $invited_by;
            $user->save();
            return $this->loginSucceed($user);
        }
        return $this->renderJson([
            'success'=> false,
            'message'=> "手机号或验证码不正确",
        ]);
    }

    public function actionSignup()
    {
        $phonenum = Yii::$app->request->post('phonenum');
        $user = User::findByUsername($phonenum);
        if ($user){
            $invited_by = Yii::$app->request->post('invited_by');
            if (!empty($invited_by)){
                $user->invited_by = intval($invited_by);
                $user->save();
            }
            return $this->renderJson([
                'success'=> false,
                'message'=> "手机号码已被注册，请直接登陆"
            ]);
        }
        return $this->actionVlogin();
    }

    public function actionTLogin()
    {
        $params = Yii::$app->request->post('params');
        $platform = Yii::$app->request->post('platform');
        $result = false;
        $function =  'loginWith'. ucfirst($platform);
        if (method_exists($this, $function)){
            return $this->$function($params);
        } else {
            return $this->renderJson([
                'success'=> false,
                'message'=> "未知的平台类型",
            ]);
        }
    }

    public function loginWithWechat($params)
    {
        $info = WeichatUserInfo::find()->with('user')
            ->where(['unionid'=>$params['unionid']])
            ->andWhere(['>', 'userid', 0])
            ->one();
        if ($info){
            return $this->loginSucceed($info->user);
        }
        return $this->renderJson([
            'success'=> false,
            'message'=> "该微信号未绑定过",
        ]);
    }

    public function loginSucceed($user, $raw_password='')
    {
        $profile = AUtils::formatProfile($user, $raw_password);
        return $this->renderJson([
            'success'=> true,
            'message'=> '登录成功',
            'result'=> $profile,
        ]);
    }
}
