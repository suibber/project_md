<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \m\models\ResetPasswordForm */

$this->title = '设置密码';
$this->params['breadcrumbs'][] = $this->title;


$this->nav_left_link = 'javascript:window.history.back()';
$this->nav_right_link = '/';
$this->nav_right_title = '首页';
?>
    <div style='padding: 40px 0 10px 10px;color: #999;' > <?=$this->title?> </div>
    <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
<div class="form-list">
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'password2')->passwordInput() ?>
</div>
<p class="block-btn">
    <?= Html::submitButton('设置', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
</p>
<?php ActiveForm::end(); ?>

