<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\TaskApplicantOnlinejob;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskApplicantOnlinejobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Task Applicant Onlinejobs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-applicant-onlinejob-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--p>
        <?= Html::a(Yii::t('app', 'Create Task Applicant Onlinejob'), ['create'], ['class' => 'btn btn-success']) ?>
    </p-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //'id',
            'user_id',
            //'app_id',
            // 'needinfo:ntext',
            // 'has_sync_wechat_pic',
            'need_phonenum',
            'need_username',
            // 'need_person_idcard',
            // 'updated_time',
            // 'task_id',
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
                'label' => '审核状态',
                'attribute' => 'status',
                'filter' => TaskApplicantOnlinejob::$STATUS,
                'value' => function($model){
                    return TaskApplicantOnlinejob::$STATUS[$model->status];
                }
            ],
            'reason',
            'created_time',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
