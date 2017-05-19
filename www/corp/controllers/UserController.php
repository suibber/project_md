<?php
namespace corp\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

use common\Utils;
use common\JobUtils;
use common\models\LoginWithDynamicCodeForm;
use common\models\User;
use common\sms\SmsSenderFactory;
use common\models\Company;
use common\models\ServiceType;

use corp\CBaseController;
use corp\forms\PasswordResetRequestForm;
use corp\forms\ResetPasswordForm;
use corp\forms\SignupForm;
use corp\forms\LoginForm;
use corp\forms\ContactForm;
use corp\forms\PersonalCertForm;

/**
 * Site controller
 */
class UserController extends CBaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'register', 'vcode','request-password-reset', 'reset-password', 'vlogin'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['add-contact-info','logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                    'vlogin' => ['post'],
                ],
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionLogin()
    {
        $loginModel = new LoginForm();
        if ($loginModel->load(Yii::$app->request->post(), '') && $loginModel->login()) {
            $user_id    = Yii::$app->user->id;
            $company    = Company::find()->where(['user_id'=>$user_id])->one();
            if( $company && $company->status == 20 ){
                Yii::$app->user->logout();
                return $this->renderJson(['result' => false,'error' => ['password'=>['您的账户已经被加入黑名单']] ]);
            }

            return $this->renderJson(['result' => true ]);
        }
        return $this->renderJson(['result' => false, 'error' => $loginModel->errors]);
    }

    public function actionRegister()
    {
        $regModel = new SignupForm();
        if ($regModel->load(Yii::$app->request->post(), '')) {
            if ($user = $regModel->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->renderJson(['result' => true]);
                }
            }
        }

        return $this->renderJson(['result' => false, 'error' => $regModel->errors]);
    }

    public function actionVcode($username)
    {
        if (!Utils::isPhonenum($username)){
            return $this->renderJson([
                'result'=> false,
                'msg'=> "手机号码不正确"
            ]);
        }

        if (Yii::$app->request->get('check_existed') == 1) {
            $user = User::findByUsername($username);
            if ($user) {
                return $this->renderJson([
                        'result'=> false,
                        'msg'=> "手机号已注册"
                ]);
            }
        }

        if (Utils::sendVerifyCode($username)){
            return $this->renderJson([
                    'result'=> true,
                    'msg'=> "验证码已发送"
            ]);
        }

        return $this->renderJson([
                'result'=> false,
                'msg'=> "验证码发送失败, 请稍后重试。"
        ]);
    }

    public function actionVlogin()
    {
        $username = Yii::$app->request->post('username');
        $vcode = Yii::$app->request->post('vcode');
        if(!Utils::validateVerifyCode($username, $vcode)){
            return $this->renderJson(['result' => false, 'error' => '手机号或验证码不正确.']);
        }
        $user = User::findByUsername($username);
        if (!$user) {
            return $this->renderJson(['result' => false, 'error' => '这个手机号没有注册过，请先注册.']);
        }
        if (!Yii::$app->user->login($user, 3600 * 24 * 30)) {
            return $this->renderJson(['result' => false, 'error' => '登录失败，请再试一次']);
        }
        return $this->renderJson(['result' => true]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            $token = $model->verifyPhone();
            if ($token !== false) {
                return $this->redirect(array('/user/reset-password', 'token' => $token));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token='')
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            // throw new Bad RequestHttpException($e->getMessage());
            //just for test
            return $this->render('resetPassword');
        }

        if ($model->load(Yii::$app->request->post(), '') && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword');
    }

    public function actionAddContactInfo()
    {
        $model = Company::findByCurrentUser();
        if (!$model) {
            $model = new Company;
        }
        if(Yii::$app->request->isPost){
            $model->setAttributes(Yii::$app->request->post(), false);
            $model->user_id = Yii::$app->user->id;
            $model->origin  = Company::ORIGINS_SELF;
            if ($model->validate() && $model->save()) {
                if (!Yii::$app->user->can('corp')){
                    $auth = Yii::$app->authManager;
                    $role = $auth->getRole('corp');
                    $auth->assign($role, Yii::$app->user->id);
                }
                return $this->redirect('/task/publish');
            }
        }
        return $this->render('addContactInfo', ['model' => $model]);
    }

    public function actionInfo()
    {
        $company = Company::findByCurrentUser();
        if (!$company) {
            return $this->redirect('/user/add-contact-info');
        }

        $services = ServiceType::find()->all();

        if (Yii::$app->request->isPost) {
            $company->setAttributes(Yii::$app->request->post(), false);
            if ($company->validate() && $company->save()) {
                return $this->render('info', ['company' => $company, 'services' => $services]);
            }else{
                return $this->render('info', ['company' => $company, 'services' => $services,'error'=>'保存失败，请核对您填写的信息！']);
            }
        }

        return $this->render('info', ['company' => $company, 'services' => $services]);
    }

    public function actionAccount()
    {
        if (Yii::$app->request->isPost) {
            $old_password = Yii::$app->request->post('old_password');
            $new_password = Yii::$app->request->post('new_password');
            $confirm = Yii::$app->request->post('confirm');
            if( strlen($old_password)<1 || strlen($new_password)<1 || strlen($confirm)<1 ){
                return $this->render('account', ['error'=>'密码不能为空']);
            }
            if (strcmp($new_password, $confirm) != 0) {
                return $this->render('account', ['error'=>'新密码不一致']);
            }
            $user = User::findIdentity(Yii::$app->user->id);
            if (!$user->validatePassword($old_password)) {
                return $this->render('account', ['error'=>'原密码错误']);
            }

            $user->setPassword($new_password);
            $user->removePasswordResetToken();
            if ($user->validate() && $user->save()) {
                return $this->goHome();
            }
        }

        return $this->render('account', ['error'=>'']);
    }

    public function actionPersonalCert()
    {
        $company = Company::findByCurrentUser();
        if (!$company) {
            return $this->redirect('/user/add-contact-info');
        }

        if(Yii::$app->request->isPost){
            if( $_FILES['person_idcard_pic']['size'] > 0 ){
                $filename = Utils::saveUploadFile($_FILES['person_idcard_pic']);
            }else{
                $filename = $company->person_idcard_pic;
            }
            if(!$filename) {
                return $this->render('personal-cert',[
                    'company' => $company,
                    'error'=> '上传文件错误']);
            }
            $company->person_idcard_pic = $filename;
            $company->exam_status = Company::EXAM_PROCESSING;
            if( $company->exam_result == Company::EXAM_ALL_PASSED ){
                $company->exam_result = Company::EXAM_LICENSE_PASSED;
            }else{
                $company->exam_result = Company::EXAM_GOVID_UNCHECK;
            }
            $company->exam_note   = '';
            $company->setAttributes(Yii::$app->request->post(), false);
            if (!$company->validate() || !$company->save()) {
                $error = '';
                foreach ($company->errors as $key=>$errors){
                    $error .= implode("\n", $errors) . "\n";
                }
                return $this->render(
                    'personal-cert',
                    ['company' => $company, 'error'=>$error]);
            }
            JobUtils::addSyncFileJob($company, 'person_idcard_pic');
            return $this->render('personal-cert',['company' => $company, 'error'=>false]);
        }
        return $this->render('personal-cert',['company' => $company, 'error'=>false]);
    }

    public function actionCorpCert()
    {
        $company = Company::findByCurrentUser();
        if (!$company) {
            return $this->redirect('/user/add-contact-info');
        }
        if(Yii::$app->request->isPost){
            if( $_FILES['person_idcard_pic']['size'] > 0 ){
                $filename = Utils::saveUploadFile($_FILES['person_idcard_pic']);
            }else{
                $filename = $company->person_idcard_pic;
            }
            if(!$filename) {
                return $this->render('corp-cert',['company' => $company, 'error'=>'请上传您的身份证照片']);
            }
            $company->person_idcard_pic = $filename;
            
            if( $_FILES['corp_idcard_pic']['size'] > 0 ){
                $filename = Utils::saveUploadFile($_FILES['corp_idcard_pic']);
            }else{
                $filename = $company->corp_idcard_pic;
            }
            if(!$filename) {
                return $this->render('corp-cert',['company' => $company, 'error'=>'请上传您的企业营业照']);
            }
            $company->corp_idcard_pic = $filename;

            $company->exam_status = Company::EXAM_PROCESSING;
            $company->exam_result = Company::EXAM_GOVID_UNCHECK;
            $company->exam_note   = '';
            $company->setAttributes(Yii::$app->request->post(), false);
            if (!$company->validate() || !$company->save()) {

                $error = '';
                foreach ($company->errors as $key=>$errors){
                    $error .= implode("\n", $errors) . "\n";
                }
                return $this->render('corp-cert',['company' => $company, 'error'=>$error]);
            }
            JobUtils::addSyncFileJob($company, 'person_idcard_pic');
            JobUtils::addSyncFileJob($company, 'corp_idcard_pic');
            return $this->render('corp-cert',['company'=>$company, 'error'=>false]);
        }
        return $this->render('corp-cert',['company'=>$company, 'error'=>false]);
    }
}
