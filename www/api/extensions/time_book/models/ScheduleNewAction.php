<?php
namespace api\extensions\time_book\models;

use Yii;
use common\Utils;
use yii\web\BadRequestHttpException;
use common\models\extensions\time_book\Schedule;
use common\models\extensions\time_book\Record;

class ScheduleNewAction extends \yii\rest\IndexAction
{

    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        $date = Yii::$app->request->get('date') ? Yii::$app->request->get('date') : date("Y-m-d");
        $user_id = Yii::$app->user->id;

        $schedules = Schedule::find()
            ->where(['user_id'=>$user_id, 'date' => $date])
            ->with('records')
            ->all();

        $return_schedules = [];
        $return_key = 0;
        foreach( $schedules as $key => $schedule ){
            $key1 = $return_key;
            $return_schedules[$key1] = $schedule->toArray();
            $return_schedules[$key1]['event_type'] = Record::EVENT_ON;
            $return_schedules[$key1]['time'] = $return_schedules[$key1]['from_datetime'];
            $return_schedules[$key1]['has_done'] = 0;
            $return_schedules[$key1]['msg'] = '待打卡';
            $key2 = ++$return_key;
            $return_schedules[$key2] = $schedule->toArray();
            $return_schedules[$key2]['event_type'] = Record::EVENT_OFF;
            $return_schedules[$key2]['time'] = $return_schedules[$key2]['to_datetime'];
            $return_schedules[$key2]['has_done'] = 0;
            $return_schedules[$key2]['msg'] = '待打卡';
            ++$return_key;

            foreach( $schedule->records as $record ){
                if( $record->event_type == 1 ){
                    $return_schedules[$key1]['has_done'] = 1;
                    $return_schedules[$key1]['msg'] = '已打卡';
                }
                if( $record->event_type == 2 ){
                    $return_schedules[$key2]['has_done'] = 1;
                    $return_schedules[$key2]['msg'] = '已打卡';
                }
            }
        }
        return [
            'success' => true,
            'message' => '获取成功！',
            'result'  => $return_schedules,
        ];
    }

}