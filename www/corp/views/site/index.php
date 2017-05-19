<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
$this->title = '米多多兼职平台';
?>
<!-- InstanceBeginEditable name="EditRegion3" -->
<!--======banner======-->
<div class="midd-kong"></div>
<div class="banner">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-7 banner-left">
        <h2>米多多最快兼职招聘神器</h2>
        <h1>招人更快 更优秀</h1>
        <div class="h4"> <span class="h4-l pull-left"></span>
          <h4>让兼职招聘管理变的轻松</h4>
          <span class="h4-r pull-left"></span> </div>
          <div style="margin:20px 0"><img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/qiye.jpg" width="140" height="140" ><h3 class="fixde"  style="float: right;font-size: 33px;line-height: 50px;margin-top:20px;width: 73%;" >超大兼职库，算法匹配，系统推送，人工触达，快速响应</h3></div>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-5">
        <div class="tab">
          <div class="menusWrapper"> <a class="active top_switcher" href="javascript:;">企业HR注册</a> <a href="javascript:;" class="top_switcher">登录</a> </div>
          <div class="ctnerWrapper">
            <div class="ctnerBox">
              <div id="cbox-1" class="cbox">
              <div class="error-message">手机号不能为空！</div>
                  <?php $form = ActiveForm::begin();?>
                    <div class="midd-input-group">
                  <input name="username" type="text" class="pull-left" placeholder="请输入手机号">
                  <input name="check_existed" type="hidden" value="1"/>
                  <span class="yz-btn pull-left text-center">发送验证码</span> </div>
                <div class="midd-input-group">
                  <input name="vcode" type="text" class="input-q"  placeholder="请输入短信验证码">
                </div>
                <div class="midd-input-group">
                  <input name="password" type="password" class="input-q"  placeholder="请设置登录密码">
                </div>
                <div class="midd-xieyi">
 <!--                 <input name="reg-agree" class="pull-left" type="checkbox" value="">
                  <a href="">同意米多多兼职企业用户协议</a>-->
</div>
                <a href="#" class="zc-btn">注册</a>
              </div>
            <?php ActiveForm::end(); ?>
              <div id="cbox-2" class="cbox">
                <div class="error-message">用户名不能为空！</div>
                <div class="ctnerTab"><a href="#" class="on">普通方式登录</a> <a href="#">手机动态码登录</a></div>
               <div class="myNavs rtNavs">
                    <?php $form = ActiveForm::begin();?>
                        <div class="midd-input-group">
                      <input name="username" type="text" class="input-q"  placeholder="用户名">
                    </div>
                    <div class="midd-input-group">
                      <input name="password" type="password" class="input-q"  placeholder="密码">
                    </div>
                    <div class="midd-xieyi">
                      <input name="rememberme" class="pull-left" type="checkbox" value="">记住我 <a href="/user/request-password-reset" class=" pull-right">忘记密码</a></div>
                    <a href="#" class="zc-btn"> 登录</a>
                   <?php ActiveForm::end(); ?>
                </div>
                <div class="hotNavs rtNavs">
                        <?php $form = ActiveForm::begin();?>
                        <div class="midd-input-group">
                          <input name="username" type="text" class="pull-left"  placeholder="请输入手机号">
                          <span class="yz-btn pull-left text-center">发送验证码</span> </div>
                        <div class="midd-input-group">
                          <input name="vcode" type="text" class="input-q"  placeholder="请输入短信验证码">
                        </div>
                        <div class="midd-xieyi">
 <!--                         <label>
                            <input name="rememberMe" class="pull-left" type="checkbox" value="">
                            <span>两周内自动登录</span></label> -->
                        </div>
                        <a href="#" class="zc-btn">登录</a>
                      <?php ActiveForm::end(); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--======主体部分======-->
<div class="container cent">
  <div class="row">
    <div class="col-sm-12 col-md-4 col-lg-4">
      <div class="zt-box">
      <div class="img"><img src="<?=Yii::$app->params['baseurl.static.corp']?>/static/img/youhua.png" class="img-responsive" alt="优化成本"> </div>
        <h2 class="yh-title">优化成本</h2>
        <div class="yh-tag"> <span><em>■</em>弹性工作</span><span><em>■</em>共享人力</span><span><em>■</em>组合工时</span><span><em>■</em>节约人工</span> </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-4 col-lg-4">
      <div class="zt-box">
        <div class="img"><img src="<?=Yii::$app->params['baseurl.static.corp']?>/static/img/zhineng.png" class="img-responsive" alt="优化成本"> </div>
        <h2 class="yh-title">智能匹配</h2>
        <div class="yh-tag"> <span><em>■</em>经验标签</span><span><em>■</em>工作记录</span><span><em>■</em>雇主评价</span><span><em>■</em>算法推理</span> </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-4 col-lg-4">
      <div class="zt-box">
        <div class="img"><img src="<?=Yii::$app->params['baseurl.static.corp']?>/static/img/guanli.png" class="img-responsive" alt="优化成本"> </div>
        <h2 class="yh-title">优化成本</h2>
        <div class="yh-tag"> <span><em>■</em>灵活排班</span><span><em>■</em>智能签到</span><span><em>■</em>工时优化</span><span><em>■</em>节约人工</span> </div>
      </div>
    </div>
  </div>
</div>
<script>
  $('.ctnerTab a').click(function(){
			if(!$(this).hasClass('on')){
				$('.ctnerTab a').removeClass('on').eq($(this).index()).addClass('on');
				$('.rtNavs').stop(true,true).hide().eq($(this).index()).show();
			}
		});

		$('.menusWrapper a').click(function(){
			if(!$(this).hasClass('active')){
				$('.menusWrapper a').removeClass('active').eq($(this).index()).addClass('active');
				$('.cbox').stop(true,true).animate().hide().eq($(this).index()).animate().show();
			}
		});
</script>
<!-- InstanceEndEditable -->
<?php
$this->registerJsFile(Yii::$app->params["baseurl.static.corp"] . '/static/js/index.js');
?>
