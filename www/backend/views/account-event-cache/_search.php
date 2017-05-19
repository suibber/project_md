<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AccountEventCacheSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-event-cache-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'value') ?>

    <?= $form->field($model, 'operator_id') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <?php // echo $form->field($model, 'balance') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'related_id') ?>

    <?php // echo $form->field($model, 'task_gid') ?>

    <?php // echo $form->field($model, 'locked') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
