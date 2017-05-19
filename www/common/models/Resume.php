<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\Address;
use common\models\TaskApplicant;
use common\models\AccountEvent;

/**
 * This is the model class for table "{{%resume}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $phonenum
 * @property integer $gender
 * @property string $birthdate
 * @property int $degree
 * @property string $nation
 * @property integer $height
 * @property integer $is_student
 * @property string $college
 * @property string $avatar
 * @property string $gov_id
 * @property integer $grade
 * @property string $created_time
 * @property string $updated_time
 * @property integer $status
 * @property integer $user_id
 * @property integer $city_id
 * @property integer $home
 * @property integer $workplace
 * @property varchar(200) $origin
 * @property varchar(200) $major
 * @property varchar(1000) job_willes
 * @property text intro;
 */
class Resume extends \common\BaseActiveRecord
{

    public static $STATUSES = [
        0 => '正常',
        10 => '已删除',
    ];

    const STATUS_OK = 0;
    const STATUS_DELETED = 10;

    static $EXAM_STATUSES = [
        0 => '未验证',
        1 => '等待审核',
        2 => '审核通过',
        10 => '审核未通过',
    ];

    static $EXAM_STATUSES_MSG = [
        0 => '您还未提交个人身份证认证信息！',
        1 => '您的身份证信息认证审核中....',
        2 => '恭喜您的身份证信审核通过！',
        10 => '您的身份证信息没有通过审核！',
    ];

    const EXAM_TODO = 0;
    const EXAM_PROCESSING  = 1;
    const EXAM_DONE = 2;
    const EXAM_NOT_PASSED = 10;

    public static function tableName()
    {
        return '{{%resume}}';
    }

    public static $GENDERS = [0=>'男', 1=>'女'];
    public static $GRADES= [0=>'无', 1=>'一年级', 2=>'二年级',
        3=>'三年级', 4=>'四年级', 5=>'五年级'];
    public static $STUDENTS=[0=>'否', 1=>'是'];

