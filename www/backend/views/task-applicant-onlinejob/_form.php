<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TaskApplicantOnlinejob */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-applicant-onlinejob-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'app_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'task_id')->textInput() ?>

    <?= $form->field($model, 'needinfo')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'has_sync_wechat_pic')->textInput() ?>

    <?= $form->field($model, 'need_phonenum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'need_username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'need_person_idcard')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
