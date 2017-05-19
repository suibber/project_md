<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%task_notice}}".
 *
 * @property integer $id
 * @property integer $task_id
 * @property integer $type
 * @property string $meet_time
 * @property string $place
 * @property string $linkman
 * @property string $phone
 * @property string $created_time
 * @property string $updated_time
 */
class TaskNotice extends \yii\db\ActiveRecord
{

    public static $TYPE = [
        1 => '面试',
        2 => '培训',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_notice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id'], 'required'],
            [['task_id', 'type'], 'integer'],
            [['meet_time', 'created_time', 'updated_time'], 'safe'],
            [['place'], 'string', 'max' => 500],
            [['linkman', 'phone'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => '任务ID（1对1关系）',
            'type' => '类型：面试、培训',
            'meet_time' => '约定时间',
            'place' => '约定地点',
            'linkman' => '联系人姓名',
            'phone' => '联系人电话',
            'created_time' => '创建时间',
            'updated_time' => '修改时间',
        ];
    }
}
