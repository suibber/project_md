<?php

namespace common\models\extensions\time_book;

use Yii;
use common\models\extensions\time_book;

/**
 * This is the model class for table "ext_time_book_schedule".
 *
 * @property integer $id
 * @property string $user_id
 * @property string $task_id
 * @property string $from_datetime
 * @property string $to_datetime
 * @property integer $allowable_distance_offset
 * @property string $lat
 * @property string $lng
 * @property string $address
 * @property string $task_title
 *
 * @property Record[] $records
 */
class Schedule extends \common\BaseActiveRecord
{

    public $count;
    public $past_count;

    public $on_late_count;
    public $off_early_count;
    public $out_work_count;
    public $noted_count;

    public $is_today_on;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ext_time_book_schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_datetime', 'to_datetime'], 'safe'],
            [['allowable_distance_offset'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['date'], 'safe'],
            [['user_id', 'task_id'], 'string', 'max' => 200],
            ['allowable_distance_offset', 'default', 'value'=> 1000],
            [['address', 'task_title'], 'string', 'max'=>200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'task_id' => 'Task ID',
            'from_datetime' => 'From Datetime',
            'to_datetime' => 'To Datetime',
            'allowable_distance_offset' => 'Allowable Distance Offset',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'out_work_on' => '是否打卡',
            'on_late' => '是否迟到',
            'off_early' => '是否早退',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecords()
    {
        return $this->hasMany(Record::className(), ['schedule_id' => 'id']);
    }

    public function getFrom_time()
    {
        return substr($this->from_datetime, 11);
    }

    public function getTo_time()
    {
        return substr($this->to_datetime, 11);
    }

    public function getIs_past()
    {
        return $this->date <= date('Y-m-d');
    }

    public function getOn_daka(){
        $time = Record::findOne(['schedule_id' => $this->id, 'event_type' => Record::EVENT_ON]);
        if($time){
            return $time->created_time;
        }else{
            return NULL;
        }
    }

    public function getOff_daka(){
        $time = Record::findOne(['schedule_id' => $this->id, 'event_type' => Record::EVENT_OFF]);
        if($time){
            return $time->created_time;
        }else{
            return NULL;
        }
    }

    public function fields()
    {
        $fs = parent::fields();
        return array_merge($fs, [
            'on_daka',
            'off_daka',
        ]);
    }
}
