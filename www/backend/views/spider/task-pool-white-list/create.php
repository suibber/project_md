<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TaskPoolWhiteList */

$this->title = 'Create Task Pool White List';
$this->params['breadcrumbs'][] = ['label' => 'Task Pool White Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-pool-white-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
