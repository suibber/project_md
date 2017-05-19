<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%device}}".
 *
 * @property integer $id
 * @property integer $type
 * @property string $device_id
 * @property integer $user_id
 * @property string $push_id
 * @property string $updated_time
 * @property string $created_time
 * @property string $access_token
 * @property string $device_info
 * @property string $app_version
 */
class Device extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%device}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'user_id'], 'integer'],
            [['device_id'], 'required'],
            [['updated_time'], 'safe'],
            [['device_id', 'push_id', 'access_token'], 'string', 'max' => 500],
            [['created_time', 'app_version'], 'string', 'max' => 45],
            [['device_info'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '设备类型',
            'device_id' => 'Device ID',
            'user_id' => '用户',
            'push_id' => '推送id',
            'updated_time' => '修改时间',
            'created_time' => '创建时间',
            'access_token' => 'Access Token',
            'device_info' => '设备信息',
            'app_version' => 'App Version',
        ];
    }

    /**
     * @inheritdoc
     * @return DeviceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DeviceQuery(get_called_class());
    }
}
