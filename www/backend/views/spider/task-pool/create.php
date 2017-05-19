<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TaskPool */

$this->title = 'Create Task Pool';
$this->params['breadcrumbs'][] = ['label' => 'Task Pools', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-pool-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
