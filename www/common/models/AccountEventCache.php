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
use common\models\AccountEvent;

/**
 * This is the model class for table "{{%account_event_cache}}".
 *
 * @property integer $id
 * @property string $date
 * @property integer $user_id
 * @property string $value
 * @property integer $operator_id
 * @property string $created_time
 * @property string $balance
 * @property integer $type
 * @property string $note
 * @property string $related_id
 * @property string $task_gid
 * @property integer $locked
 */
class AccountEventCache extends \yii\db\ActiveRecord
{
    public static $TYPES = [
        0 => '导入',
        10 => '微信推广红包',
        20 => '提现',
    ];

    const TYPES_UPLOAD      = 0;
    const TYPES_WEICHAT_RECOMMEND  = 10;
    const TYPES_WITHDRAW    = 20;

    public static $LOCKEDS = [
        0 => '否',
        1 => '是',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_event_cache}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'created_time'], 'safe'],
            [['user_id', 'operator_id', 'type', 'locked'], 'integer'],
            [['value', 'operator_id', 'balance', 'type'], 'required'],
            [['value', 'balance'], 'number'],
            [['note'], 'string', 'max' => 400],
            [['related_id', 'task_gid'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'date' => '日期',
            'user_id' => '用户id',
            'value' => '金额',
            'operator_id' => '创建人',
            'created_time' => '上传时间',
            'balance' => '余额',
            'type' => '变更原因类型',
            'note' => '备注',
            'related_id' => '关联id（提现id 或 任务id）',
            'task_gid' => '任务id',
            'locked' => '处理中，锁住',
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

    /**************上传流水 begin*******************/
    public function saveUploadData($excel_data){
        $import_data    = array();
        $errmsg         = "";
        $date_time      = date("Y-m-d H:i:s");
        foreach( $excel_data as $k => $v ){
            if( $k == 1 ){
                continue;
            }else{
                $saverow = $this->saveUploadDataByRow($v,$k,$date_time);
                if( $saverow['result'] === true ){
                    $import_data[]   = $saverow['data'];
                }else{
                    $errmsg    .= $saverow['errmsg'];
                }
            }
        }
        if( $errmsg ){
            $errmsg   = "未导入信息：<br />".$errmsg;
        }
        return ['result'=>true,'import_data'=>$import_data,'errmsg'=>$errmsg];
    }

    public function saveUploadDataByRow($data,$key,$date_time){
        $data['A']  = substr(trim($data['A']),-10);
        $check_date = preg_match("/\d{4}-\d{2}-\d{2}/is",$data['A']);
        if( $check_date ){
            // 验证用户信息是否正确
            $user_id_obj= User::find()->where(['username'=>$data['D']])->one();
            $user_id    = isset($user_id_obj->id) ? $user_id_obj->id : 0;
            $user_info  = Resume::find()
                ->where([
                    'name'=>$data['C'],
                    'user_id'=>$user_id,
                ])
                ->one();
            if( $user_info ){
                // 验证任务和用户是否对应正确
                $task_applicant_obj = new TaskApplicant();
                $is_user_apply      = $task_applicant_obj->findBySql("
                    SELECT t.title
                    FROM jz_task_applicant a
                    LEFT JOIN jz_task t ON a.task_id=t.id
                    WHERE a.user_id=".$user_info->user_id." AND t.gid='".$data['B']."'")
                    ->asArray()->one();
                if( $is_user_apply['title'] ){
                    // 验证是否重复录入
                    $account_chongfu    = AccountEvent::find()->where([
                        //'date'      => $data['A'], 
                        'user_id'   => $user_info->user_id,
                        'value'     => $data['E'],
                        'task_gid'  => $data['B'],
                        'note'      => $data['F'],
                    ])->one();
                    $account_chongfu2    = AccountEventCache::find()->where([
                        //'date'      => $data['A'], 
                        'user_id'   => $user_info->user_id,
                        'value'     => $data['E'],
                        'task_gid'  => $data['B'],
                        'note'      => $data['F'],
                    ])->one();
                    if( $account_chongfu || $account_chongfu2 ){
                        $errmsg    = "第[".$key."]行：用户ID[".$data['D']."]，重复录入<br />";
                    }else{
                        return $this->saveUploadDataByRowSaveIt($data,$is_user_apply['title'],$user_info,$date_time);
                    }
                }else{
                    $errmsg    = "第[".$key."]行：用户ID[".$data['D']."]，报名信息不匹配<br />";
                }
            }else{
                $errmsg    = "第[".$key."]行：用户ID[".$data['D']."]，用户信息不匹配<br />"; 
            }
        }else{
            $errmsg    = "第[".$key."]行：用户ID[".$data['D']."]，日期格式有误<br />";
        }

        return ['result'=>false,'errmsg'=>$errmsg];
    }

    public function saveUploadDataByRowSaveIt($data,$task_title,$user_info,$date_time){
        $model           = new AccountEventCache();
        $model->date     = Yii::$app->office_phpexcel->dateExceltoPHP($data['A']);
        $model->user_id  = $user_info->user_id;
        $model->value    = $data['E'];
        $model->note     = $data['F'];
        $model->operator_id  = Yii::$app->user->id;
        $model->created_time = $date_time;
        $model->task_gid     = $data['B'];
        $model->related_id   = '';
        $model->balance  = 0;
        $model->type     = 0;
        $model->save();
        $data               = $model->toArray();
        $data['task_title'] = $task_title;
        $data['user_name']  = $user_info->name;
        $data['user_pbone'] = $user_info->phonenum;
        
        return ['result'=>true,'data'=>$data];
    }
    /**************上传流水 end*******************/

    /**************发放工资 begin*******************/
    public function saveDataToAccountEvent($account_envents){
        $errmsg = '';
        foreach( $account_envents as $k => $v ){
            // 验证是否重复录入
            $account_chongfu    = AccountEvent::find()->where([
                'date'      => $v['date'],
                'user_id'   => $v['user_id'],
                'value'     => $v['value'],
                'task_gid'  => $v['task_gid'],
                'note'      => $v['note'],
            ])->one();
            if( !$account_chongfu ){
                $this->saveDataToAccountEventByRow($v,$v['note'],$v['userinfo']);
            }else{
                $errmsg    .= "ID=".$v['id']." 重复，发放失败！ <br />";
            }
        }
        return $errmsg;
    }

    private function saveDataToAccountEventByRow($data,$task_title,$user_info){
        $model          = new AccountEvent();
        $model->date     = $data['date'];
        $model->user_id  = $data['user_id'];
        $model->value    = $data['value'];
        $model->note     = $data['note'];
        $model->operator_id  = $data['operator_id'];
        $model->created_time = $data['created_time'];
        $model->task_gid     = $data['task_gid'];
        $model->related_id   = '';
        $model->balance  = 0;
        $model->type     = 0;
        $model->save();

        // delete AccountEventCache record
        if( $model->id > 0 ){
            AccountEventCache::deleteAll(['id'=>$data['id']]);
        }

        // update user_account
        $user_account_obj = new UserAccount();
        $user_account_obj->updateUserAccount($model->user_id);

        // send weichat notice
        $weichat_base   = new WeichatBase();
        $pusher_weichat_id       = $weichat_base::getLoggedUserWeichatID($data['user_id']);
        $pusher_date['first']    = '您好，您有一笔兼职收入到账';
        $pusher_date['keyword1'] = $task_title;
        $pusher_date['keyword2'] = $model->value.'元';
        $pusher_date['keyword3'] = $model->created_time;
        $pusher_date['remark']   = '您可以点击通知查看收入详情。';
        $pusher_task_gid         = $model->task_gid;
        Yii::$app->wechat_pusher->accountEventIn($pusher_date,$pusher_task_gid,$pusher_weichat_id);
        
        return true;
    }
    /**************发放工资 end*******************/
}
