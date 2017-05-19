<?php

namespace common\models;

use Yii;
use common\payment\Pay;
use common\models\WithdrawCash;
use common\models\Resume;

/**
 * This is the model class for table "{{%user_account}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $defalut_withdraw_type
 * @property string $money_all
 * @property string $money_balance
 * @property string $money_success
 * @property string $money_doing
 * @property string $updated_time
 */
class UserAccount extends \yii\db\ActiveRecord
{
    public static $DEFAULT_WITHDRAW_TYPES    = [
        10  => '微信',
        20  => '支付宝',
        30  => '银行卡',
    ];

    const DEFAULT_WITHDRAW_TYPES_WECAHT  = 10;
    const DEFAULT_WITHDRAW_TYPES_ALIPAY  = 20;
    const DEFAULT_WITHDRAW_TYPES_BANK    = 30;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_account}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'defalut_withdraw_type'], 'integer'],
            [['money_all', 'money_balance', 'money_success', 'money_doing'], 'number'],
            [['updated_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'defalut_withdraw_type' => '默认提款方式',
            'money_all' => '全部收入',
            'money_balance' => '可提现收入',
            'money_success' => '已提现收入',
            'money_doing' => '提现中收入',
            'updated_time' => '更新时间',
        ];
    }

    public function getDefalutwithdrawtype_label(){
        return static::$DEFAULT_WITHDRAW_TYPES[$this->defalut_withdraw_type];
    }

    public function getUserinfo(){
        return $this->hasOne(Resume::className(),['user_id'=>'user_id']);
    }

    public function updateUserAccount($user_id){
        $user_account     = $this->find()->where(['user_id'=>$user_id])->one();
        if( !$user_account ){
            $pay    = new Pay();
            $this->money_all      = $pay->getMoneyAll($user_id);
            $this->money_balance  = $pay->getMoneyBalance($user_id);
            $this->money_success  = $pay->getMoneySuccess($user_id);
            $this->money_doing    = $pay->getMoneyDoing($user_id);
            $this->defalut_withdraw_type = WithdrawCash::TYPES_WECAHT;

            $this->user_id  = $user_id;
            $this->save();
            return $this;
        }else{
            $pay    = new Pay();
            $user_account->money_all      = $pay->getMoneyAll($user_id);
            $user_account->money_balance  = $pay->getMoneyBalance($user_id);
            $user_account->money_success  = $pay->getMoneySuccess($user_id);
            $user_account->money_doing    = $pay->getMoneyDoing($user_id);

            $user_account->update();
            return $this;
        }
    }

    public function getUserAccount($user_id){
        $user_account     = $this->find()->where(['user_id'=>$user_id])->one();
        if( !$user_account ){
            $pay    = new Pay();
            $this->money_all      = $pay->getMoneyAll($user_id);
            $this->money_balance  = $pay->getMoneyBalance($user_id);
            $this->money_success  = $pay->getMoneySuccess($user_id);
            $this->money_doing    = $pay->getMoneyDoing($user_id);
            $this->defalut_withdraw_type = WithdrawCash::TYPES_WECAHT;

            $this->user_id  = $user_id;
            $this->save();
            return $this;
        }else{
            return $user_account;
        }
    }
}
