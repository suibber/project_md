<?php

namespace corp\models\time_book;


class Schedule extends \common\models\extensions\time_book\Schedule
{

    public $count;
    public $past_count;

    public $on_late_count;
    public $off_early_count;
    public $out_work_count;
    public $noted_count;

    public $is_today_on;

    public function rules()
    {
        return [
            [['from_datetime', 'to_datetime'], 'safe'],
            [['allowable_distance_offset'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['date'], 'safe'],
            [['user_id', 'task_id'], 'integer'],
            ['allowable_distance_offset', 'default', 'value'=> 1000],
            [['address', 'task_title'], 'string', 'max'=>200],
        ];
    }

    public function getRecords()
    {
        return $this->hasMany(Record::className(), ['schedule_id' => 'id']);
    }

    public function getOn_record()
    {
        return $this->hasOne(Record::className(), ['schedule_id' => 'id'])
            ->andWhere(['event_type' => Record::EVENT_ON]);
    }

    public function getOff_record()
    {
        return $this->hasOne(Record::className(), ['schedule_id' => 'id'])
            ->andWhere(['event_type' => Record::EVENT_OFF]);
    }
}
