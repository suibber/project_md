<?php

namespace common\models;

use Yii;
use common\models\District;
use common\Utils;
use common\models\Task;

/**
 * This is the model class for table "{{%config_banner}}".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $city_id
 * @property integer $type
 * @property integer $display_order
 * @property string $title
 * @property string $pic
 * @property string $url
 * @property string $offline_date
 * @property string $created_time
 */
class ConfigBanner extends \yii\db\ActiveRecord
{
    static $STATUS = [
        0   => '正常',
        10  => '下线',
        20  => '过期',
    ];

    const STATUS_OK = 0;
    const STATUS_OFFLINE = 10;
    const STATUS_EXPIRE = 20; 

    static $DISPLAY_ORDER = [
        1  => '广告位1',  
        2  => '广告位2', 
        3  => '广告位3', 
        4  => '广告位4', 
        5  => '广告位5', 
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%config_banner}}';
    }

    public function getPic_url()
    {
        return Utils::urlOfFile($this->pic);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'city_id', 'type', 'display_order', 'task_id'], 'integer'],
            [['offline_date', 'created_time'], 'safe'],
            [['title'], 'string', 'max' => 256],
            [['pic', 'url'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '广告位ID',
            'status' => '状态',
            'city_id' => '上线城市',
            'type' => '类型，全国OR城市',
            'display_order' => '位置',
            'title' => '内容',
            'pic' => '图片（640*240）',
            'url' => '链接',
            'offline_date' => '下线日期',
            'created_time' => '创建时间',
            'task_id' => '任务id(设置了任务id，就不用再设置链接了)',
        ];
    }

    public static function getCityList(){
        $citys_obj = District::find()
            ->where(['level'=>'city','is_alive'=>1])
            ->addOrderBy(['id'=>SORT_ASC])
            ->all();
        $citys = [0=>'全国'];
        foreach( $citys_obj as $city ){
            $citys[$city->id] = $city->name;
        }
        return $citys; 
    }

    public function fields()
    {
        return array_merge(parent::fields(), ['pic_url']);
    }

    public function getTask(){
        return $this->hasOne(Task::className(),['id' => 'task_id']);
    }
}
