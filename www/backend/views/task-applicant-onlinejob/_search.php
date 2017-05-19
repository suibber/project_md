<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TaskApplicantOnlinejobSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-applicant-onlinejob-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'reason') ?>

    <?= $form->field($model, 'app_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'task_id') ?>

    <?php // echo $form->field($model, 'needinfo') ?>

    <?php // echo $form->field($model, 'has_sync_wechat_pic') ?>

    <?php // echo $form->field($model, 'need_phonenum') ?>

    <?php // echo $form->field($model, 'need_username') ?>

    <?php // echo $form->field($model, 'need_person_idcard') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <?php // echo $form->field($model, 'updated_time') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
