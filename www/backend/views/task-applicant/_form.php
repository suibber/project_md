<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TaskApplicant */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-applicant-form">

    <?php $form = ActiveForm::begin(); ?>


    <p>申请时间: <?= $model->created_time ?></p>

    <p>申请人: <?= $model->resume->name ?></p>

    <p>任务名: <?= $model->task->title ?></p>

    <?= $form->field($model, 'status')->dropdownList($model::$STATUSES) ?>

    <?= $form->field($model, 'company_alerted')->checkbox() ?>

    <?= $form->field($model, 'applicant_alerted')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
