<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\JobQueue;

/* @var $this yii\web\View */
/* @var $searchModel common\models\JobQueueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Job Queues';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-queue-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Job Queue', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'task_name',
            'retry_times',
            'start_time',
            [
                'attribute' => 'priority',
                'filter' => JobQueue::$PRIORITIES,
                'value' => function($model){
                    return $model->priority_label;
                }
            ],
            [
                'attribute' => 'status',
                'filter' => JobQueue::$STATUSES,
                'value' => function($model){
                    return $model->status_label;
                }
            ],
            'message:ntext',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
