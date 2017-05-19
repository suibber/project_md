<?php

namespace m\controllers;

use Yii;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use common\Utils;
use common\models\Task;
use common\models\TaskAddress;
use common\models\TaskCollection;
use common\models\Complaint;
use common\models\TaskApplicant;
use common\models\Resume;
use common\models\District;
use common\models\ServiceType;
use yii\data\Pagination;
use common\models\WeichatPushSetTemplatePushItem;
use common\models\ConfigRecommend;
use common\models\UserLocation;
use common\Seo;

class TaskController extends \m\MBaseController
{

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view','nearby', 'nearest'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['collect', 'apply'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'collect' => ['post'],
                ],
            ],
        ]);
    }

    public function actionNearest($lat=0, $lng=0, $distance=5000, $service_type=null)
    {
        //只有北京
        $city_id = 3;
        $district = Yii::$app->request->get('district');
        $service_type = Yii::$app->request->get('service_type');
        if (empty($city_id)){
            $this->render404('未知的城市');
        }
        $city = District::findOne($city_id);

        $user_id    = Yii::$app->user->id;

        // 记录用户位置数据，保存地理位置到session,下次直接用
        TaskAddress::cacheUserLocation($user_id,$lat,$lng);

        $query = TaskAddress::find();
        $query = TaskAddress::buildNearbyQuery($query, $lat, $lng, $distance);
        $query->innerJoin('jz_task', $on='jz_task.id=jz_task_address.task_id');
        if ($service_type){
            $query->andWhere('jz_task.service_type_id=' . $service_type);
        }
        $query->andWhere(['jz_task.status'=>Task::STATUS_OK]);
        //$query->andWhere(['>', 'jz_task.to_date', date("Y-m-d")]);
        $query->addOrderBy(['jz_task.id'=>SORT_DESC]);
        $tas = $query->with('task')->all();

        $pages =  new Pagination(['pageSize'=>Yii::$app->params['pageSize'],
            'totalCount' => count($tas)]);

        $tasks = [];
        foreach ($tas as $ta){
            $task = $ta->task;
            $distance = $ta->distance($lat=$lat, $lng=$lng);
            $tasks[] = ['task'=>$task, 'distance'=>$distance];
        }

        usort($tasks, function($a, $b){
            return $a['distance'] < $b['distance'] ? -1:1;
        });

        return $this->render('nearest', 
            ['tasks'=>array_slice($tasks, $pages->offset, $pages->limit),
             'pages'=> $pages,
             'city'=>$city,
             'current_district' => 
             empty($district)?$city:District::findOne($district),
             'current_service_type' => empty($service_type)?null:ServiceType::findOne($service_type),
            ]);
    }

    public function actionIndex($city_pinyin='beijing', $type_pinyin='', $district_pinyin='')
    {
        $district = null;
        $city = District::findOne(
            ['seo_pinyin'=> $city_pinyin, 'level'=>'city', 'is_alive'=> 1]);
        $stype = ServiceType::findOne(['pinyin'=> $type_pinyin]);
        if ($city && $district_pinyin){
            $district = District::findOne(
                ['seo_pinyin'=>$district_pinyin, 'parent_id'=> $city->id]);
        }

        //只有北京
        $city_id = $city?$city->id:'';
        $district = $district?$district->id:'';
        $service_type = $stype?$stype->id:'';
        if (empty($city_id)){
            $this->render404('未知的城市');
        }

        $seo_params = [
            'city_pinyin'=>$city_pinyin,
            'district_pinyin' => $district_pinyin,
            'block_pinyin' => $district_pinyin,
            'type_pinyin' => $type_pinyin,
        ];


        $query = Task::find()->with('service_type');
        $query->where(['status'=>Task::STATUS_OK]);
        $query->andWhere(['or', ['>', 'to_date', date("Y-m-d")], ['is_longterm' => 1]]);
        $query = $query->andWhere(['city_id'=>$city_id]);
        if (!empty($district)){
            $query->andWhere(['district_id'=>$district]);
        }
        if (!empty($service_type)){
            $query->andWhere(['service_type_id'=>$service_type]);
        }
        
        // 排序
        $sort   = Yii::$app->request->get('sort');
        if( $sort == 'fromdate' ){
            // 今天之前的，按照`order_time`排序，今天之后的，按照`from_date`排序
            $query->addOrderBy("
                (CASE
                    WHEN `from_date`<='".date("Y-m-d")."' THEN `order_time`
                    ELSE 0
                END) DESC,`from_date` ASC,`order_time` DESC,`id` DESC
            ");
        }else{
            // 默认按照`order_time`排序
            $query->addOrderBy(['order_time'=>SORT_DESC,'id'=>SORT_DESC]);
        }

        $countQuery = clone $query;
        $pages =  new Pagination(['pageSize'=>Yii::$app->params['pageSize'],
            'totalCount' => $countQuery->count()]);
        $tasks = $query->offset($pages->offset)
            ->limit($pages->limit)->all();

        $city = District::findOne($city_id);
        
        // 查询当前用户的已有最新位置信
        $user_id    = Yii::$app->user->id;
        $location   = Yii::$app->session->get('location');

        return $this->render('index', 
                ['tasks'=>$tasks,
                 'city'=>$city,
                 'pages'=> $pages,
                 'current_district' => 
                    empty($district)?$city:District::findOne($district),
                 'current_service_type' => empty($service_type)?null:ServiceType::findOne($service_type),
                 'location' => $location,   
                 'seo_params'=> $seo_params,
        ]);
    }

    public function actionView()
    {
        $pathInfo = explode('/',Yii::$app->request->pathInfo);
        if( count($pathInfo) == 3 ){
            $seo_pinyin = $pathInfo[0];
            $service_type = $pathInfo[1];
            $service_type = ServiceType::findOne(['pinyin' => $service_type]);
        }else{
            $seo_pinyin = '';
            $service_type = '';
        }

        $this->layout = 'main';
        $user_id = Yii::$app->user->id;
        $resume =(bool) Resume::find()->where(['user_id'=>$user_id])->one();
        $gid = Yii::$app->request->get('gid');
        $task = null;
        if ($gid){
            $task = Task::find()->where(['gid'=>$gid])
                ->with('city')->with('district')->with('addresses')->with('tasktime')->one();
        }
        if ($task){
            $collected = false;
            $complainted = false;
            $app = null;
            if (!Yii::$app->user->isGuest){
                $collected = TaskCollection::find()->where(
                    ['task_id'=>$task->id, 'user_id'=>Yii::$app->user->id])->exists();
                $complainted = Complaint::find()->where(
                    ['task_id'=>$task->id, 'user_id'=>Yii::$app->user->id])->exists();
                $app = TaskApplicant::find()->where(
                    ['task_id'=>$task->id, 'user_id'=>Yii::$app->user->id])->one();
            }
            return $this->render('view', 
                [
                    'task'=>$task,
                    'collected'=>$collected,
                    'complainted'=>$complainted,
                    'app'=> $app,
                    'resume'=> $resume,
                    'seo_pinyin' => $seo_pinyin,
                    'service_type' => $service_type,
                ]
            );
        } else {
            $this->render404("未知的信息");
        }
    }

    // 附近的兼职推荐
    public function actionNearby(){
        // 应该是周边兼职

        // 当前是固定内容推荐
        $temp_id    = is_numeric( Yii::$app->request->get('id') ) ? Yii::$app->request->get('id') : 0;
        // 查询列表的任务id
        $taskid_arr = WeichatPushSetTemplatePushItem::find()->where(['template_push_id'=>$temp_id])->asArray()->all();
        $taskid_str = '';
        foreach( $taskid_arr as $key => $value ){
            $taskid_str .= $value['task_id'].',';
        }
        $taskid_str = trim($taskid_str,',');

        $query = Task::find()->where("`gid` in($taskid_str)");

        // 任务排序功能
        $tasks = $query
            ->addOrderBy(['display_order'=>SORT_DESC])
            ->joinWith('weichanpushitem')
            ->all();

        return $this->render('nearby', 
            ['tasks'=>$tasks,
            ]);
    }

}
