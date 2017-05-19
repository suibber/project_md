<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TaskPoolWhiteList */

$this->title = 'Update Task Pool White List: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Task Pool White Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-pool-white-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
