<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%weichat_user_log}}".
 *
 * @property integer $id
 * @property string $openid
 * @property string $created_time
 * @property integer $event_type
 */
class WeichatUserLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%weichat_user_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_time'], 'safe'],
            [['event_type'], 'integer'],
            [['openid'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'openid' => '微信ID',
            'created_time' => '创建时间',
            'event_type' => '事件类型(1关注、2取消关注)',
        ];
    }
}
