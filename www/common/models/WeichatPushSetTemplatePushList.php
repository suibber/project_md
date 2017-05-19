<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%weichat_push_set_template_push_list}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $created_time
 * @property string $updated_time
 * @property integer $status
 * @property integer $create_user
 */
class WeichatPushSetTemplatePushList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%weichat_push_set_template_push_list}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_time', 'updated_time'], 'safe'],
            [['status', 'create_user'], 'integer'],
            [['title'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '模板标题',
            'created_time' => '创建时间',
            'updated_time' => '修改时间',
            'status' => '状态（1正常，0删除）',
            'create_user' => '创建人',
        ];
    }

    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['gid' => 'task_id'])
            ->viaTable(WeichatPushSetTemplatePushItem::tableName(), ['template_push_id'=>'id']);
    }

    public function extraFields()
    {
        return ['tasks'];
    }
}
