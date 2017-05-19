<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\JzWeichatPushQualityTask */

$this->title = 'Update Jz Weichat Push Quality Task: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Jz Weichat Push Quality Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jz-weichat-push-quality-task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
