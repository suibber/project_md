<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\JobQueue */

$this->title = 'Create Job Queue';
$this->params['breadcrumbs'][] = ['label' => 'Job Queues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-queue-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
