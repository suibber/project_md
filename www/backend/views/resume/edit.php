<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonGroup;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;

use common\models\Resume;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginWithDynamicCodeForm */

$this->title = '编辑简历';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
        <?php $form = ActiveForm::begin([
                'id' => 'edit-resume-form',
                "options"=>['class'=>'form-horizontal']]); ?>
            <?= $form->field($model, 'name'       ) ?>
            <?= $form->field($model, 'phonenum'   ) ?>
            <?= $form->field($model, 'gender')
                ->dropDownList(Resume::$GENDERS)?>
            <?= $form->field($model, 'is_student' )
                ->checkBox(['checked' => true]) ?>
            <?= $form->field($model, 'grade')
                ->dropDownList(Resume::$GRADES)?>
            <?= $form->field($model, 'college'    ) ?>
            <?= $form->field($model, 'degree'     )
                ->dropDownList(Resume::$DEGREES)?>
            <?= $form->field($model, 'birthdate'  )
                ->widget(DatePicker::className(),
                        ['dateFormat' => 'yyyy-MM-dd'])->textInput() ?>
            <?= $form->field($model, 'nation'     ) ?>
            <?= $form->field($model, 'height'     ) ?>
            <?= $form->field($model, 'avatar'     ) ?>
            <?= $form->field($model, 'gov_id'     ) ?>
            <?= $form->field($model, 'worker_type') ?>
            <?= $form->field($model, 'status'     )
                ->dropDownList(Resume::$STATUSES) ?>

            <div class="form-group">
                <?= Html::submitButton('下一步', ['class' => 'btn btn-danger col-xs-12', 'name' => 'login-button']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
