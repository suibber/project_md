<?php

namespace common\models;

use Yii;
use ReflectionClass;
use common\models\TaskAddress;
use common\models\TaskApplicant;
use common\models\Resume;
use common\models\Company;
use common\models\District;
use common\models\ServiceType;
use common\models\ConfigRecommend;
use common\models\WeichatPushSetTemplatePushItem;
use common\models\TaskNotice;
use common\models\TaskOnlinejobNeedinfo;
use common\models\TaskOnlinejob;
use common\models\Tasktime;

/**
 * This is the model class for table "{{%task}}".
 *
 * @property integer $id
 * @property string $gid
 * @property string $title
 * @property integer $clearance_period
 * @property string $salary
 * @property integer $salary_unit
 * @property string $salary_note
 * @property string $from_date
 * @property int $company_id
 * @property string $contact;
 * @property string $contact_phonenum;
 * @property string $to_date
 * @property string $from_time
 * @property string $to_time
 * @property integer $need_quantity
 * @property integer $got_quantity
 * @property string $created_time
 * @property string $updated_time
 * @property string $detail
 * @property string $requirement
 * @property string $address
 * @property integer $user_id
 * @property integer $service_type_id
 * @property integer $gender_requirement
 * @property integer $degree_requirement
 * @property integer $age_requirement
 * @property integer $height_requirement
 * @property integer $status
 * @property integer $city_id
 * @property integer $district_id
 * @property string $origin
 * @property string $labels_str
 */
class Task extends \common\BaseActiveRecord
{

    public static $CLEARANCE_PERIODS = [
        0=>'月结',
        1=>'周结',
        2=>'日结',
        3=>'完工结',
        4=>'按单结算',
    ];

    public static $SALARY_UNITS = [
        0=>'小时',
        1=>'天',
        2=>'周',
        3=>'月',
        4=>'次',
        5=>'单',
        6=>'个',
    ];

    public static $GENDER_REQUIREMENT = [
    	0=>'男女不限',
    	1=>'男',
    	2=>'女',
    ];

    public static $HEIGHT_REQUIREMENT = [
    	0=>'身高无要求',
    	1=>'155cm以上',
    	2=>'165cm以上',
    	3=>'170cm以上',
    	3=>'175cm以上',
    ];

    public static $FACE_REQUIREMENT = [
    	0=>'形象无要求',
    	1=>'形象好',
    	2=>'形象非常好',
    ];

    public static $TALK_REQUIREMENT = [
    	0=>'沟通能力无要求',
    	1=>'沟通能力强',
    ];

    public static $HEALTH_CERTIFICATED = [
    	0=>'健康证无要求',
    	1=>'有健康证',
    ];

    public static $DEGREE_REQUIREMENT = [
    	0=>'学历无要求',
    	1=>'高中',
    	2=>'大专',
    	3=>'本科',
    	4=>'本科以上',
    ];

    public static $WEIGHT_REQUIREMENT = [
    	0=>'体重无要求',
    	1=>'60kg以下',
    	2=>'60-65kg',
    	3=>'65-70kg',
    	4=>'70-75kg',
    ];


    public static $STATUSES = [

        0=>'正常',
        30=>'审核中',
        40=>'审核未通过',
        50=>'过期',

        10=>'已下线',
        20=>'已删除',
        100=>'爬取需编辑',
    ];

    public static $RECOMMEND=[
       0=>'否',
       1=>'是',
    ];

    public static $ORIGIN=[
        'xiaolianbang' => '校联邦',
        'jianzhimao' => '兼职猫',
        'internal'=>'站内添加',
        'corp'=>'企业',
    ];

    const ORIGIN_INTERNAL = 'internal';
    const ORIGIN_CORP = 'corp';

    const STATUS_OK = 0;
    const STATUS_IS_CHECK = 30;
    const STATUS_UN_PASSED = 40;
    const STATUS_OVERDUE = 50;
    const STATUS_OFFLINE = 10;
    const STATUS_DELETED = 20;
    const STATUS_UNCONFIRMED_FROM_SPIDER = 100;


    public function getStatus_label()
    {
        if ($this->is_overflow){
            return $this->is_overflow_label;
        }
        return static::$STATUSES[$this->status];
    }
    public function getOrigin_label()
    {
        return static::$ORIGIN[$this->origin];
    }

    public function getClearance_period_label()
    {
        return static::$CLEARANCE_PERIODS[$this->clearance_period];
    }

    public function getRecommend_label(){
        return static::$RECOMMEND[$this->recommend];
    }

