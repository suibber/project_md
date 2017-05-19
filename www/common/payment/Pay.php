<?php
namespace common\payment;

use Yii;
use yii\base\Component;
use common\models\WithdrawCash;
use common\models\Payout;
use common\payment\WechatPayment;
use common\WeichatBase;
use common\models\AccountEvent;
use common\models\UserAccount;

class Pay extends Component
{
    public function withdrawAllBalance( $user_id , $pay_type ){
        $user_account_obj = new UserAccount();
        $user_account     = $user_account_obj->getUserAccount($user_id);
        if( intval($user_account->money_balance) < 10 ){
            $error_message = "提款失败，提款金额应大于10元";
            $result   = [
                'success'   => false, 
                'value'     => 0, 
                'message'   => $error_message
            ];
        }else{

            $account_data   = AccountEvent::find()
                    ->where(['user_id'=>$user_id , 'locked'=>0, 'related_id'=>''])
                    ->asArray()
                    ->all();

            $this->beforeWithdrawCash($account_data);

            if( count($account_data) ){
                if( $pay_type == WithdrawCash::TYPES_WECAHT ){
                    $withdraw_result  = $this->withdrawByWechat($account_data,$user_id);
                }else{
                    $error_message = "提款失败，目前只支持微信提款";
                }
            }else{
                $error_message = "提款失败，您的账户余额为空";
            }

            if( isset($withdraw_result['withdraw_id']) ){
                // 更新资金流水
                $accountevent   = new AccountEvent();
                $accountevent->updateAll(
                    ['related_id'=>$withdraw_result['withdraw_id']],
                    '`id` in ('.$withdraw_result['count_ids'].')'
                );
                $result   = [
                    'success'   => true, 
                    'value'     => $withdraw_result['count_value'], 
                    'message'   => '提现成功，请到微信钱包查看' 
                ];
            }else{
                $error_message  = isset($withdraw_result['error_message']) ? $withdraw_result['error_message'] : $error_message;
                $result   = [
                    'success'   => false, 
                    'value'     => 0, 
                    'message'   => $error_message
                ];
            }

            $this->afterWithdrawCash($account_data);
        }

        return $result;
    }

    // 微信提款
    public function withdrawByWechat($account_data,$user_id){
        $count_value    = 0;
        $count_ids      = '';
        foreach( $account_data as $k => $v ){
            $count_value += $v['value'];
            $count_ids   .= $v['id'].',';
        }
        $count_ids      = trim($count_ids,',');
        $date_time      = date("Y-m-d H:i:s");
        $payout_return  = $this->payOutByWechat($user_id,$count_value,$date_time,$count_ids);

        $withdraw   = new WithdrawCash();
        $withdraw->user_id          = $user_id;
        $withdraw->value            = $count_value;
        $withdraw->withdraw_time    = $date_time;
        $withdraw->type             = $withdraw::TYPES_WECAHT;
        $withdraw->payout_id        = $payout_return['payout_id'];
        $withdraw->status           = $payout_return['status'];
        $withdraw->updated_time     = $date_time;
        $withdraw->operator_id      = $user_id;
        $withdraw->save();
        if( $payout_return['status'] == WithdrawCash::STATUS_SUCCESS ){
            return [
                'withdraw_id' => $withdraw->id,
                'count_value' => $count_value,
                'count_ids' => $count_ids,
            ];
        }else{
            $error_message  = "提款失败，请联系我们";
            return ['error_message' => $error_message];
        }
    }

    // 微信支付
    public function payOutByWechat($user_id,$count_value,$date_time,$count_ids){
        $weichatbase= new WeichatBase();
        $wechat_id  = $weichatbase->getLoggedUserWeichatID($user_id);
        $gid        = $user_id .'-'. str_ireplace(',','-',$count_ids);

        $payment    = new WechatPayment;
        $pay_result = $payment->payout($wechat_id, $count_value, $gid, '米多多提现');

        $payout     = new Payout();
        if( $pay_result === false ){
            $payout_status  = Payout::STATUS_FAULT;
            $withdraw_status= WithdrawCash::STATUS_FAULT;
        }else{
            $payout_status  = Payout::STATUS_SUCCESS;
            $withdraw_status= WithdrawCash::STATUS_SUCCESS;
        }
        $payout->gid            = $gid;
        $payout->payout_time    = $date_time;
        $payout->value          = $count_value;
        $payout->type           = WithdrawCash::TYPES_WECAHT;
        $payout->account_id     = $wechat_id;
        $payout->account_owner  = $wechat_id;
        $payout->to_user_id     = $user_id;
        $payout->status         = $payout_status;
        $payout->operator_id    = $user_id;
        $payout->created_time   = $date_time;
        $payout->account_info   = '';
        $payout->save();
        
        $payout_return  = [
            'status'    => $withdraw_status,
            'payout_id' => $payout->id, 
        ];
        return $payout_return;
    }

    // 支付宝提款
    public function withdrawByAlipay($account_data,$user_id){}
    public function payOutByAlipay(){}


    // 银行卡提款
    public function withdrawByBank($account_data,$user_id){}
    public function payOutByBank(){}

    private function beforeWithdrawCash($account_data){
        $account_lock   = new AccountEvent();
        $account_ids    = '';
        foreach( $account_data as $k => $v ){
            $account_ids    .= $v['id'].',';
        }
        $account_ids = trim($account_ids,',');
        if($account_ids){
            $account_lock->updateAll(
                ['locked'=>1],
                '`id` in ('.$account_ids.')'
            );
        }
    }

    private function afterWithdrawCash($account_data){
        $account_lock   = new AccountEvent();
        $account_ids    = '';
        foreach( $account_data as $k => $v ){
            $account_ids    .= $v['id'].',';
        }
        $account_ids = trim($account_ids,',');
        if($account_ids){
            $account_lock->updateAll(
                ['locked'=>0],
                '`id` in ('.$account_ids.')'
            );
        }
    }

    public function getMoneyAll( $user_id ){
        $money  = AccountEvent::find()
            ->where(['user_id'=>$user_id])
            ->sum('value');
        $money  = $money ? $money : 0;
        return $money;
    }

    public function getMoneyBalance( $user_id ){
        $money  = AccountEvent::find()
            ->where(['user_id'=>$user_id,'related_id'=>''])
            ->sum('value');
        $money  = $money ? $money : 0;
        return $money;
    }

    public function getMoneySuccess( $user_id ){
        $money  = WithdrawCash::find()
            ->where(['user_id'=>$user_id,'status'=>WithdrawCash::STATUS_SUCCESS])
            ->sum('value');
        $money  = $money ? $money : 0;
        return $money;
    }

    public function getMoneyDoing( $user_id ){
        $money  = WithdrawCash::find()
            ->where(['user_id'=>$user_id,'status'=>WithdrawCash::STATUS_DOING])
            ->sum('value');
        $money  = $money ? $money : 0;
        return $money;
    }

}
