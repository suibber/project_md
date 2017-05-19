<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;

use common\Constants;

/* @var $this yii\web\View */
/* @var $model common\models\AppReleaseVersion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-release-version-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'device_type')->dropdownList([
            Constants::DEVICE_ANDROID => "安卓",
            Constants::DEVICE_IOS => "苹果",
        ]) ?>

    <?= $form->field($model, 'app_version')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'api_version')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'html_version')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'update_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'features')->textArea(['rows' => '6']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