    public function getSalary_unit_label()
    {
        return static::$SALARY_UNITS[$this->salary_unit];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salary', 'salary_unit',
                'need_quantity', 'detail',
                'title', 'service_type_id'], 'required'],
            // ['company_id', 'required', 'message'=>'请选择一个已存在的公司'],
            [['id', 'clearance_period', 'salary_unit', 'need_quantity',
                'got_quantity', 'user_id', 'service_type_id',
                'city_id', 'district_id',
                'status',
                'company_id','recommend'], 'integer'],
            [['salary'], 'number'],
            [['salary_note', 'detail', 'requirement', 'origin'], 'string'],
            [['from_date', 'to_date', 'from_time', 'to_time',
                'created_time', 'updated_time'], 'safe'],
            [['gid'], 'string', 'max' => 1000],
            [['title', 'address'], 'string', 'max' => 500],
            ['got_quantity', 'default', 'value'=>0],
            ['status', 'default', 'value'=>0],
            [['contact', 'contact_phonenum'], 'required'],
            ['contact_phonenum', 'match', 'pattern'=>'/^(1[345789]\d{9})|(\d{3,4}\-?\d{7,8})$/',
                'message'=>'请输入正确的电话'],
            ['clearance_period', 'default', 'value'=>0],
            ['origin', 'default', 'value'=>'internal'],
            [['gender_requirement', 'degree_requirement', 'age_requirement',
                'face_requirement', 'talk_requirement', 'health_certificated',
                'weight_requirement', 'height_requirement',
                ], 'integer'],
            ['time_book_opened', 'boolean'],
            [['from_date', 'to_date', 'is_longterm', 'is_allday' ,'title'], 'checkInputData'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gid' => '订单号',
            'title' => '标题',
            'clearance_period' => '结算方式',
            'clearance_period_label' => '结算方式',

            'salary' => '薪资',
            'salary_unit' => '薪资单位',
            'salary_unit_label' => '薪资单位',

            'salary_note' => '薪资说明',
            'from_date' => '开始日期',
            'to_date' => '结束日期',
            'from_time' => '上班时间',
            'to_time' => '下班时间',
            'need_quantity' => '需要数量',
            'got_quantity' => '报名数量',
            'created_time' => '创建时间',
            'updated_time' => '修改时间',
            'detail' => '工作内容',
            'requirement' => '其他要求',
            'address' => '地址',
            'user_id' => '发布人',
            'company_id' => '公司',
            'service_type_id' => '服务类型',
            'gender_requirement' => '性别',
            'degree_requirement' => '学历',
            'age_requirement' => '年龄',
            'height_requirement' => '身高',
            'status' => '状态',
            'status_label' => '状态',
            'city_id' => '城市',
            'district_id' => '区域',

            'contact'=>'联系人',
            'contact_phonenum'=>'联系手机',
            'labels_str'=>'标签',

            'origin'=>'来源',

            'is_overflow'=>'招人进展',
            'is_overflow_label'=>'招人进展',
            'recommend' => '是否为优单',
            'recommend_label' => '是否为优单',
        ];
    }

    public function beforeValidate()
    {
        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord){
            $user_id = Yii::$app->user->id;
            $this->user_id = $user_id;
            $this->gid = time() . mt_rand(100, 999) . $user_id;

        }
        if ($this->origin==$this::ORIGIN_INTERNAL){
            $this->order_time = date('Y-m-d H:i:s', strtotime('+7 day'));
        } elseif ($this->origin==$this::ORIGIN_CORP){
            $this->order_time = date('Y-m-d H:i:s', strtotime('+5 day'));
        } else {
            $this->order_time = date('Y-m-d H:i:s', time());
        }
        return parent::beforeSave($insert);
    }

    public function checkInputData($data){
        if( !isset($this->from_date) ){
            $this->from_date = '';
        }
        if( !isset($this->to_date) ){
            $this->to_date = '';
        }
        if( !isset($this->from_time) ){
            $this->from_time = '';
        }
        if( !isset($this->to_time) ){
            $this->to_time = '';
        }

        if( isset($this->is_longterm) && $this->is_longterm == 1 ){
            $this->from_date = '2015-01-01';
            $this->to_date = '2115-01-01';
        }
        if( isset($this->is_allday) && $this->is_allday == 1 ){
            $this->from_time = '00:00';
            $this->to_time = '23:59';
        }

        if( $this->to_date == '' ){
            $this->addError('to_date', '请填写工作结束日期');
        }
        if( $this->from_date == '' ){
            $this->addError('from_date', '请填写工作开始日期');
        }
        if( $this->to_date < date("Y-m-d") ){
            $this->addError('您的工作日期需要修改，截止日期应在今天之后', '您的工作日期需要修改，截止日期应在今天之后');
        }
        if( $this->from_time > $this->to_time ){
            $this->addError('您的工作时间需要修改，起始时间应小于结束时间', '您的工作时间需要修改，起始时间应小于结束时间');
        }
    }

    public function tidyTitle()
    {
        return preg_replace('/【.*?】/', '', $this->title);
    }

    /**
     * @inheritdoc
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }

    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    public function getCity()
    {
        return $this->hasOne(District::className(), ['id' => 'city_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getAddresses()
    {
        return $this->hasMany(TaskAddress::className(), ['task_id' => 'id']);
    }

    public function getAddress_label()
    {
        $addresses = $this->getAddresses()->all();
        $result = '';
        if($addresses){
            for($i=0,$len=count($addresses);$i<$len;$i++){
                if($i > 0) $result = $result.',';
                $result = $result.$addresses[$i]->title;
            }
        }
        return $result;
    }

    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }

    public function getService_type()
    { 
        return $this->hasOne(ServiceType::className(), ['id' => 'service_type_id']);//返回一个service query
    }

    public function getRecommend(){
        return $this->hasOne(ConfigRecommend::className(),['task_id'=>'gid']);
    }

    public function getWeichanpushitem(){
        return $this->hasOne(WeichatPushSetTemplatePushItem::className(),['task_id'=>'gid']);
    }

    public function getLabels()
    {
        $arr = [];
        if ($this->labels_str){
            $arr = explode(',', $this->labels_str);
        }
        $arr[] = $this->clearance_period_label;
        if( $this->is_longterm ){
            $arr[] = '长期兼职';
        }else{
            $arr[] = substr($this->from_date, 5) . '至' . substr($this->to_date, 5);
        }
        return $arr;
    }

    public function setLabels($labels)
    {
        $this->labels_str = implode(',', $labels);
    }

    public function extraFields()
    {
        return ['city', 'district', 'user', 'service_type', 'company', 'addresses'];
    }

    public function getLabel_options()
    {
        return [];
    }

    public function getIs_overflow()
    {
        return $this->need_quantity < $this->got_quantity;
    }

    public function getIs_overflow_label()
    {
        return $this->is_overflow?'已招满':'未招满';
    }

    public function getRequirements()
    {
        $columns = ['gender_requirement', 'degree_requirement',
                'face_requirement', 'talk_requirement', 'health_certificated',
                'weight_requirement', 'height_requirement',
            ];
        $ref = new ReflectionClass($this->className());
        $rs = [];
        foreach ($columns as $col){
            if($this->$col !=0 ){
                $options = $ref->getStaticPropertyValue(strtoupper($col));
                if (isset($options[$this->$col])){
                    $rs[] = $options[$this->$col];
                }
            }
        }
        return implode(', ', $rs);
    }

    public function getGender_requirement_label(){ 
        return $this::$GENDER_REQUIREMENT[$this->gender_requirement];}  
    public function getDegree_requirement_label(){
        return $this::$DEGREE_REQUIREMENT[$this->degree_requirement];}  
    public function getHeight_requirement_label(){
        return $this::$HEIGHT_REQUIREMENT[$this->height_requirement];}  
    public function getFace_requirement_label(){
        return $this::$FACE_REQUIREMENT[$this->face_requirement];}  
    public function getTalk_requirement_label(){
        return $this::$TALK_REQUIREMENT[$this->talk_requirement];}  
    public function getHealth_certificated_label(){
        return $this::$HEALTH_CERTIFICATED[$this->health_certificated];}  
    public function getWeight_requirement_label(){
        return $this::$WEIGHT_REQUIREMENT[$this->weight_requirement];}  

    /*
     *  TODO 临时方法，为了迁移company数据到独立表
     */
    public function getXcompany_name()
    {
        if ($this->company_id && $this->company){
            return $this->company->name;
        } else {
            return $this->company_name;
        }
    }

    public function getApplicants()
    {
        return $this->hasMany(TaskApplicant::className(), ['task_id'=>'id']);
    }

    public function getResumes()
    {
        return $this->hasMany(Resume::className(), ['user_id'=>'user_id'])
            ->via('applicants');
    }

    public function getOnlinejob(){
        return $this->hasOne(TaskOnlinejob::className(),['task_id'=>'id']);
    }

    public function getOnlinejob_needinfo(){
        return $this->hasMany(TaskOnlinejobNeedinfo::className(),['task_id'=>'id'])
            ->addOrderBy(['display_order' => SORT_ASC]);
    }

    public function getTasktime(){
        return $this->hasMany(Tasktime::className(), ['task_id' => 'id']);
    }

    public function getUndo_applicant_num(){
        $overtime   = date("Y-m-d H:i:s",time()-60*60*24*TaskApplicant::STATUS_APPLY_OVERDAYS);
        $undo = $this->hasMany(TaskApplicant::className(), ['task_id' => 'id'])
            ->andWhere(['status' => 0])
            ->andWhere(['>', 'created_time', $overtime])
            ->count();
        return $undo;
    }

    public function fields()
    {
        $fs = parent::fields();
        return array_merge($fs, [
            'clearance_period_label', 'salary_unit_label',
            'labels', 'label_options', 'status_label',
            'requirements',
            'is_overflow',
            'xcompany_name',
            'onlinejob',
            'onlinejob_needinfo',
            'service_type',
            'tasktime',
            'undo_applicant_num',
            'addresses',
        ]);
        unset($fields['contact_phonenum']);
        return $fields;
    }

    public function getNotice()
    {
        return $this->hasOne(TaskNotice::className(), ['task_id' => 'id']);
    }
}
