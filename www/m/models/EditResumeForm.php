<?php
namespace m\models;

use common\models\Resume;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class EditResumeForm extends Model
{
    public $name;
    public $gender;
    public $grade;

    private $_resume;

    public function __construct($resume)
    {
        parent::__construct();
        if ($resume){
            $this->name = $resume->name;
            $this->gender = $resume->gender;
            $this->grade = $resume->grade;
            $this->_resume = $resume;
        } else {
            throw new Exception('EditResumeForm need to assign a resume first!');
        }
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
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => '姓名',
            'gender' => '性别',
            'grade' => '年级',
        ];
    }


    public function save()
    {
        $this->_resume->name = $this->name;
        $this->_resume->grade = $this->grade;
        $this->_resume->gender = $this->gender;
        return $this->_resume->save();
    }
}
