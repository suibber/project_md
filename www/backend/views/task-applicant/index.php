<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;
use kartik\daterange\DateRangePicker;
use common\models\TaskApplicant;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskApplicantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '投递管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-applicant-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [      
            ['attribute'=> 'id',
                 'label'=>'投递流水ID'
            ],
            [
                'label' => '申请时间',
                'attribute' => 'created_time',
                'value' => function($model){
                    return $model->created_time;
                },
                'filter' => DateRangePicker::widget([
                    'name' => 'TaskApplicantSearch[created_time]',
                    'convertFormat'=>true,
                    'value'=>Yii::$app->session->get('taskapp_created_from_date').' - '.Yii::$app->session->get('taskapp_created_to_date'),
                    'language'=>'cn',
                    'pluginOptions'=>[
                        'format'=>'Y-m-d'
                    ]            
                ]),
            ],
            [
                 'attribute'=> 'resume_name',
                 'format'=>'raw',
                 'value'=>function($model){
                     if ($model->resume){
                         return "<a target='_blank' href='/resume/view?user_id=". $model->user_id ."'>". ($model->resume?($model->resume->name):'') ."</a>";
                     }
                 },
                 'label'=>'简历',
            ],
            [
                'attribute'=> 'resume_phonenum',
                 'format'=>'raw',
                 'value'=>function($model){
                     if ($model->resume){
                        return $model->resume->phonenum;
                     }
                 },
                 'label'=>'报名人电话',
            ],
            ['attribute'=> 'task_title',
                 'format'=>'raw',
                 'value'=>function($model){
                    if ($model->task){
                        return "<a target='_blank' href='".Yii::$app->params['baseurl.m']."/task/view?gid=". $model->task->gid ."'>".$model->task->title ."<br />电话：".$model->task->contact_phonenum."</a>";
                    }
                    return '<span>已删除</span>';
                },
                'label'=>'应聘岗位'
            ],
            [
                'attribute' => 'company_alerted',
                'format' => 'boolean',
                'filter' => [0=>'否', 1=>'是']
            ],
            [
                'attribute' => 'applicant_alerted',
                'format' => 'boolean',
                'filter' => [0=>'否', 1=>'是']
            ],
            [
                'attribute' => 'status',
                'value' => function($model){ return $model->status_label;},
                'filter' => TaskApplicant::$STATUSES,
            ],
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update}'],
        ],
    ]); ?>

</div>
