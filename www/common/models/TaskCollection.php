<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%task_collection}}".
 *
 * @property integer $id
 * @property string $created_time
 * @property integer $user_id
 * @property integer $task_id
 *
 * @property User $user
 * @property Task $task
 */
class TaskCollection extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_collection}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_time'], 'safe'],
            [['user_id', 'task_id'], 'required'],
            [['user_id', 'task_id'], 'integer'],
            ['task_id', 'unique',
                'targetAttribute' => ['task_id', 'user_id'],
                'message' => '已收藏过'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_time' => 'Created Time',
            'user_id' => '收藏人',
            'task_id' => '任务',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    /**
     * @inheritdoc
     * @return TaskCollectionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskCollectionQuery(get_called_class());
    }

    public function extraFields()
    {
        return ['task'];
    }
}
