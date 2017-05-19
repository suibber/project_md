<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_readed_sys_message}}".
 *
 * @property integer $sys_message_id
 * @property integer $user_id
 */
class UserReadedSysMessage extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_readed_sys_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sys_message_id', 'user_id'], 'required'],
            [['sys_message_id', 'user_id'], 'integer'],
            [['user_id', 'sys_message_id'], 'unique', 'targetAttribute' => ['user_id', 'sys_message_id'], 'message' => '用户已读']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sys_message_id' => '系统消息Id',
            'user_id' => '用户ID',
        ];
    }
}
