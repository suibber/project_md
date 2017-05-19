<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\JzWeichatPushSetTemplatePushList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jz-weichat-push-set-template-push-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_time')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'updated_time')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'status')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'create_user')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
