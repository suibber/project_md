<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tasktime}}".
 *
 * @property integer $id
 * @property integer $dayofweek
 * @property integer $morning
 * @property integer $afternoon
 * @property integer $evening
 * @property integer $task_id
 */
class Tasktime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tasktime}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dayofweek', 'task_id'], 'required'],
            [['dayofweek', 'morning', 'afternoon', 'evening', 'task_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dayofweek' => 'Dayofweek',
            'morning' => 'Morning',
            'afternoon' => 'Afternoon',
            'evening' => 'Evening',
            'task_id' => 'Task ID',
        ];
    }
}
