<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%contact_us}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $created_time
 * @property string $phonenum
 * @property integer $status
 */
class ContactUs extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contact_us}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['created_time'], 'safe'],
            [['phonenum', 'content'], 'required'],
            [['status'], 'integer'],
            [['title', 'phonenum'], 'string', 'max' => 100],
            ['status', 'default', 'value'=>0],
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
            'phonenum' => '手机号',
            'status' => '状态',
        ];
    }

    /**
     * @inheritdoc
     * @return ContactUsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContactUsQuery(get_called_class());
    }
}
