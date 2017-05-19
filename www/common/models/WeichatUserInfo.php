<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\Resume;
use common\models\UserHistoricalLocation;

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
 * @property integer $is_receive_nearby_msg
 * @property integer $origin_type
 * @property string $origin_detail
 */
class WeichatUserInfo extends \yii\db\ActiveRecord
{
    public static $STATUSES = [
        0   => '正常',
        10  => '取消关注',
    ];

    const STATUS_OK = 0;
    const STATUS_CANCEL = 10;

    public static $IS_RECEIVE_NEARBY_MSG = [
        1   => '是',
        0   => '否',
    ];

    const IS_RECEIVE_NEARBY_MSG_YES = 1;
    const IS_RECEIVE_NEARBY_MSG_NO  = 0;

    public static $ORIGIN_TYPES = [
        0  => '未知', 
        10 => '用户红包', 
        20 => 'PC任务',
    ];

    const ORIGIN_TYPES_UNKNOW = 0;
    const ORIGIN_TYPES_REDPACKET = 10;
    const ORIGIN_TYPES_PC_TASK = 20;

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
            [['userid', 'status', 'is_receive_nearby_msg', 'origin_type'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['openid', 'weichat_name', 'weichat_head_pic', 'origin_detail'], 'string', 'max' => 200],
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
            'openid' => '微信与公众号唯一关系ID',
            'userid' => '用户ID',
            'status' => '状态',
            'created_time' => '创建时间',
            'updated_time' => '更新时间',
            'weichat_name' => '用户微信姓名',
            'weichat_head_pic' => '用户微信头像',
            'is_receive_nearby_msg' => '是否接收微信附近兼职的推送',
            'origin_type' => '渠道来源-分类',
            'origin_detail' => '渠道来源-详情',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }

    public function getUser_historical_location(){
        return $this->hasOne(UserHistoricalLocation::className(),['user_id'=>'userid'])
            ->addOrderBy(['id'=> SORT_DESC]);
    }

    public function getResume(){
        return $this->hasOne(Resume::className(),['user_id'=>'userid']);
    }

    public static function SwitchSubscribeDailyPush($openid=1,$switchto=1){
        WeichatUserInfo::updateAll(['is_receive_nearby_msg'=>$switchto],['openid'=>$openid]);
    }
}
