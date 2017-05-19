<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TaskSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'clearance_period') ?>

    <?= $form->field($model, 'salary') ?>

    <?= $form->field($model, 'salary_unit') ?>

    <?php // echo $form->field($model, 'salary_note') ?>

    <?php // echo $form->field($model, 'from_date') ?>

    <?php // echo $form->field($model, 'to_date') ?>

    <?php // echo $form->field($model, 'from_time') ?>

    <?php // echo $form->field($model, 'to_time') ?>

    <?php // echo $form->field($model, 'need_quantity') ?>

    <?php // echo $form->field($model, 'got_quantity') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <?php // echo $form->field($model, 'updated_time') ?>

    <?php // echo $form->field($model, 'detail') ?>

    <?php // echo $form->field($model, 'requirement') ?>

    <?php // echo $form->field($model, 'address_id') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'service_type_id') ?>

    <?php // echo $form->field($model, 'gender_requirement') ?>

    <?php // echo $form->field($model, 'degree_requirement') ?>

    <?php // echo $form->field($model, 'age_requirement') ?>

    <?php // echo $form->field($model, 'height_requirement') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'city_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
