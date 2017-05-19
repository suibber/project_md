<?php
namespace api\extensions\time_book\models;

use Yii;
use common\Utils;
use yii\web\BadRequestHttpException;
use common\models\extensions\time_book\Schedule;
use common\models\extensions\time_book\Record;

class ScheduleAllAction extends \yii\rest\IndexAction
{

    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        $date = Yii::$app->request->get('date') ? Yii::$app->request->get('date') : date("Y-m-d");
        $user_id = Yii::$app->user->id;

        $schedules = Schedule::find()
            ->select("
                *,
                count(1) as count,
                sum(case WHEN date<=CURDATE() THEN 1 ELSE 0 END) as past_count,
                sum(on_late) as on_late_count,
                sum(off_early) as off_early_count,
                sum(out_work) as out_work_count,
                sum(CASE WHEN note is null OR note = '' THEN 0 ELSE 1 END) as noted_count,
                user_id,
                sum(case WHEN date=CURDATE() THEN 1 ELSE 0 END) as is_today_on
            ")
            ->groupBy('task_id')
            ->andWhere(['user_id'=>$user_id])
            ->all();
        $return_schedules = [];
        foreach( $schedules as $schedule){
            $return_schedule = $schedule->toArray();
            $return_schedule['count'] = $schedule->count;
            $return_schedule['past_count'] = $schedule->past_count;
            $return_schedule['on_late_count'] = $schedule->on_late_count;
            $return_schedule['off_early_count'] = $schedule->off_early_count;
            $return_schedule['out_work_count'] = $schedule->out_work_count;
            $return_schedule['noted_count'] = $schedule->noted_count;
            $return_schedule['user_id'] = $schedule->user_id;
            $return_schedule['is_today_on'] = $schedule->is_today_on;
            $return_schedules[] = $return_schedule;
        }
        
        return [
            'success' => true,
            'message' => '获取成功！',
            'result'  => $return_schedules,
        ];
    }

}