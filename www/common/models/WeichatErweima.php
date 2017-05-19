<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%weichat_erweima}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $comment
 * @property integer $type
 * @property string $create_time
 * @property string $update_time
 * @property string $scene_id
 * @property string $ticket
 * @property string $after_msg
 */
class WeichatErweima extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%weichat_erweima}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['title', 'ticket'], 'string', 'max' => 200],
            [['comment'], 'string', 'max' => 400],
            [['scene_id'], 'string', 'max' => 100],
            [['after_msg'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '二维码名称',
            'comment' => '二维码描述',
            'type' => '二维码类型，1-临时二维码7天有效，2-永久有效果仅能生成10W个',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'scene_id' => '微信场景ID，用户扫描二维码后，微信推送消息附带此参数',
            'ticket' => '生成的二维码船票，用这个就能得到二维码了',
            'after_msg' => '用户扫码关注后订阅号推送的消息内容',
        ];
    }
}
