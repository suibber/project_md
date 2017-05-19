<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_has_service_type}}".
 *
 * @property integer $user_id
 * @property integer $service_type_id
 */
class UserHasServiceType extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_has_service_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'service_type_id'], 'required'],
            [['user_id', 'service_type_id'], 'integer'],
            ['service_type_id', 'unique',
                'targetAttribute' => ['user_id', 'service_type_id'],
                'message' => '已添加过'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'service_type_id' => 'Service Type ID',
        ];
    }
}
