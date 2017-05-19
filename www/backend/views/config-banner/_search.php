<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ConfigBannerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="config-banner-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'city_id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'display_order') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'pic') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'offline_date') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
