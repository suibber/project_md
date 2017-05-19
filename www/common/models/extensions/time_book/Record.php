<?php

namespace common\models\extensions\time_book;

use Yii;
use common\Utils;

/**
 * This is the model class for table "ext_time_book_record".
 *
 * @property integer $id
 * @property string $lng
 * @property string $lat
 * @property integer $event_type
 * @property string $created_time
 * @property string $user_id
 * @property integer $schedule_id
 *
 * @property Schedule $schedule
 */
class Record extends \common\BaseActiveRecord
{

    const EVENT_ON = 1;
    const EVENT_OFF = 2;
    const EVENT_WORKING = 10;

    public static function tableName()
    {
        return 'ext_time_book_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lng', 'lat', 'schedule_id'], 'required'],
            [['id', 'event_type', 'schedule_id'], 'integer'],
            [['lng', 'lat'], 'number'],
            [['created_time'], 'safe'],
            [['user_id'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lng' => 'Lng',
            'lat' => 'Lat',
            'event_type' => 'Event Type',
            'created_time' => 'Created Time',
            'user_id' => 'User ID',
            'schedule_id' => 'Schedule ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedule()
    {
        return $this->hasOne(Schedule::className(), ['id' => 'schedule_id']);
    }

    private $_distance;

    public function getDistance()
    {
        if (!$this->_distance){
            $this->_distance = Utils::distanceStr(
                ['lat'=>$this->lat, 'lng'=> $this->lng],
                ['lat'=> $this->schedule->lat, 'lng'=> $this->schedule->lng]
            );
        }
        return $this->_distance;
    }

    public function checkout()
    {
        if ($this->event_type==$this::EVENT_ON){
            $this->schedule->on_late = strtotime($this->schedule->from_datetime) < time();
        }
        if ($this->event_type==$this::EVENT_OFF){
            $this->schedule->off_early = strtotime($this->schedule->to_datetime) > time();
        }
        $this->schedule->save();
    }

    public function getTime()
    {
        return substr($this->created_time, 11);
    }

    public function getDate()
    {
        return substr($this->created_time, 0, 11);
    }
}