    public static $DEGREES = [
        1 => '初中',
        2 => '高中/中专',
        3 => '大专',
        4 => '本科',
        5 => '研究生',
        6 => '博士生',
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['user_id', 'unique', 'on'=>'insert', 'message'=> '简历已经存在，请勿重新创建!'],
            [['gender', 'height', 'is_student', 'grade', 'degree',
                'has_emdical_cert', 'status', 'city_id',
                'user_id', 'home', 'workplace'], 'integer'],
            [['birthdate', 'created_time', 'updated_time','gov_id_pic_front','gov_id_pic_back','gov_id_pic_take','exam_status'], 'safe'],
            [['birthdate'], 'date', 'format' => 'yyyy-M-d'],
            [['name', 'college'], 'string', 'max' => 500],
            [['nation'], 'string', 'max' => 255],
            [['avatar'], 'string', 'max' => 2048],
            [['gov_id'], 'string', 'max' => 50],
            [['phonenum'], 'string', 'max' => 45],
            ['phonenum', 'match', 'pattern'=>'/^1[345789]\d{9}$/',
                'message'=>'手机号不正确，目前仅支持中国大陆手机号.'],
            ['gender', 'in', 'range'=>array_keys(static::$GENDERS)],
            [['gov_id'], 'match', 'pattern' => '/^\d{15,18}[Xx]?$/'],
            [['home', 'workplace'], 'default', 'value'=>0],
            ['phonenum', 'checkPhonenum'],
            ['status', 'default', 'value'=>0],
            ['exam_status', 'default', 'value'=>0],
            ['origin', 'default', 'value'=>'self'],
            ['job_wishes', 'string', 'max'=>500],
            ['major', 'string', 'max'=>200],
            ['gender', 'default', 'value'=>0],
            ['grade', 'default', 'value'=>0],
            [['intro'], 'string', 'max'=>5000],
        ];
    }

    public function checkPhonenum($attr, $params)
    {
        if (!$this->user_id && $this->phonenum && User::findByUsername($this->phonenum)){
            $this->addError($attr, "该手机号已被注册过");
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '姓名',
            'phonenum' => '手机号',
            'gender' => '性别',
            'birthdate' => '生日',
            'degree' => '学历',
            'nation' => '民族',
            'height' => '身高(cm)',
            'weight' => '体重',
            'is_student' => '是学生',
            'college' => '学校',
            'major' => '专业',
            'avatar' => '头像',
            'gov_id' => '身份证号',
            'grade' => '年级',
            'created_time' => '创建日期',
            'updated_time' => '修改日期',
            'status' => '状态',
            'user_id' => '用户',
            'home' => '住址',
            'workplace' => '工作地址',
            'job_wishes' => '工作意愿',
            'intro' => '自我介绍',
            'gov_id_pic_front' => '身份证正面',
            'gov_id_pic_back' => '身份证反面',
            'gov_id_pic_take' => '身份证手持',
            'exam_status' => '认证状态',
        ];
    }

    /**
     * @inheritdoc
     * @return ResumeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResumeQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if (!$this->user_id){
            $user = User::createUserWithPhonenum($this->phonenum);
            $this->user_id = $user->id;
        }
        if (!$this->phonenum){
            $this->phonenum = Yii::$app->user->identity->username;
        }
        return parent::beforeSave($insert);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getService_types()
    {
        return $this->hasMany(ServiceType::className(), ['id' => 'service_type_id'])
            ->viaTable(UserHasServiceType::tableName(), ['user_id' => 'user_id']);
    }

    public function getFreetimes()
    {
        return $this->hasMany(Freetime::className(), ['user_id' => 'user_id']);
    }

    public function getHome_address()
    {
        return $this->hasOne(Address::className(), ['id' => 'home']);
    }

    public function getWorkplace_address()
    {
        return $this->hasOne(Address::className(), ['id' => 'workplace']);
    }

    public function getApplicantDone(){
        return $this->hasMany(TaskApplicant::className(),['user_id' => 'user_id'])
            ->where(['status'=>10])
            ->orderBy(['id'=>SORT_DESC])
            ->limit(20)
            ->with('task');
    }

    public function getGender_label()
    {
        return static::$GENDERS[$this->gender];
    }

    public function getGrade_label()
    {
        return static::$GRADES[$this->grade];
    }

    public function getDegree_label()
    {
        if ($this->degree){
            return static::$DEGREES[$this->degree];
        }
        return '未知';
    }

    public function getDegree_options()
    {
        return static::$DEGREES;
    }

    public function getExam_message(){
        return static::$EXAM_STATUSES_MSG[$this->exam_status];
    }

    public function getStatus_label()
    {
        return static::$STATUSES[$this->status];
    }

    public function getAge()
    {
        if ($this->birthdate){
            return intval(date('Y', time())) - intval(explode(',', strval($this->birthdate))[0]);
        }
        return 0;
    }

    public function getCommon_url()
    {
        return Yii::$app->params['baseurl.frontend'] . '/resume-' . $this->user_id . '-' . $this->name;
    }

    public function getInvite()
    {
        return $this->hasMany(User::className(), ['invited_by' => 'user_id']);
    }

    public function getInvite_account()
    {
        return $this->hasMany(AccountEvent::className(), ['user_id' => 'user_id'])
            ->andWhere(['type' => AccountEvent::TYPES_WEICHAT_RECOMMEND]);
    }

    public static function getCityList(){
        $citys_obj = District::find()
            ->where(['level'=>'city','is_alive'=>1])
            ->addOrderBy(['id'=>SORT_ASC])
            ->all();
        $citys = [0=>'未知'];
        foreach( $citys_obj as $city ){
            $citys[$city->id] = $city->name;
        }
        return $citys; 
    }

    public function fields()
    {
        return array_merge(parent::fields(), ['gender_label', 'age', 'degree_label', 'degree_options','exam_message']);
    }

    public function extraFields()
    {
        return ['user', 'home_address', 'workplace_address', 'service_types', 'freetimes'];
    }

}
