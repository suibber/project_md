<?php

namespace common\models;

use Yii;
use common\models\Task;

/**
 * This is the model class for table "{{%company}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $examined_time
 * @property integer $status
 * @property integer $examined_by
 * @property integer $user_id
 */
class Company extends \common\BaseActiveRecord
{

    static $ORIGINS = [
        0 => '其他',
        1 => '自主注册',
        2 => '抓取',
        3 => 'app注册',
    ];
    const ORIGINS_OTHER = 0;
    const ORIGINS_SELF  = 1;
    const ORIGINS_SPIDER = 2;
    const ORIGINS_APP = 3;
    
    static $STATUSES = [
        0 => '正常',
        5 => '已冻结',
        10 => '已删除',
        20 => '黑名单',
        21 => '白名单',
    ];

    const STATUS_OK = 0;
    const STATUS_FREEZED = 5;
    const STATUS_DELETED = 10;
    const STATUS_BLACKLISTED =20;
    const STATUS_WHITEISTED =21;

    static $EXAM_STATUSES = [
        0 => '未验证',
        1 => '等待审核',
        2 => '审核完成',
        10 => '审核未通过',
    ];

    static $EXAM_STATUSES_MSG = [
        0 => '您还未提交企业资料，快快提交认证吧~',
        1 => '您的资料正在审核中，请耐心等待！',
        2 => '恭喜，您的资料审核已通过！',
        10 => '抱歉，您的资料审核未通过！',
    ];

    const EXAM_TODO = 0;
    const EXAM_PROCESSING  = 1;
    const EXAM_DONE = 2;
    const EXAM_NOT_PASSED = 10;

    static $EXAM_RESULTS = [
        0 => '待认证',
        16 => '身份证验证通过',
        32 => '营业执照验证通过',
        48 => '身份证、营业执照验证通过',
    ];

    const EXAM_GOVID_UNCHECK = 0;
    const EXAM_GOVID_PASSED = 16;
    const EXAM_LICENSE_PASSED = 32;
    const EXAM_ALL_PASSED = 48;

    static $USE_TASK_LIMIT = [
        16 => 3,
        32 => 5,
        48 => 5,
    ];

    static $CORP_TYPES = [
        1 => '企业直聘',
        2 => '人力资源',
        3 => '领队',
    ];

    public function getExam_status_label()
    {
        return static::$EXAM_STATUSES[$this->exam_status];
    }

    public function getExam_result_label()
    {
        $s = '';
        if (static::EXAM_GOVID_PASSED & $this->exam_result){
            $s .= ' ' . static::$EXAM_RESULTS[static::EXAM_GOVID_PASSED];
        }
        if ($this->exam_result & static::EXAM_LICENSE_PASSED){
            $s .= ' ' . static::$EXAM_RESULTS[static::EXAM_LICENSE_PASSED];
        }
        if( !$this->exam_result ){
            $s .= ' ' . static::$EXAM_RESULTS[static::EXAM_GOVID_UNCHECK];
        }
        return $s;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%company}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id', 'status', 'examined_by', 'user_id', 'exam_result', 'city_id'], 'integer'],
            [['examined_time','use_task_date','use_task_num','person_name','corp_idcard'], 'safe'],
            [['name', ], 'string', 'max' => 500],
            [['name', 'contact_phone', 'contact_email', 'contact_name'], 'string', 'max' => 500],
            [['intro'], 'string'],
            ['contact_email', 'email'],
            ['status', 'default', 'value'=>0],
            ['contact_phone', 'match', 'pattern'=>'/^(1[345789]\d{9})|(0\d{2,3}\-?\d{7,8})$/',
                'message'=>'电话号码格式不正确.'],
            [['name', 'contact_name', 'contact_phone'], 'required'],
            [['exam_status', 'exam_result'], 'integer'],
            ['exam_note', 'string'],
            [['person_idcard_pic', 'corp_idcard_pic'], 'string'],
            ['person_idcard', 'match', 'pattern'=>'/^\d{15,18}[xX]?$/', 'message'=> '身份证号有误'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => '城市ID',
            'name' => '企业名',
            'intro'=>'公司介绍',
            'examined_time' => '审核日期',
            'examined_by' => '审核人',
            'user_id' => '用户',
            'contact_phone' => '联系电话',
            'contact_name' => '联系人',
            'contact_email' => '招聘邮箱',
            'exam_status' => '审核状态',
            'exam_status_label' => '审核状态',
            'exam_result' => '审核结果 ',
            'exam_result_label' => '审核结果 ',
            'status' => '状态',
            'status_label' => '状态',
            'corp_idcard' => '营业执照号',
            'corp_idcard_pic' => '营业执照照片',
            'person_name' => '发布人',
            'person_idcard' => '身份证号',
            'person_idcard_pic' => '身份证照片',
            'use_task_date' => '最近一次操作职位日期（增、改、刷新）',
            'use_task_num'  => '最近一次操作职位当天，操作次数',
            'created_time' => '创建时间',
            'origin' => '渠道来源',
        ];
    }

    /**
     * @inheritdoc
     * @return CompanyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyQuery(get_called_class());
    }

    public function getStatus_label()
    {
        return static::$STATUSES[$this->status];
    }

    /**
     * @inheritdoc
     */
    public static function findByCurrentUser()
    {
        return static::findOne(['user_id' => Yii::$app->user->id]);
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord){
            $user_id = Yii::$app->user->id;
            $this->user_id = $user_id;
        }
        return parent::beforeSave($insert);
    }

    public static function createCompanyWithCurrentUser(){
        $company = new Company;
        $company->user_id = Yii::$app->user->id;
        if ($company->save()){
            return $company;
        }
        return false;
    }

    public static function updateContactInfo($name, $phone, $email, $contact)
    {
        $company = static::findByCurrentUser();
        if (!$company) {
            //we build a company for first visit
            $company = static::createCompanyWithCurrentUser();
        }
        if (!$company) {
            return false;
        }
        $company->name = $name;
        $company->contact_phone = $phone;
        $company->contact_email = $email;
        $company->contact_name = $contact;
        return $company->save();
    }

    public function fields()
    {
        $fs = parent::fields();
        unset($fs['contact_phone']);
        return array_merge($fs, ['status_label', 'exam_status_label', 'exam_result_label']);
    }

    public function asArray()
    {
        $arr = [];
        foreach ($this->fields as $fname ){
            $arr[] = $this->$fname;
        }
        return $arr;
    }

    public function getUseTaskLimit($exam_result){
        if( isset(static::$USE_TASK_LIMIT[$exam_result]) ){
            return static::$USE_TASK_LIMIT[$exam_result];
        }else{
            return 1;
        }
    }

    public function getConpanyStatusLabel($status){
        if( isset(static::$STATUSES[$status]) ){
            return static::$STATUSES[$status];
        }else{
            return 0;
        }
    }

    public static function updateUseTaskNum(){
        $user_id = Yii::$app->user->id;
        $company = Company::findOne(['user_id' => $user_id]);
        $use_task_num = $company->use_task_num + 1;
        Company::updateAll(['use_task_num' => $use_task_num], ['user_id' => $user_id]);
    }

    public function updateNeedcheckToPass($company_id){
        Task::updateAll(['status' => Task::STATUS_OK],"status='".Task::STATUS_IS_CHECK."' AND company_id='".$company_id."'");
    }
}
