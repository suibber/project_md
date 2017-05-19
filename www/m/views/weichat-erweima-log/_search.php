<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WeichatErweimaLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="weichat-erweima-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'erweima_id') ?>

    <?= $form->field($model, 'openid') ?>

    <?= $form->field($model, 'create_time') ?>

    <?= $form->field($model, 'has_bind') ?>

    <?php // echo $form->field($model, 'follow_by_scan') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
