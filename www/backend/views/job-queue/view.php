<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JobQueue */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Job Queues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-queue-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'task_name',
            'params',
            'retry_times',
            'start_time',
            'priority',
            'status',
            'message:ntext',
        ],
    ]) ?>

</div>
