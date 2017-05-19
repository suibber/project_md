<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ConfigRecommend */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="config-recommend-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'city_id')->dropDownList(
        $model->getCityList()
    ) ?>

    <?= $form->field($model, 'task_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(
        Yii::$app->params['config']['recommend_type']
    ) ?>

    <?= $form->field($model, 'display_order')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
