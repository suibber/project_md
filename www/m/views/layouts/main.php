<?php

use yii\helpers\Html;

use m\assets\AppAsset;
use m\assets\WechatAsset;
use m\widgets\Alert;
use common\Utils;
use common\WeichatBase;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
if (Utils::isInWechat()){
    WechatAsset::register($this);
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
    <meta http-equiv="pragma" content="no-cache">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="pragma" content="no-cache">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <link  rel="shortcut icon"  href="/static/img/miduoduo.ico" />
    <meta name="format-detection" content="telephone=no">
    <title><?=$this->page_title?><?=$this->title?> - 米多多兼职</title>
    <meta name="keywords"  content="<?=isset($this->page_keywords)?$this->page_keywords:''?>"/>
    <meta name="description"  content="<?=isset($this->page_description)?$this->page_description:''?>"/>
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
    <?php echo isset($this->blocks['css'])?$this->blocks['css']:''; ?>
</head>
<body>
<?php $this->beginBody() ?>
<div style="height:50px;"></div>
<!--======固定顶部======-->
<nav class="mdd-top-nav"> <?=$this->title?>
    <?php if ($this->nav_left_link){ ?>
        <a href="<?=$this->nav_left_link?>" class="position-l"><i class="iconfont">&#xe60b;</i>  <?=$this->nav_left_title?>  </a> 
    <?php } ?>
    <?php if ($this->nav_right_link){ ?>
        <a href="<?=$this->nav_right_link?>" class="position-r"><?=$this->nav_right_title?><span class="last-icon"></span></a>
    <?php } ?>
</nav>
<?= $content ?>
<?php $this->endBody() ?>
<script>
    GB={};
    GB.is_mobile = (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent));
    GB.click_event = GB.is_mobile?'touchstart':'click';
    GB.login = function($next){
        document.cookie = 'next=' + location.href+ '; expires=Fri, 3 Aug 2030 20:47:11 UTC; path=/';
        location.href = '/user/login';
    }
    GB.signup = function($next){
        document.cookie = 'next=' + location.href+ '; expires=Fri, 3 Aug 2030 20:47:11 UTC; path=/';
        location.href = '/user/vsignup';
    }
    $(function() {
        FastClick.attach(document.body);
    });
</script>
<?php echo isset($this->blocks['js'])?$this->blocks['js']:''; ?>
<?php
if (Utils::isInWechat()){ ?>
    <div style="display:none;">
        <img src="/static/img/weichat_icon.jpg" /> 
    </div>
    <?php if (count($this->wechat_apis)>0){ 
        $wc_session = WeichatBase::getSession();
        $params = $wc_session->generateConfigParams();
        $params['jsApiList'] = $this->wechat_apis;
        $params_json = json_encode($params);
    ?>
    <script>
        wx.config(<?=$params_json?>);
    </script>
    <?php } ?>
<?php } ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-64201170-1', 'auto');
  ga('send', 'pageview');
</script>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?71fce0b5ae66cac6b8ba9fc072998791";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</body>
</html>
<?php $this->endPage() ?>
