<?php

namespace common\models;

use Yii;
use common\models\UserReadedSysMessage;

/**
 * This is the model class for table "{{%sys_message}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $created_time
 * @property integer $type
 * @property integer $created_by
 */
class SysMessage extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['created_time'], 'safe'],
            [['type', 'created_by'], 'integer'],
            [['created_by'], 'required'],
            [['title'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'created_time' => '创建时间',
            'type' => '类型',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @inheritdoc
     * @return SysMessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SysMessageQuery(get_called_class());
    }

    public function getRead_flag()
    {
        $user_id = \Yii::$app->user->id;
        if ($user_id){
            return $this->hasOne(UserReadedSysMessage::className(),
                ['sys_message_id' => 'id'])->andWhere(['user_id' => $user_id])->exists();
        }
        return false;
    }

    public function extraFields()
    {
        return ['read_flag'];
    }


}
