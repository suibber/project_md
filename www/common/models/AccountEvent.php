<?php

namespace common\models;

use Yii;
use common\models\TaskApplicant;
use common\models\User;
use common\models\Resume;
use common\models\WithdrawCash;
use common\models\Payout;
use common\BaseActiveRecord;
use common\WeichatBase;

/**
 * This is the model class for table "{{%account_event}}".
 *
 * @property integer $id
 * @property string $date
 * @property integer $user_id
 * @property string $value
 * @property string $created_time
 * @property string $balance
 * @property integer $type
 * @property string $note
 * @property integer $related_id
 */
class AccountEvent extends BaseActiveRecord
{
    public static $TYPES = [
        0 => '导入',
        10 => '微信推广红包',
        20 => '提现',
        30 => '在线任务',
    ];

    const TYPES_UPLOAD      = 0;
    const TYPES_WEICHAT_RECOMMEND  = 10;
    const TYPES_WITHDRAW    = 20;
    const TYPES_ONLINEJOB   = 30;

    public static $LOCKEDS = [
        0 => '否',
        1 => '是',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_event}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'created_time'], 'safe'],
            [['user_id', 'type', 'related_id','locked'], 'integer'],
            [['value', 'balance', 'type'], 'required'],
            [['value', 'balance'], 'number'],
            [['task_gid'], 'string'],
            [['note'], 'string', 'max' => 400]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '流水id',
            'date' => '日期',
            'user_id' => '用户id',
            'value' => '金额',
            'created_time' => '上传时间',
            'balance' => '余额',
            'type' => '变更原因类型',
            'note' => '备注',
            'related_id' => '提现id',
            'task_gid' => '任务id',
            'locked'    => '锁住',
        ];
    }

    public function getAccounts(){
        return $this->hasMany($this::className(), ['user_id' => 'user_id']);
    }

    public function getUserinfo(){
        return $this->hasOne(Resume::className(),['user_id' => 'user_id']);
    }

    public function getOperator(){
        return $this->hasOne(Resume::className(),['user_id' => 'operator_id']);
    }

    public function getInvitee(){
        return $this->hasOne(User::className(),['id' => 'red_packet_accept_by']);
    }

    public function extraFields(){
        return ['accounts'];
    }

}
