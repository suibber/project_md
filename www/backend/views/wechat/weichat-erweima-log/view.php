<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\WeichatErweimaLog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Weichat Erweima Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weichat-erweima-log-view">

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
            'erweima_id',
            'openid',
            'create_time',
            'has_bind',
            'follow_by_scan',
        ],
    ]) ?>

</div>
