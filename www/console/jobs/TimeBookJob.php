<?php

namespace console\jobs;

use console\BaseJob;
use corp\models\time_book\Schedule;

class TimeBookJob extends BaseJob
{

    public function actionUpdate($date)
    {
        $schedules = Schedule::find()
            ->where(['date'=>$date])
            ->with('on_record')
            ->with('off_record')
            ->with('records')
            ->all();
        foreach( $schedules as $schedule ){
            if( !count($schedule->records) ){
                $schedule->out_work = 1;
            }
            if( !isset($schedule->on_record) ){
                $schedule->out_work_on = 1;
            }
            if( !isset($schedule->off_record) ){
                $schedule->out_work_off = 1;
            }
            $schedule->save();
        }
        return true;
    }
}
