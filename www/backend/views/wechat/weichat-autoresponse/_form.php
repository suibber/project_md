<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\WeichatAutoresponse;

/* @var $this yii\web\View */
/* @var $model common\models\WeichatAutoresponse */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="weichat-autoresponse-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->dropDownList(
        $model::$TYPE
    ) ?>

    <?= $form->field($model, 'status')->dropDownList(
        $model::$STATUS
    ) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'response_msg')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
