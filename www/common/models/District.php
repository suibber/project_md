<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%district}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $level
 * @property string $citycode
 * @property string $postcode
 * @property string $center
 * @property string $full_name
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%district}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'level', 'postcode', 'center'], 'required'],
            [['id', 'parent_id', 'is_hot', 'is_alive'], 'integer'],
            [['name', 'level', 'center', 'full_name', 'pinyin', 'short_pinyin', 'short_name'], 'string'],
            [['citycode'], 'string', 'max' => 10],
            [['postcode'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'level' => 'Level',
            'citycode' => 'Citycode',
            'postcode' => 'Postcode',
            'center' => 'Center',
            'full_name' => 'Full Name',
        ];
    }

    /**
     * @inheritdoc
     * @return DistrictQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DistrictQuery(get_called_class());
    }

    public static function getCities()
    {
        return District::find()->where(['level'=>'city', 'disabled'=>false])->all();
    }
    public static function getDistricts($city_id)
    {
        return District::find()->where(['parent_id'=>$city_id, 'disabled'=>false])->all();
    }

    public function fields()
    {
        return ['id', 'short_name', 'pinyin', 'short_pinyin', 'is_hot', 'is_alive', 'name','seo_pinyin'];
    }

}
