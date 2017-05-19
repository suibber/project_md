<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%task_onlinejob}}".
 *
 * @property integer $id
 * @property integer $task_id
 * @property string $name
 * @property string $intro
 * @property string $download_android
 * @property string $download_ios
 * @property integer $audit_cycle
 */
class TaskOnlinejob extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_onlinejob}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id'], 'required'],
            [['task_id', 'audit_cycle'], 'integer'],
            [['name', 'download_android', 'download_ios'], 'string', 'max' => 200],
            [['intro'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '在线任务ID',
            'task_id' => '任务',
            'name' => '名称',
            'intro' => '介绍',
            'download_android' => '安卓下载链接',
            'download_ios' => 'IOS下载链接',
            'audit_cycle' => '审核周期',
        ];
    }
}
