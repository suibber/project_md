<?php
 
namespace api\miduoduo\v1\controllers;

use Yii;
use api\common\BaseActiveController;
use common\Utils;
use common\models\AccountEvent;
use common\models\WithdrawCash;
use common\payment\Pay;
use common\models\UserAccount;
 
/**
 * PayWithdrawController API
 *
 * @author suibber
 */
class PayWithdrawController extends BaseActiveController
{
    public $modelClass = 'common\models\AccountEvent';

    public $id_column  = 'user_id';

    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $user_id    = \Yii::$app->user->id;
        $user_account_obj = new UserAccount();
        $user_account     = $user_account_obj->getUserAccount($user_id);
        $pay_type   = $user_account->defalut_withdraw_type;

        if( $user_id ){
            $pay        = new Pay();
            $result     = $pay->withdrawAllBalance($user_id,$pay_type);  
            $user_account_obj->updateUserAccount($user_id);
        }else{
            $result    = '{ "success": false, "message": 发生错误 }';
        }
        return $result;
    }
}