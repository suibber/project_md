<?php

namespace common\pusher;

use Yii;
use yii\base\Component;
use yii\base\ViewContextInterface;

require_once(Yii::getAlias('@vendor/autoload.php'));

use JPush\Model as JModel;
use JPush\JPushClient;
use JPush\Exception\APIConnectionException;
use JPush\Exception\APIRequestException;

use common\constants;
use common\models\Device;


class AppPusher extends Component implements ViewContextInterface 
{

    private $_client;

    public $app_key;
    public $master_secret;

    public function getViewPath()
    {
        return Yii::getAlias("");
    }


    public function getClient()
    {
        if (empty($this->app_key) || empty($this->master_secret)){
            throw new Exception('Need to set <app_key> and <master_secret> in your  main config');
        }
        if (empty($this->_client)) {
            $this->_client = new JPushClient($this->app_key, $this->master_secret);
        }
        return $this->_client;
    }

    public function notification($user_id, $message, $options=[])
    {
        $devices = Device::find()->where(['user_id'=>$user_id, 'is_active'=>true])->all();
        $reg_ids = [];
        foreach ($devices as $device){
            $reg_ids[] = $device ->push_id;
        }
        if (empty($reg_ids)){
            Yii::error("Push failed, No signed in device for this user ");
            return false;
        }

        $audiences = JModel\audience(JModel\registration_id($reg_ids));
        try {
            $result = $this->getClient()
                ->push()
                ->setPlatform(JModel\all)
                ->setAudience($audiences)
                ->setNotification(JModel\notification($message, JModel\ios($message, $badge="+1",1,true,$options)))
                ->send();
            Yii::trace('Push message succeed with sendno:'. $result->sendno
                . ', message id:' . $result->msg_id
            );
        } catch (APIRequestException $e) {
            Yii::error('Push failed with code:' . $e->code . ', message:'. $e->message . ', json response: '. $e->json);
            return false;
        } catch (APIConnectionException $e) {
            Yii::error('Push failed with connection error:' . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Yii::error('Push failed with exception:' . $e->getMessage());
            return false;
        }
        return true;
    }

    public function message($user_id, $message, $devices=null)
    {

    }
}
