<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%weichat_autoresponse}}".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $status
 * @property string $keywords
 * @property string $response_msg
 * @property string $created_time
 * @property string $updated_time
 */
class WeichatAutoresponse extends \yii\db\ActiveRecord
{
    public static $TYPE = [
        2   => '自动回复',
        1   => '关注',
        3   => '无内容',
    ];

    public static $STATUS   = [
        1   => '有效',
        0   => '无效',
    ];
    

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%weichat_autoresponse}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['keywords', 'response_msg'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '类型',
            'status' => '状态',
            'keywords' => '关键字 请用半角,隔开',
            'response_msg' => '自动回复内容',
            'created_time' => '创建时间',
            'updated_time' => '修改时间',
        ];
    }

    public function getType_label(){
        return static::$TYPE[$this->type];
    }

    public function getStatus_label(){
        return static::$STATUS[$this->status];
    }
}
