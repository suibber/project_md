<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WeichatAutoresponse */

$this->title = 'Update Weichat Autoresponse: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Weichat Autoresponses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="weichat-autoresponse-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
