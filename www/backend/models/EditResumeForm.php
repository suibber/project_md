<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Resume;
use common\models\User;

/**
 * Help doc:
 * https://github.com/yiisoft/yii2/blob/master/docs/guide/structure-models.md
 */
class EditResumeForm extends Model
{
    public $name;
    public $gender;
    public $grade;
    public $is_student;
    public $college;
    public $degree;

    public $phonenum;
    public $birthdate;
    public $nation; //民族 
    public $height; // 身高

    public $avatar;
    public $gov_id;
    public $worker_type;
    public $status;

    private $_resume;

    public function __construct($resume)
    {
        parent::__construct();
        if ($resume){
            foreach (get_object_vars($this) as $attr=>$v){
                if (substr($attr, 0, 1)!='_'){
                    $this->$attr = $resume->$attr;
                }
            }
            $this->_resume = $resume;
        } else {
            throw new Exception('EditResumeForm need to assign a resume first!');
        }
    }

    public function attributeLabels()
    {
        return [
            'name'      =>'姓名',
            'gender'    =>'性别',
            'is_student'=>'是否是学生',
            'college'   =>'学校',
            'grade'     =>'年级',
            'degree'    =>'学历',
            'phonenum'  =>'手机号',
            'birthdate' =>'生日',
            'nation'    =>'民族', //民族 
            'height'    =>'身高(cm)', // 身高
            'avatar'    =>'头像',
            'gov_id'    =>'身份证号',
            'worker_type' =>'',
            'status'    =>'状态'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'required', 'message'=>'有名有姓，顶天立地!'],
            ['name', 'string', 'min' => 2, 'max' => 255, 'message'=>'姓名需要大于2位数, 小于...255位就好!'],
            ['gender', 'in', 'range'=>[0, 1, 2]],
            ['grade', 'in', 'range' => [1, 2, 3, 4, 5]],
            ['grade', 'in', 'range' => [1, 2, 3, 4, 5]],
            [['phonenum'], 'required'],
            ['phonenum', 'match', 'pattern'=>'/^1[345789]\d{9}$/',
                'message'=>'手机号不正确，目前仅支持中国大陆手机号.'],
            ['phonenum', 'unique']
        ];
    }


    public function save()
    {
        foreach (get_object_vars($this) as $attr=>$v){
            if (substr($attr, 0, 1)!='_' && $v){
                $this->_resume->$attr = $v;
            }
        }
        if (!$this->_resume->user_id){
            $user = User::createUserWithPhonenum($this->phonenum);
            if ($user){
                $this->_resume->user_id = $user->id;
            } else {

            }
        }

        return $this->_resume->save();
    }
}
