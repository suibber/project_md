<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $read_flag
 * @property string $message
 * @property string $title
 * @property string $created_time
 * @property integer $has_sent
 * @property integer $type
 * @property integer $link
 */
class Message extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'message', 'title'], 'required'],
            [['user_id', 'read_flag', 'has_sent', 'type'], 'integer'],
            [['message', 'link'], 'string'],
            [['created_time'], 'safe'],
            [['title'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'read_flag' => 'Read Flag',
            'message' => 'Message',
            'title' => 'Title',
            'created_time' => '创建时间',
            'has_sent' => '已发送',
            'type' => 'Type',
        ];
    }

    /**
     * @inheritdoc
     * @return MessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MessageQuery(get_called_class());
    }
}
