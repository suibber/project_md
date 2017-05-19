<?php
namespace corp\forms;

use Yii;
use yii\base\Model;

use common\models\Resume;
/**
 * Signup form
 */
class EditResumeForm extends Model
{
    public $name;
    public $gender;
    public $grade;
    public $origin;

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

    public function getIsNewRecord()
    {
        return empty($this->_resume) || $this->_resume->isNewRecord;
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
            ['gender', 'default', 'value'=>0],
            ['grade', 'default', 'value'=>0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => '姓名',
            'gender' => '性别',
            'grade' => '年级',
            'origin' => '推荐码',
        ];
    }


    public function save()
    {
        $this->_resume->name = $this->name;
        $this->_resume->grade = $this->grade;
        $this->_resume->gender = $this->gender;
        if (!empty($this->origin)){
            $this->_resume->origin = $this->origin;
        }
        return $this->_resume->save();
    }
}
