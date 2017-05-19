<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%weichat_push_set_template_push_item}}".
 *
 * @property integer $id
 * @property string $task_id
 * @property integer $template_push_id
 * @property integer $display_order
 */
class WeichatPushSetTemplatePushItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%weichat_push_set_template_push_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_push_id', 'display_order'], 'integer'],
            [['task_id'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => '任务ID，gid',
            'template_push_id' => '所属推送消息列表模板',
            'display_order' => '排序，越大越靠前',
        ];
    }
}
