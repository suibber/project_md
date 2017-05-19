<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AppReleaseVersionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-release-version-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'device_type') ?>

    <?= $form->field($model, 'app_version') ?>

    <?= $form->field($model, 'html_version') ?>

    <?= $form->field($model, 'update_url') ?>

    <?php // echo $form->field($model, 'release_time') ?>

    <?php // echo $form->field($model, 'h5_map_file') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
