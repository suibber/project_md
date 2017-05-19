<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WeichatErweima */

$this->title = '更新微信二维码: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Weichat Erweimas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="weichat-erweima-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
