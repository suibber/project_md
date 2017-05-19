<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\JzWeichatPushSetPushset */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jz-weichat-push-set-pushset-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'push_time')->dropDownList(
        $ops['pushtime']
    ) ?>

    <?= $form->field($model, 'push_way')->dropDownList(
        $ops['pushtype']
    ) ?>

    <?= $form->field($model, 'status')->dropDownList(
        $ops['status']
    ) ?>

    <?= $form->field($model, 'template_push_id')->dropDownList(
        $ops['tmp_list']
    ) ?>

    <?= $form->field($model, 'template_weichat_id')->dropDownList(
        $ops['tmp_weichat']
    ) ?>

    <?= $form->field($model, 'created_time')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'update_time')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
