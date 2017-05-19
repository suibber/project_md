<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JobQueueSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="job-queue-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'task_name') ?>

    <?= $form->field($model, 'params') ?>

    <?= $form->field($model, 'retry_times') ?>

    <?= $form->field($model, 'start_time') ?>

    <?php // echo $form->field($model, 'priority') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'message') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
