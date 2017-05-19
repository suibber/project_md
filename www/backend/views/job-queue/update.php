<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\JobQueue */

$this->title = 'Update Job Queue: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Job Queues', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="job-queue-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
