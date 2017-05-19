<?php

namespace common\models;

use Yii;

use common\models\User;

/**
 * This is the model class for table "{{%address}}".
 *
 * @property integer $id
 * @property string $province
 * @property string $city
 * @property string $district
 * @property string $address
 * @property string $lat
 * @property string $lng
 * @property integer $user_id
 * @property integer $belong_to
 */
class Address extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%address}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lat', 'lng'], 'required'],
            [['id', 'user_id', 'belong_to'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['province', 'city', 'district', 'address'], 'string', 'max' => 45],
            [['id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'province' => '省',
            'city' => '市',
            'district' => '区/县',
            'address' => '地址',
            'lat' => '纬度',
            'lng' => '经度',
            'user_id' => '用户',
            'belong_to' => '使用的地方',
        ];
    }

    /**
     * @inheritdoc
     * @return AddressQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AddressQuery(get_called_class());
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


}
