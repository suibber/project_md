<?php

namespace common\models;

use Yii;
use common\models\Task;

/**
 * This is the model class for table "{{%weichat_push_quality_task}}".
 *
 * @property integer $id
 * @property string $gid
 * @property string $title
 * @property string $company_name
 * @property string $task_name
 * @property string $task_type
 * @property string $location
 * @property string $price
 * @property string $created_time
 * @property string $updated_time
 * @property integer $has_pushed
 * @property string $pushed_time
 * @property string $push_group
 */
class WeichatPushQualityTask extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%weichat_push_quality_task}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_time', 'updated_time', 'pushed_time', 'work_time', 'work_detail'], 'safe'],
            [['has_pushed'], 'integer'],
            [['gid', 'task_type', 'location', 'price', 'push_group'], 'string', 'max' => 100],
            [['title', 'company_name', 'task_name'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gid' => '具体任务的gid',
            'title' => '消息标题',
            'company_name' => '公司名称',
            'task_name' => '任务名称',
            'task_type' => '任务类别',
            'location' => '工作地点',
            'price' => '薪资',
            'created_time' => '创建时间',
            'updated_time' => '修改时间',
            'has_pushed' => '是否推送过',
            'pushed_time' => '推送时间',
            'push_group' => '推送分组，用于查看日志中本次推送的相关数据',
            'work_time' => '工作时间',
            'work_detail' => '工作内容',
        ];
    }

    public function getTask(){
        return $this::hasOne(Task::className(), ['gid'=>'gid']);
    }
}
