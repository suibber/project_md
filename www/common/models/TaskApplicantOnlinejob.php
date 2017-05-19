<?php

namespace common\models;

use Yii;
use common\models\Task;

/**
 * This is the model class for table "{{%task_applicant_onlinejob}}".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $app_id
 * @property integer $user_id
 * @property integer $task_id
 * @property string $needinfo
 * @property integer $has_sync_wechat_pic
 */
class TaskApplicantOnlinejob extends \yii\db\ActiveRecord
{
    public static $HAS_SYNC_WECHAT_PIC = [
        0 => '否',
        1 => '是',
    ];

    public static $STATUS = [
        0  => '等待审核',
        10 => '审核通过',
        20 => '审核不通过',
    ];

    const STATUS_UNKNOWN = 0;
    const STATUS_PASSED = 10;
    const STATUS_NOT_PASSED = 20;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_applicant_onlinejob}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'app_id', 'user_id', 'task_id', 'has_sync_wechat_pic'], 'integer'],
            [['needinfo', 'need_phonenum', 'need_username', 'need_person_idcard'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '在线任务提交id',
            'status' => '状态',
            'app_id' => '报名id',
            'user_id' => '用户id',
            'task_id' => '任务id',
            'needinfo' => '序列化的任务提交信息',
            'has_sync_wechat_pic' => '是否已经同步微信上传图片',
            'need_phonenum' => '手机号',
            'need_username' => '用户名',
            'need_person_idcard' => '身份证',
            'reason' => '未通过原因',
        ];
    }

    public function getTask(){
        return $this->hasOne(Task::className(),['id' => 'task_id']);
    }

    public function getStatus_msg(){
        if(!$this->status){
            $this->status = 0;
        }
        return $this::$STATUS[$this->status];
    }

    public function fields()
    {
        return array_merge(parent::fields(), ['status_msg']);
    }
}
