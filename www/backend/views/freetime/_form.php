<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Freetime */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="freetime-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dayofweek')->textInput() ?>

    <?= $form->field($model, 'morning')->textInput() ?>

    <?= $form->field($model, 'afternoon')->textInput() ?>

    <?= $form->field($model, 'evening')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
