<?php
use yii\helpers\Html;
use yii\bootstrap\ButtonGroup;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginWithDynamicCodeForm */

$this->title = $signuping?'使用手机号注册':'动态手机验证码登录';
$this->params['breadcrumbs'][] = $this->title;

$this->nav_left_link = 'javascript:window.history.back()';
$this->nav_right_link = '/user/login';
$this->nav_right_title = '登录';

?>
<div class="site-login">
    <div style='padding: 40px 0 10px 10px;color: #999;' > <?=$this->title?> </div>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="form-list">
          <?= $form->field($model, 'phonenum')->label('手机号')
              ->input('tel', $options = ['data-id'=>'phonenum'] ) ?>
          <div class="form-group">
            <label>验证码</label>
            <div class="yzm">
              <button id="svcode" type="button" class="btn btn-default form-yzm">获取验证码</button>
              <input type="text" id="<?= Html::getInputId($model, 'code') ?>"
                  class="form-control" name="<?= Html::getInputName($model, 'code')?>">
            </div>
            <p class="help-block help-block-error"><?=$model->getFirstError('code')?></p>
          </div>
          <!--
          <?= $signuping?$form->field($model, 'invited_code')->label('邀请码'):'' ?>
          -->

                </div>
        </div>
        <p class="block-btn">
            <?= Html::submitButton('下一步', ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'login-button']) ?>
        </p>
            <?php ActiveForm::end(); ?>
        <p class="text-right" style="padding-right: 15px; ">
            <a href="/user/vlogin">找回密码</a>
            &nbsp; &nbsp; &nbsp; &nbsp;
            <a href="/user/vlogin">手机验证码登录</a>
        </p>
</div>


<?php $this->beginBlock('js') ?>
<script>
    $(function(){
        var flag=false;
        var vbtn = $("#svcode");
        var pipt = $('input[data-id="phonenum"]');
        var fp = pipt.closest('.form-group');
        var help=fp.find('.help-block');
        var wait=60;
        function time(o) {
            help.html('请您留意短信或来电');
            if (wait == 0) { 
                o.removeClass('form-yzm-c').removeAttr("disabled");
                o.html("获取验证码");
                wait = 60;
            } else {
                o.html(wait + "秒后重试");
                wait--;
                setTimeout(function() { time(o); }, 1000);
            }
        }

        vbtn.bind(GB.click_event, function(){
            if (flag) {
                return false;
            }
            flag = true;
            setTimeout(function(){ flag = false; }, 100);
            $.ajax({url: "<?=$signuping?'/user/vcode-for-signup':'/user/vcode'?>",
                'method': 'POST',
                'data': {'phonenum': pipt.val(), 't': $.now()}})
            .done(function(text){
                data =$.parseJSON(text);
                if (data['result']){
                    vbtn.addClass('form-yzm-c').attr("disabled","disabled");
                    time(vbtn);
                } else {
                    fp.addClass('has-error');
                    help.html(data['msg']);
                }
            }).fail(function(){
                fp.addClass('has-error');
                help.html("网络出现问题，请重试.");
            });
        });
    });
</script>
<?php $this->endBlock('js') ?>
