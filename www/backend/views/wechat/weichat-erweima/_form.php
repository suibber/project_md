<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WeichatErweima */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="weichat-erweima-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <?php if(!$model->type){ ?>
        <?= $form->field($model, 'type')->dropDownList(
            array(1=>'一周有效',2=>'永久有效')
        ) ?>
    <?php } ?>

    <?= $form->field($model, 'create_time')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'update_time')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'scene_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'ticket')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'after_msg')->textArea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
