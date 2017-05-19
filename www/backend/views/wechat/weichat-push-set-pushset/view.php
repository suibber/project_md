<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\JzWeichatPushSetPushset */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Jz Weichat Push Set Pushsets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jz-weichat-push-set-pushset-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('编辑', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确认删除？',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [   
                'attribute' => 'push_time',
                'value'=>$ops['pushtime'][$model->push_time],
            ],
            [   
                'attribute' => 'push_way',
                'value'=>$ops['pushtype'][$model->push_way],
            ],
            [   
                'attribute' => 'status',
                'value'=>$ops['status'][$model->status],
            ],
            [   
                'attribute' => 'template_push_id',
                'value'=>$ops['tmp_list'][$model->template_push_id],
            ],
            [   
                'attribute' => 'template_weichat_id',
                'value'=>$ops['tmp_weichat'][$model->template_weichat_id],
            ],
            
            'created_time',
            'update_time',
        ],
    ]) ?>

</div>
