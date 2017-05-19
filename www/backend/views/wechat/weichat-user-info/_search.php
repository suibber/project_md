<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WeichatUserInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="weichat-user-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'openid') ?>

    <?= $form->field($model, 'userid') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'created_time') ?>

    <?php // echo $form->field($model, 'updated_time') ?>

    <?php // echo $form->field($model, 'weichat_name') ?>

    <?php // echo $form->field($model, 'weichat_head_pic') ?>

    <?php // echo $form->field($model, 'is_receive_nearby_msg') ?>

    <?php // echo $form->field($model, 'origin_type') ?>

    <?php // echo $form->field($model, 'origin_detail') ?>

    <?php // echo $form->field($model, 'erweima_ticket') ?>

    <?php // echo $form->field($model, 'erweima_date') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
