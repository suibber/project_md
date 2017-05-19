<?php

namespace api\extensions\time_book\models;

use Yii;

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
 *
 * @property Record[] $records
 */
class Schedule extends \common\models\extensions\time_book\Schedule
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_datetime', 'to_datetime'], 'safe'],
            [['allowable_distance_offset'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['user_id', 'task_id', 'owner_id'], 'string', 'max' => 200]
        ];
    }
}
