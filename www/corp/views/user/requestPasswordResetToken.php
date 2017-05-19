<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \corp\models\PasswordResetRequestForm */

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- InstanceBeginEditable name="EditRegion3" -->
<div class="midd-kong"></div>
<div class="container mima">
  <div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12 ">
      <div class="miam-coter">
      <h2>找回密码</h2>
      <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
        <div class="midd-input-group">
          <input name="username" type="text" class="pull-left"  placeholder="请输入手机号">
          <span class="yz-btn pull-left text-center">获取验证码</span> </div>
        <div class="midd-input-group">
          <input name="vcode" type="text" class="input-q"  placeholder="请输入短信验证码">
        </div>
        <a href="#" class="zc-btn">下一步</a>
        </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>
<script type="text/javascript">
    $('.zc-btn').on('click', function(){
        $(this).closest('form').submit();
    });
    $('.yz-btn').on('click', function(){
        var phone = $(this).closest('form').find('[name="username"]').val();
        if (phone.length == 0) {
            alert("请输入手机号");
            return;
        }
        $.get('/user/vcode', $(this).closest('form').serialize())
            .done(function(str){
                var data = JSON.parse(str);
                if(data.result == false){
                   alert(data.msg);
                   return;
                }
                $(this).removeClass('yz-btn');
                $(this).addClass('yz-btn-jx');
                counter($(this), 60);
        });
    });
    function counter($el, n) {
        (function loop() {
           $el.html("重新发送(" + n + ")");
           if (n--) {
               setTimeout(loop, 1000);
           }else {
               $el.addClass('yz-btn');
           	   $el.removeClass('yz-btn-jx');
                  $el.html('发送验证码');
           }
        })();
    }
<?php
if($model->errors){
    echo 'alert("'.array_shift(array_values($model->errors))[0].'");';
} ?>

</script>
