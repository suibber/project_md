<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\WeichatAutoresponse */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Weichat Autoresponses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weichat-autoresponse-view">

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
            'type',
            [   
                'attribute' => 'type',
                'value'=>$model->type_label,
            ],
            [   
                'attribute' => 'status',
                'value'=>$model->status_label,
            ],
            'keywords',
            'response_msg',
            'created_time',
            'updated_time',
        ],
    ]) ?>

</div>
