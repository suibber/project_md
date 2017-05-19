<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ConfigBanner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="config-banner-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'city_id')->dropDownList(
        $model->getCityList()
    ) ?>

    <?= $form->field($model, 'status')->dropDownList(
        $model::$STATUS
    ) ?>

    <!-- <?= $form->field($model, 'type')->textInput() ?> -->

    <?= $form->field($model, 'display_order')->dropDownList(
        $model::$DISPLAY_ORDER
    ) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'task_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'offline_date')->widget(\yii\jui\DatePicker::classname(), []) ?>

    <?= $form->field($model, 'pic')->fileInput() ?>
    
    <!--  <?= $form->field($model, 'created_time')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', '创建') : Yii::t('app', '更新'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
