<?php

namespace frontend\controllers;

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
use common\TaskUtils;
use common\WeichatBase;

class TaskController extends \frontend\FBaseController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    public function actionIndex($city_pinyin='beijing', $type_pinyin='', $district_pinyin='')
    {
        $city = District::findOne(
            ['seo_pinyin'=> $city_pinyin, 'level'=>'city', 'is_alive'=> 1]);
        $city_id = $city ? $city->id : '';

        $district = null;
        if ($city && $district_pinyin){
            $district = District::findOne(
                ['seo_pinyin'=>$district_pinyin, 'parent_id'=> $city->id]);
        }
        $district = $district ? $district->id : '';

        $stype = ServiceType::findOne(['pinyin'=> $type_pinyin]);
        $service_type = $stype?$stype->id:'';
        if (empty($city_id)){
            $this->render404('未知的城市');
        }

        $seo_params = [
            'city_pinyin'       => $city_pinyin,
            'district_pinyin'   => $district_pinyin,
            'block_pinyin'      => $district_pinyin,
            'type_pinyin'       => $type_pinyin,
        ];


        $query = Task::find()
            ->with('service_type')
            ->where(['status'=>Task::STATUS_OK])
            ->andWhere(['or', ['>', 'to_date', date("Y-m-d")], ['is_longterm' => 1]])
            ->andWhere(['city_id'=>$city_id]);

        if ( !empty($district) ){
            $query->andWhere(['district_id'=>$district]);
        }
        if ( !empty($service_type) ){
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

        $task_utils = new TaskUtils();
        $recommend_task_list = $task_utils->getRecommendTaskList( $city_id );

        // var_dump($city);exit;
        return $this->render('index', 
        [
            'tasks' => $tasks,
            'recommend_task_list' => $recommend_task_list,
            'city'  => $city,
            'pages' => $pages,
            'current_district'      => 
                empty($district)?$city:District::findOne($district),
            'current_service_type'  => 
                empty($service_type)?null:ServiceType::findOne($service_type),
            'location'  => $location,   
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

            $task_utils = new TaskUtils();
            $recommend_task_list = $task_utils->getRecommendTaskList( $task->city_id );
            
            $weichat_base = new WeichatBase();
            if( !$weichat_base->checkErweimaValid($task->erweima_date) ){
                $task_erweima = $weichat_base->createErweimaByTaskid( $task->id );
            }else{
                $task_erweima = $task->erweima_ticket;
            }
            $task_erweima = Yii::$app->params['weichat']['url']['erweima_show']
                .$task_erweima;
            
            return $this->render('view', 
                [
                    'task' => $task,
                    'recommend_task_list' => $recommend_task_list,
                    'task_erweima' => $task_erweima,
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
} 
?>
