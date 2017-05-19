<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WeichatErweimaLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="weichat-erweima-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'erweima_id')->textInput() ?>

    <?= $form->field($model, 'openid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'has_bind')->textInput() ?>

    <?= $form->field($model, 'follow_by_scan')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
