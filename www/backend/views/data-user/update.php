<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DataDaily */

$this->title = 'Update Data Daily: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Data Dailies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="data-daily-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
