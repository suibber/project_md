<?php

namespace api\extensions\time_book\models;

use Yii;

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
class Record extends \common\models\extensions\time_book\Record
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lng', 'lat', 'schedule_id'], 'required'],
            [['id', 'event_type', 'schedule_id'], 'integer'],
            [['lng', 'lat'], 'number'],
            [['created_time', 'device_id', 'device_date'], 'safe'],
            [['user_id', 'owner_id'], 'string', 'max' => 200]
        ];
    }
}
