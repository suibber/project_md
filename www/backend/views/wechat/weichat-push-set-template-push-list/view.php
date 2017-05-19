<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\JzWeichatPushSetTemplatePushList */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Jz Weichat Push Set Template Push Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jz-weichat-push-set-template-push-list-view">

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
            'title',
            'created_time',
            'updated_time',
            'status',
            'create_user',
        ],
    ]) ?>

</div>
