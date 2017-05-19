<?php
 
namespace api\miduoduo\v1\controllers;
 
use Yii;
use api\common\BaseActiveController;
use common\models\Device;
use common\Utils;
 
/**
 *  Controller API
 *
 * @author dawei
 */
class ReportController extends BaseActiveController
{
    public $modelClass = 'common\models\User';

    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

    public function actionPushId()
    {
        $push_id = Yii::$app->request->post('push_id');
        $user_id = Yii::$app->user->id;
        if (empty($push_id)){
            return $this->renderJson([
                'success'=> false,
                'message'=> '没有push id信息',
                ]);
        }
        if (empty($user_id)){
            return $this->renderJson([
                'success'=> false,
                'message'=> '没有user_id信息',
                ]);
        }
        $device = $this->distillDeviceFromRequest(Yii::$app->request);
        if ($device){
            $device->push_id = $push_id;
            $device->user_id = $user_id;
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

}
