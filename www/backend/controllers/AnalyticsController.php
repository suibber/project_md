<?php

namespace backend\controllers;

use Yii;

use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\BDataBaseController;
use common\models\TaskApplicant;
use common\models\Task;
use common\models\District;
use common\models\DataDaily;



class AnalyticsController extends BDataBaseController
{

    public function behaviors()
    {
        $bhvs = parent::behaviors();
        return $bhvs;
    }

    public function renderChart($title, $days, $labels, $city_id, $data_type,
                $unit=''){

        $label_keys = array_keys($labels);
        $dateStart = date("Y-m-d", strtotime('-' . $days . ' days'));
        $dateEnd = date('Y-m-d', strtotime('today'));
        $rows   = $this->getDataRows($data_type, $city_id, $dateStart, $dateEnd, $label_keys);

        $datas = [];
        foreach ($label_keys as $k){
            $datas[$k] = [];
        }
        usort($rows, function($a, $b){
            return ($a['date'] < $b['date']) ? -1 : 1;
        });
        $dates = [];
        foreach ($rows as $row){
            foreach($label_keys as $k){
               $datas[$k][$row['date']] = isset($row[$k])?intval($row[$k]):0;
            }
            $dates[] = $row['date'];
        }
        return $this->render('chart',[
            'title'     => $title,
            'labels'    => $labels,
            'datas'     => $datas,
            'dates'     => $dates,
            'unit'      => $unit,
            'dateStart' => $dateStart,
            'dateEnd'   => $dateEnd,
            'days'      => $days,
            'data_type' => $data_type,
            'city_id'   => $city_id,
        ]);
 
    }

    public function actionUser($days = 100, $city_id = 0)
    {
        $labels = [
                       'zczl'     =>'注册总量',
                       'zczl'     =>'注册总量',
                       'jlzl'     =>'简历总量',
                       'tdzl'     =>'投递总量',
                       'tdrs'     =>'投递人数',
                       'jrzczl'   =>'当日注册总量',
                       'jrjlzl'   =>'当日简历总量',
                       'jrtdzl'   =>'当日投递总量',
                       'jrtdrs'   =>'当日投递人数',
                       'jrxyhtd'  =>'当日新用户投递',
                       ];
        return $this->renderChart('用户统计', $days, $labels, $city_id, $data_type=1);
    }

    public function actionWechat($days = 100, $city_id = 0)
    {
        $labels = [
                       'zgz'      =>'剩余关注',
                       'jrgz'     =>'当日关注',
                       'ztd'      =>'总退订',
                       'jrtd'     =>'当日退订',
                       'jrtsrs'   =>'当日推送人数',
                       'jrtszl'   =>'当日推送总量',
                       'jrwxzc'   =>'当日微信注册',
                       'jrwxtdrs' =>'当日微信投递人数',
                       'jrwxtdzl' =>'当日微信投递总量',
                        ];
        return $this->renderChart('微信统计', $days, $labels, $city_id, $data_type=3);
    }
    public function actionTask($days = 100, $city_id = 0)
    {
        $labels = [
                       'ztl'     =>'总贴量',
                       'zzxtl'   =>'总在线贴量',
                       'htxz'    =>'后台新增',
                       'zqxz'    =>'抓取新增',
                       'zqxz'    =>'抓取新增',
                       'yhxz'    =>'用户新增',
                       'zdsh'    =>'总待审核',
                       'zgq'     =>'总过期',
                       'jrgq'    =>'当日过期',
                       ];
        return $this->renderChart('任务统计', $days, $labels, $city_id, $data_type=2);
    }

    public function actionClearup(){
        DataDaily::deleteAll();
        $this->redirect('/');
    }

    public function actionApplicant($city_id=null, $date=null)
    {
        $today = date('Y-m-d');
        if ($date){
            $date = date('Y-m-d', strtotime($date));
        }
        if (!$city_id && !$date){
            $date = $today;
        }
        if ($city_id){
            $data = $this->getApplicantData($today, $city_id);
            $city = District::findOne($city_id);
            return $this->render('city-applicant', [
                'data' => $data,
                'city' => $city,
            ]);
        }
        if ($date){
            $prev_date = date('Y-m-d', strtotime('-1 day', strtotime($date)));
            $c = $this->getApplicantData($today, null, $date);
            $prev = $this->getApplicantData($today, null, $prev_date);

            $data = [];
            $cities = District::findAll(['level'=>'city', 'is_alive'=>1]);
            foreach($cities as $city){
                $city_id = $city->id;
                $count = !isset($c[$city_id])?0:$c[$city_id];
                $prev_count = isset($prev[$city_id])?$prev[$city_id]:0;
                $data[$city_id] = ['count'=>$count, 'increase'=>$count-$prev_count];
            }

            ksort($data);
            return $this->render('date-applicant', [
                'data' => $data,
                'date' => $date,
            ]);
        }
    }
    public function actionClearCache()
    {
        $cache = Yii::$app->cache;
        $date = strtotime('+1 month');
        $fdate = strtotime('2015-06-06');
        while($date>$fdate){
            $key = 'analytics.applicant.' . date('Y-m-d', $date);
            $cache->delete($key);
            $date = strtotime('-1 day', $date);
        }
        foreach (District::findAll(['level'=>'city']) as $city)
        {
            $key = 'analytics.applicant.' . $city->id;
            $cache->delete($key);
        }
        return $this->redirect('./applicant');
    }

    public function getApplicantData($today, $city_id=null, $date=null)
    {
        $cache = Yii::$app->cache;
        if ($city_id){
            $key = 'analytics.applicant.' . $city_id;
            $data = $cache->get($key);
            if ($data){
                $last_record = array_pop($data);
                $date = $last_record['date'];
            } else {
                $data = [];
                $date = '1900-01-01';
            }

            $query = new Query;
            $applicants = TaskApplicant::find()
                ->joinWith('task')
                ->andWhere([Task::tableName().'.city_id', $city_id])
                ->where(['>', Task::tableName().'.created_time', $date])->all();
            $anas = [];
            foreach($applicants as $a){
                if (!isset($anas[$a->date])){
                    $anas[$a->date] = 0;
                }
                $anas[$a->date] += 1;
            }
            ksort($anas);
            $data = $data + $anas;
            $cache->set($key, $data, 0);
        } else if ($date){
            $key = 'analytics.applicant.' . $date;
            if ($date >= $today){
                $data = [];
            } else {
                $data = $cache->get($key);
            }
            $next_day = date('Y-m-d', strtotime('+1 days', strtotime($date)));
            if (!$data){
                $applicants = TaskApplicant::find()
                    ->joinWith('task')
                    ->andWhere(['>', TaskApplicant::tableName().'.created_time', $date])
                    ->andWhere(['<=', TaskApplicant::tableName().'.created_time', $next_day])
                    ->all();
                foreach($applicants as $a){
                    if (!$a->task || empty($a->task->city_id)){
                        continue;
                    }
                    $city_id = $a->task->city_id;
                    if (!isset($data[$city_id])){
                        $data[$city_id] = 0;
                    }
                    $data[$city_id] += 1;
                }
                if ($date < $today){
                    $cache->set($key, $data, 0);
                }
            }
        }
        return $data;
    }

    protected function findModel($id)
    {
        if (($model = DataDaily::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
