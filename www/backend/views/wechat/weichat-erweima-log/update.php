<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WeichatErweimaLog */

$this->title = 'Update Weichat Erweima Log: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Weichat Erweima Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="weichat-erweima-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
