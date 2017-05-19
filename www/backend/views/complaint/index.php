<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ComplaintSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Complaints';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="complaint-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Complaint', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'task.gid',
            'content:ntext',
            'phonenum',
            [
                'label' => '标题',
                'format' => 'raw',
                // 'attribute' => 'title',
                'value' => function($model){
                    if(isset($model->task->gid)){
                        return "<a target='_blank' href='" . \Yii::$app->params['baseurl.m'] . "/task/view/?gid=" . $model->task->gid ."'>" . $model->task->title . "</a>";
                    }else{
                        return '无';
                    }
                }
            ] ,
            'resume.name',
            'created_time',
            // 'status',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
