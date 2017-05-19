<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%weichat_push_set_pushset}}".
 *
 * @property integer $id
 * @property integer $push_time
 * @property integer $push_way
 * @property integer $status
 * @property integer $template_push_id
 * @property integer $template_weichat_id
 * @property string $created_time
 * @property string $update_time
 * @property string $latest_push_time
 * @property string $latest_push_group
 */
class WeichatPushSetPushset extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%weichat_push_set_pushset}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['push_time', 'push_way', 'status', 'template_push_id', 'template_weichat_id'], 'integer'],
            [['created_time', 'update_time', 'latest_push_time'], 'safe'],
            [['latest_push_group'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'push_time' => '推送时间选择',
            'push_way' => '选择推送方式',
            'status' => '状态',
            'template_push_id' => '选择推送消息列表模板',
            'template_weichat_id' => '选择对应的微信模板',
            'created_time' => '创建时间',
            'update_time' => '更新时间',
            'latest_push_time' => '上次推送时间',
            'latest_push_group' => '上次推送分组，用于查看日志中本次推送的相关数据',
        ];
    }
}
