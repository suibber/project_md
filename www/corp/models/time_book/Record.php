<?php
namespace corp\models\time_book;


class Record extends \common\models\extensions\time_book\Record
{

    public function rules()
    {
        return [
            [['id', 'lng', 'lat', 'schedule_id'], 'required'],
            [['id', 'event_type', 'schedule_id'], 'integer'],
            [['lng', 'lat'], 'number'],
            [['created_time'], 'safe'],
            [['user_id'], 'integer'],
        ];
    }

    public function getSchedule()
    {
        return $this->hasOne(Schedule::className(), ['id' => 'schedule_id']);
    }
}
