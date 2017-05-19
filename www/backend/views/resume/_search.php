<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ResumeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="resume-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'phonenum') ?>

    <?= $form->field($model, 'gender') ?>

    <?= $form->field($model, 'birthdate') ?>

    <?php // echo $form->field($model, 'degree') ?>

    <?php // echo $form->field($model, 'nation') ?>

    <?php // echo $form->field($model, 'height') ?>

    <?php // echo $form->field($model, 'is_student') ?>

    <?php // echo $form->field($model, 'college') ?>

    <?php // echo $form->field($model, 'avatar') ?>

    <?php // echo $form->field($model, 'gov_id') ?>

    <?php // echo $form->field($model, 'grade') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <?php // echo $form->field($model, 'updated_time') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'home') ?>

    <?php // echo $form->field($model, 'workplace') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
