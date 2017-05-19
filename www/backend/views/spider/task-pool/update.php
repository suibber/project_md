<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TaskPool */

$this->title = 'Update Task Pool: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Task Pools', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-pool-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
