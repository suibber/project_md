<?php
namespace m\models;

use common\BaseActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%weichat_user_info}}".
 *
 * @property integer $id
 * @property string $openid
 * @property integer $userid
 * @property integer $status
 * @property string $created_time
 * @property string $updated_time
 * @property string $weichat_name
 * @property string $weichat_head_pic
 */
class WeichatUserInfo extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%weichat_user_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'status'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['openid', 'weichat_name', 'weichat_head_pic'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'openid' => '微信与公众号唯一关系ID',
            'userid' => '用户ID',
            'status' => '状态',
            'created_time' => '创建时间',
            'updated_time' => '更新时间',
            'weichat_name' => '用户微信姓名',
            'weichat_head_pic' => '用户微信头像',
        ];
    }
}
