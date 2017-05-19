<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use common\models\Company;

/* @var $this yii\web\View */
/* @var $model common\models\Company */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropdownList(Company::$STATUSES) ?>

    <?= $form->field($model, 'exam_status')->dropdownList(Company::$EXAM_STATUSES) ?>
    <?= $form->field($model, 'exam_result')->dropdownList(Company::$EXAM_RESULTS) ?>

    <?= $form->field($model, 'origin')->dropdownList(Company::$ORIGINS) ?>

    <?= $form->field($model, 'intro')->textArea() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
