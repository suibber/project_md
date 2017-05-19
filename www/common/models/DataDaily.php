<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%data_daily}}".
 *
 * @property integer $id
 * @property integer $type
 * @property string $date
 * @property string $key
 * @property integer $value
 * @property string $create_time
 * @property string $update_time
 * @property integer $city_id
 */
class DataDaily extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%data_daily}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'city_id'], 'integer'],
            [['date', 'value', 'create_time', 'update_time'], 'safe'],
            [['key'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '统计分类，1：核心指标-用户端、2：核心指标-职位、3：微信日报',
            'date' => '统计的日期',
            'key' => '统计项',
            'value' => '统计数值',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'city_id' => '城市维度',
        ];
    }
}
