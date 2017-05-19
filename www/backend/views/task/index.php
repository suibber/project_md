<?php
use yii\helpers\Html;
use yii\grid\GridView;

use common\models\Task;
use common\models\District;
use common\models\ServiceType;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '任务订单';
$this->params['breadcrumbs'][] = $this->title;

$service_type_maps = [];

foreach(ServiceType::findAll(['status'=>0]) as $s){
    $service_type_maps[$s->id] = $s->name;
}
$city_maps = [];
foreach (District::findAll(['level'=>'city', 'is_alive'=>1]) as $c)
{
    $city_maps[$c->id] = $c->short_name;
}
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建任务订单', ['publish'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('创建在线任务', ['publish-onlinejob'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'gid',
            [
                'label' => '发布时间',
                'attribute' => 'created_time',
                'value' => function($model){
                    return $model->created_time;
                },
                'filter' => DateRangePicker::widget([
                    'name' => 'TaskSearch[created_time]',
                    'convertFormat'=>true,
                    'value'=>Yii::$app->session->get('task_created_from_date').' - '.Yii::$app->session->get('task_created_to_date'),
                    'language'=>'cn',
                    'pluginOptions'=>[
                        'format'=>'Y-m-d'
                    ]            
                ]),
            ],
            'contact_phonenum',
            [
                'label' => '标题',
                'format' => 'raw',
                'attribute' => 'title',
                'value' => function($model){
                    return "<a target='_blank' href='" . \Yii::$app->params['baseurl.m'] . "/task/view/?gid=" . $model->gid ."'>" . $model->title . "</a>";
                }
            ] ,
            [
                'attribute' => 'recommend',
                'value' => function($model){
                    return $model->recommend_label;
                },
                'filter' => Task::$RECOMMEND,
            ],
            /*
            [
		        'attribute' => 'clearance_period',
                'value' => function ($model){
                    return $model->clearance_period_label;
                },
                'filter' => Task::$CLEARANCE_PERIODS,
            ],
            */
            [
                'attribute' => 'service_type_id',
                'format' => 'raw',
                'value' => function ($model){
                    if( $model->service_type->id != 17 ){
                        return $model->service_type->name;
                    }else{
                        return "<a href='/task-applicant-onlinejob?TaskApplicantOnlinejobSearch[task_id]=".$model->id."' target='_blank'>".$model->service_type->name."</a>";
                    }
                },
                'filter' => $service_type_maps,
            ],
            /*
            [
                'attribute' => 'salary_unit',
                'label' => '薪资与单位',
                'value' => function ($model){
                    return $model->salary . "/" . $model->salary_unit_label;
                },
                'filter' => Task::$SALARY_UNITS,
            ],
            */
            [
                'attribute' => 'city_id',
                'value' => function ($model){
                    if ($model->city){
                        return $model->city->short_name;
                    }
                    return '--';
                },
                'filter' => $city_maps,
            ],
            [
                'attribute' => 'origin',
                'value' => function ($model){
                    return $model->origin_label;
                },
                'filter' => Task::$ORIGIN,
            ],
            [
                'attribute' => 'status',
                'value' => function ($model){
                    return $model->status_label;
                },
                'filter' => Task::$STATUSES,
            ],
            'is_overflow_label',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '<div style="min-width:120px">{view_applicant} | {view} {update} {delete} | {adopt} {reject}</div>',
                'buttons' => [
                    'adopt' => function ($url, $model, $key) {
                        if ($model->status==Task::STATUS_IS_CHECK){
                            $options = [
                                'title' => '审核通过',
                                'aria-label' => '审核通过',
                                'data-pjax' => '0',
                                'data-method' => 'post',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, $options);
                        }
                    },
                    'reject' => function ($url, $model, $key) {
                        if ($model->status==Task::STATUS_IS_CHECK){
                            $options = [
                                'title' => '审核不通过',
                                'aria-label' => '审核不通过',
                                'data-pjax' => '0',
                                'data-method' => 'post',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, $options);
                        }
                    },
                    'view_applicant' => function ($url, $model, $key) {
                        $url = '/task-applicant?TaskApplicantSearch[task_id]=' . $model->id;
                        $options = [
                            'title' => '查看报名详情',
                            'aria-label' => '查看报名详情',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', $url, $options);
                    },
                    'view' => function ($url, $model, $key) {
                        $url = Yii::$app->params['baseurl.m'].'/task/view?gid=' . $model->gid;
                        $options = [
                            'title' => '查看任务详情',
                            'aria-label' => '查看任务详情',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', $url, $options);
                    }
                ],
            ],
        ],
    ]); ?>

</div>
