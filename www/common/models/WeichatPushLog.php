<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%weichat_push_log}}".
 *
 * @property integer $id
 * @property string $push_group
 * @property string $openid
 * @property string $create_time
 * @property string $result
 * @property string $return_msg
 */
class WeichatPushLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%weichat_push_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_time'], 'safe'],
            [['push_group', 'openid'], 'string', 'max' => 200],
            [['result'], 'string', 'max' => 100],
            [['return_msg'], 'string', 'max' => 400]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'push_group' => '推送分组（如群推200人，则这次分为一组）',
            'openid' => '用户微信ID',
            'create_time' => '推送时间',
            'result' => '推送结果',
            'return_msg' => '推送返回信息',
        ];
    }
}
