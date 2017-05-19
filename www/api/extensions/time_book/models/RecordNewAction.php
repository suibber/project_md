<?php
namespace api\extensions\time_book\models;

use Yii;
use common\Utils;
use yii\web\BadRequestHttpException;

class RecordNewAction extends \yii\rest\CreateAction
{

    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }
        /* @var $model \yii\db\ActiveRecord */

        $bmodel = $this->modelClass;
        $model = new $bmodel([
            'scenario' => $this->scenario,
        ]);
        $req = Yii::$app->getRequest();
        $params = $req->getBodyParams();
        $schedule = null;
        if ($req->post('schedule_id')){
            $schedule = Schedule::findOne($params['schedule_id']);
        }
        if (!$schedule){
            unset($params['schedule_id']);
        } else {
            $params['owner_id'] = $schedule->owner_id;
            $mtime = (strtotime($schedule->from_datetime) + strtotime($schedule->to_datetime))/2;

            if (time()>$mtime){
                $params['event_type'] = $model::EVENT_OFF;
            } else {
                $params['event_type'] = $model::EVENT_ON;
                $on_model = $bmodel::findOne(
                    ['schedule_id'=>$schedule->id, 'event_type'=>$model::EVENT_ON]);
                if ($on_model){
                    $params['event_type'] = $model::EVENT_WORKING;
                }
            }
        }

        $distance = Utils::distanceStr(
                        ['lat'=>$params['lat'], 'lng'=> $params['lng']],
                        ['lat'=> $schedule->lat, 'lng'=> $schedule->lng]
                    );
        $distance_m = str_ireplace('m','',$distance);

        $date = date("Y-m-d");
        $device_used = $bmodel::findOne([
            'device_date' => $date,
            'device_id'   => $params['device_id'],
        ]);
        if( $device_used && ( $device_used->user_id != Yii::$app->user->id ) ){
            return [
                'success' => false,
                'message' => '打卡失败，您的手机今日已为其他用户打卡！',
            ];
        }

        if( !is_numeric($distance_m) || 
            $distance_m >= Yii::$app->params['time_book.valid_distance'] )
        {
            return [
                'success' => false,
                'message' => '打卡失败，您不在打卡范围内！',
            ];
        }

        $model->load($params, '');
        $model->device_date = $date;
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $model->save();
            $model->checkout();
            if ($model->event_type==$model::EVENT_OFF){
                $bmodel::updateAll(
                    ['event_type'=>$model::EVENT_WORKING],
                    'schedule_id=:schedule_id and event_type=:event_type and id<>:id',
                    ['schedule_id'=>$schedule->id,
                        'event_type'=>$model::EVENT_OFF,
                        'id'=>$model->id,
                    ]
                );
            }
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return [
            'success' => true,
            'message' => '打卡成功！',
            'result'  => $model,
        ];
    }

}
