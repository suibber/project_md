<?php

namespace backend\models;

use Yii;

use common\models\Task;
use common\models\TaskAddress;
use common\models\Company;
use common\models\ServiceType;
use common\models\District;

/**
 * This is the model class for table "{{%task_pool}}".
 *
 * @property integer $id
 * @property string $company_name
 * @property string $city
 * @property string $origin_id
 * @property string $origin
 * @property double $lng
 * @property double $lat
 * @property string $details
 * @property integer $has_poi
 * @property integer $has_imported
 * @property string $created_time
 */
class TaskPool extends \common\BaseActiveRecord
{

    const STATUS_UNSETTLED=0;
    const STATUS_EXPORTED=10;
    const STATUS_DROPPED=11;
    const STATUS_ZOMBIE=20;

    public function getStatus_options()
    {
        return [
            0=> '未处理',
            10=> '已导出',
            11=>'已放弃',
            20=>'僵尸'
        ];
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_pool}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_name', 'origin_id', 'origin', 'details'], 'required'],
            [['lng', 'lat'], 'number'],
            [['details', 'title', 'phonenum', 'contact'], 'string'],
            [['has_poi', 'status'], 'integer'],
            [['created_time'], 'safe'],
            [['company_name', 'city'], 'string', 'max' => 200],
            [['origin_id', 'origin'], 'string', 'max' => 45],
            [['origin_id', 'origin'], 'unique', 'targetAttribute' => ['origin_id', 'origin'], 'message' => '已抓取过'],
            ['status', 'default', 'value'=>0],
            ['release_date', 'safe'],
            ['to_date', 'safe'],
            ['task_id', 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => '公司名',
            'city' => '城市',
            'contact' => '联系人',
            'title' => '标题',
            'phonenum' => '电话',
            'origin_id' => '来源id',
            'origin' => '来源',
            'lng' => 'Lng',
            'lat' => 'Lat',
            'details' => '细节',
            'has_poi' => '位置精准？',
            'status' => '状态',
            'status_label' => '状态',
            'created_time' => '创建时间',
            'release_date' => '发布日期',
            'to_date' => '任务截止日期',
        ];
    }

    /**
     * @inheritdoc
     * @return TaskPoolQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskPoolQuery(get_called_class());
    }

    public function getStatus_label()
    {
        return $this->status_options[$this->status];
    }

    public function getOrigin_url()
    {
        if ($this->origin=='xiaolianbang'){
            return 'http://m.xiaolianbang.com/pt/' . $this->origin_id . '/detail';
        }
        if ($this->origin=='jianzhimao'){
            return 'http://m.jianzhimao.com/job/getJob?id=' . $this->origin_id;
        }
        if ($this->origin=='internal'){
            return "http://m.miduoduo.cn/task/view?gid=" . $this->origin_id;
        }
    }

    public function list_detail()
    {
        $s = [];
        foreach(json_decode($this->details) as $attr=>$value){
            $s[$attr] = $value ;
        }
        return $s;
    }

    public function exportTask($task_id=null, $self_update=false)
    {
        if ($this->status!=static::STATUS_UNSETTLED){
            return false;
        }
        $ds = $this->list_detail();
        $task = null;
        if ($task_id){
            $task = Task::findOne($task_id);
        }
        if (!$task){
            $task = new Task;
            $task->salary_unit = 0;
        }
        $task->title = $ds['title'];

        $cp = 3;
        $dcp = isset($ds['clearance_period'])?$ds['clearance_period']:'';
        foreach (Task::$CLEARANCE_PERIODS as $k=>$v) {
            $cp = $v==$dcp?$k:$cp;
        }
        $task->clearance_period = $cp;

        $task->salary = intval($ds['salary']);
        if ($task->salary!=0){
            $task->salary_unit = $this->getSalaryUnit($ds['salary_unit']);
        }
        if (!isset($ds['from_date']) || empty($ds['from_date'])){
            $task->is_longterm = true;
        }
        $task->from_date = isset($ds['to_date'])?$ds['from_date']:date('Y-m-d');
        $task->to_date = isset($ds['to_date'])?$ds['to_date']:'2115-01-01';
        if (isset($ds['to_date'])){
            $task->is_longterm = 1;
        }
        $task->need_quantity = intval($ds['need_quantity']);
        $task->detail = $ds['content'];
        $task->address = isset($ds['address'])?$ds['address']:'--';
        $task->user_id = 0;

        $task->status = $task::STATUS_OK;
        $task->origin = $ds['origin'];
        $task->company_id = 0;

        $this->company_name = isset($this->company_name) ? 
            str_ireplace('校联邦','米多多',$this->company_name) : '米多多运营中心';
        if ($this->company_name){
            $task->company_name = $this->company_name;
            $com = Company::find()->where([
                'name'=>$this->company_name,
            ])->one();
            if (!$com){
                $com = new Company;
                $com->name = $this->company_name;
                $com->contact_name = $ds['contact']?$ds['contact']:'无';
                $com->contact_phone = $ds['phonenum']?$ds['phonenum']:'00000000000';
                $com->contact_email = $ds['email'];
                $com->save();
                if ($com->getErrors()){
                    return false;
                }
            }
            $task->company_id = $com->id;
        }

        $task->contact = $ds['contact']?$ds['contact']:'无';
        $task->contact_phonenum= $ds['phonenum']?$ds['phonenum']:'00000000000';

        $task->service_type_id = $this->getServiceTypeId($ds['origin'], $ds['category_name']);
        $task->city_id = $this->getCityId($this->city);
        $task->save();
        if ($task->getErrors()){
            return false;
        }

        if ($this->has_poi&&$this->lat && isset($ds['address'])){

            $ta = new TaskAddress;
            $ta->lat = $this->lat;
            $ta->lng = $this->lng;

            $ta->address = isset($ds['address'])?$ds['address']:'--';
            $ta->city = $this->city;
            $ta->task_id = $task->id;
            $ta->save();
        }
        if ($self_update){
            $this->task_id = $task->id;
            $this->status = static::STATUS_EXPORTED;
            $this->save();

        }
        return $task;
    }

    public function getSalaryUnit($name)
    {
        $n = null;
        if (strpos($name, '时') !== false) {
            $n = '小时';
        } elseif (strpos($name, '周') !== false){
            $n = '周';
        } elseif (strpos($name, '月') !== false){
            $n = '月';
        } elseif (strpos($name, '天') !== false){
            $n = '天';
        } elseif (strpos($name, '次') !== false){
            $n = '次';
        } elseif (strpos($name, '单') !== false){
            $n = '单';
        }
        foreach(Task::$SALARY_UNITS as $k=>$v){
            if ($v==$n){
                return $k;
            }
        }
        return 0;
    }

    private $_stype_dict = [];

    public function getServiceTypeId($origin, $category_name)
    {
        if (!$this->_stype_dict){
            $sts = ServiceType::find()->all();
            foreach($sts as $t){
                $this->_stype_dict[$t->name] = $t->id;
            }
        }
        $arr = [];
        if ($origin=='xiaolianbang'){
            $arr = [
                "发单" => "传单",
                "家教" => "家教",
                "礼仪" => "礼仪模特",
                "实习" => "实习生",
                "展会" => "会展",
                "促销" => "促销",
                "客服" => "客服",
                "小时工" => "小时工", 
                "志愿者" => "志愿者",
            ];
        } elseif ($origin=='jianzhimao'){
            $arr = [
                "客服" => "客服",
                "促销" => "促销",
                "礼仪" => "礼仪模特",
                "模特" => "礼仪模特",
                "派单" => "传单",
                "服务员" => "服务员",
                "临时工" => "临时工",
                "设计" => "美工平面",
                "实习" => "实习生",
                "家教" => "家教",
            ];
        }
        $category_name = isset($arr[$category_name])?$arr[$category_name]:$category_name;
        if (isset($this->_stype_dict[$category_name])){
            return $this->_stype_dict[$category_name];
        }
        return $this->_stype_dict['其他'];
    }

    public function getCityId($name)
    {
        $name = mb_substr($name, 0, 2, 'utf-8');
        $city = District::find()->where(['level'=>'city'])->andWhere(
            ['like', 'name', $name . '%', false])->one();
        return $city->id;
    }
}
