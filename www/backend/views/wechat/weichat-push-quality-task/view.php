<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\JzWeichatPushQualityTask */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Jz Weichat Push Quality Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jz-weichat-push-quality-task-view">

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
            'gid',
            'title',
            'company_name',
            'task_name',
            'task_type',
            'location',
            'price',
            'created_time',
            'updated_time',
            'has_pushed',
        ],
    ]) ?>

</div>
