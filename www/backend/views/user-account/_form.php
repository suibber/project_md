<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserAccount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-account-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'defalut_withdraw_type')->textInput() ?>

    <?= $form->field($model, 'money_all')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'money_balance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'money_success')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'money_doing')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
