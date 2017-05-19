<?php

namespace common\models;

use Yii;
use common\models\Payout;
use common\models\Resume;
use common\models\AccountEvent;

/**
 * This is the model class for table "{{%withdraw_cash}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $value
 * @property string $withdraw_time
 * @property integer $type
 * @property integer $payout_id
 * @property integer $status
 * @property string $updated_time
 * @property string $note
 */
class WithdrawCash extends \yii\db\ActiveRecord
{
    public static $STATUS   = [
        0   => '未知',
        1   => '申请',
        2   => '结算中',
        3   => '提现完成',
        4   => '提现失败'
    ];

    const STATUS_UNKNOW = 0;
    const STATUS_APPLY  = 1;
    const STATUS_DOING  = 2;
    const STATUS_SUCCESS= 3;
    const STATUS_FAULT  = 4;

    public static $TYPES    = [
        10  => '微信',
        20  => '支付宝',
        30  => '银行卡',
    ];

    const TYPES_WECAHT  = 10;
    const TYPES_ALIPAY  = 20;
    const TYPES_BANK    = 30;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%withdraw_cash}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'payout_id', 'status'], 'integer'],
            [['value', 'type', 'status'], 'required'],
            [['value'], 'number'],
            [['withdraw_time', 'updated_time'], 'safe'],
            [['note'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '提现流水id',
            'user_id' => '用户id',
            // 姓名
            // 手机号
            // 银行卡/微信
            // 开户行
            'value' => '提现金额',
            'withdraw_time' => '申请时间',
            // 操作时间
            'type' => '打款方式',
            'payout_id' => '打款明细',
            'status' => '处理结果',
            // 操作人
            'updated_time' => '操作时间',
            'note' => '备注',
            'operator_id' => '操作人',
        ];
    }
    
    public function getStatus_label(){
        return static::$STATUS[$this->status];
    }

    public function getPayout(){
        return $this->hasOne(Payout::className(),['id'=>'payout_id']);
    }

    public function getUserinfo(){
        return $this->hasOne(Resume::className(),['user_id'=>'user_id']);
    }

    public function getOperatorinfo(){
        return $this->hasOne(Resume::className(),['user_id'=>'operator_id'])
            ->from(['operator'=>Resume::tableName()]);
    }

    public function getAccountEvent(){
        return $this->hasMany(AccountEvent::className(),['related_id'=>'id']);
    }

    public function makeExcelArr($data){
        $date_time  = date("Y-m-d H:i:s");

        $excel_arr  = array();
        $need_change_updated_time_id_arr     = array();
        $excel_arr['A1']  = '提现流水id';
        $excel_arr['B1']  = '用户id';
        $excel_arr['C1']  = '姓名';
        $excel_arr['D1']  = '手机号';
        $excel_arr['E1']  = '绑定银行卡/微信账号';
        $excel_arr['F1']  = '开户行';
        $excel_arr['G1']  = '提现金额';
        $excel_arr['H1']  = '申请时间';
        $excel_arr['I1']  = '操作时间';
        $excel_arr['J1']  = '处理结果';
        $excel_arr['K1']  = '操作人';
        foreach( $data as $k => $v ){
            $row_num    = $k+2;
            $excel_arr['A'.$row_num]  = $v->id;
            $excel_arr['B'.$row_num]  = $v->user_id;
            $excel_arr['C'.$row_num]  = isset($v->userinfo->name) ? $v->userinfo->name : '';
            $excel_arr['D'.$row_num]  = isset($v->userinfo->phonenum) ? $v->userinfo->phonenum : '';
            $excel_arr['E'.$row_num]  = $v->payout->account_id;
            $excel_arr['F'.$row_num]  = $v->payout->account_info;
            $excel_arr['G'.$row_num]  = $v->value;
            $excel_arr['H'.$row_num]  = $v->withdraw_time;
            $excel_arr['K'.$row_num]  = isset($v->operatorinfo->name) ? $v->operatorinfo->name : '';
            if( $v->status == $this::STATUS_APPLY ){
                $need_change_updated_time_id_arr[]  = $v->id;
                $excel_arr['I'.$row_num]  = $date_time;
                $excel_arr['J'.$row_num]  = static::$STATUS[$this::STATUS_DOING];
            }else{
                $excel_arr['I'.$row_num]  = $v->updated_time;
                $excel_arr['J'.$row_num]  = static::$STATUS[$v->status];
            }
        }
        $this->updateUpdatetimeByIds($need_change_updated_time_id_arr,$date_time);
        return $excel_arr;
    }

    public function updateUpdatetimeByIds($ids,$date_time){
        $this->updateAll(
            ['updated_time'=>$date_time , 'status'=>$this::STATUS_DOING] ,
            ['id'=>$ids]
        );
    }
}
