<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_historical_location}}".
 *
 * @property integer $id
 * @property double $lng
 * @property double $lat
 * @property string $created_time
 * @property integer $user_id
 * @property integer $city_id
 *
 * @property User $user
 */
class UserHistoricalLocation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_historical_location}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lng', 'lat'], 'number'],
            [['created_time'], 'safe'],
            [['user_id', 'city_id'], 'required'],
            [['user_id', 'city_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lng' => 'Lng',
            'lat' => 'Lat',
            'created_time' => 'Created Time',
            'user_id' => 'User ID',
            'city_id' => 'City ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getCity()
    {
        return $this->hasOne(District::className(), ['id' => 'city_id']);
    }

    /**
     * @inheritdoc
     * @return UserHistoricalLocationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserHistoricalLocationQuery(get_called_class());
    }
}
