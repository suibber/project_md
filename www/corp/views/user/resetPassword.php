<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \corp\models\ResetPasswordForm */

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- InstanceBeginEditable name="EditRegion3" -->
<div class="midd-kong"></div>
<div class="container mima">
  <div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12 ">
      <div class="miam-coter">
        <h2>手机号码验证通过！ 重设密码</h2>
        <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
          <div class="midd-input-group">
            <input name="password" type="password" class="input-q"  placeholder="请输入新密码">
          </div>
          <div class="midd-input-group">
            <input name="password1" type="password" class="input-q"  placeholder="再次输入密码">
          </div>
          <a href="#" class="zc-btn">确定</a>
        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>
<!-- InstanceEndEditable -->
<script type="text/javascript">
    $('.zc-btn').on('click', function(){
        $(this).closest('form').submit();
    });
</script>
