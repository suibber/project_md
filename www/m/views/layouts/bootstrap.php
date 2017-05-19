<?php
use yii\helpers\Html;

use common\Utils;
use common\WeichatBase;
use m\assets\BootstrapAsset;
use m\assets\WechatAsset;

/* @var $this \yii\web\View */
/* @var $content string */

BootstrapAsset::register($this);

if (Utils::isInWechat()){
    WechatAsset::register($this);
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
    <meta http-equiv="pragma" content="no-cache">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="pragma" content="no-cache">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">

    <?= Html::csrfMetaTags() ?>
    <title><?=$this->page_title?><?=$this->title?> - 米多多兼职</title>
    <meta name="keywords"  content="<?=isset($this->page_keywords)?$this->page_keywords:''?>"/>
    <meta name="description"  content="<?=isset($this->page_description)?$this->page_description:''?>"/>
    <?php $this->head() ?>
    <?php echo isset($this->blocks['css'])?$this->blocks['css']:''; ?>
</head>
<body>
<!-- 添加隐藏的logo图片300*300用于微信分享图标 - start -->
<div style="display:none;">
    <img src="<?=Yii::$app->params["baseurl.static.m"]?>/static/img/weichat_icon.jpg" /> 
</div>
<!-- 添加隐藏的logo图片300*300用于微信分享图标 - end -->
<?php $this->beginBody() ?>
<div class="container">
    <nav class="navbar-fixed-top top-nav" role="navigation">
        <div class="nav-head text-center">
         <?php if ($this->nav_left_link){ ?>
             <a style="height: 50px; line-height: 50px; min-width:60px;" class="text-left pull-left" href="<?=$this->nav_left_link?>">
                <?php if(!$this->nav_left_title){ ?>
                    <span class="glyphicon glyphicon-chevron-left"> </span>
                <?php } ?>
                <?=$this->nav_left_title?>
            </a>
         <?php } else {?>
            <a style="height: 50px; line-height: 50px; min-width:60px;" class="text-left pull-left"> </a>
         <?php }?>
         <span><?=$this->title?></span>
         <?php if ($this->nav_right_link){ ?>
             <a style="height: 50px; line-height: 50px; min-width:60px;" class="text-right pull-right" href="<?=$this->nav_right_link?>">
                <?=$this->nav_right_title?></a>
         <?php } else {?>
            <a style="height: 50px; line-height: 50px; min-width:60px;" class="text-right pull-right">&nbsp;</a>
         <?php }?>
    </nav>
    <nav class="top-nav"></nav>
    <?= $content ?>
</div>
<div class="bz_pic"><img src="<?=Yii::$app->params["baseurl.static.m"]?>/static/img/bz_pic.jpg"></div>
<div class="m_midd_foot">
   <ul>
      <li><a href="#">触屏版</a></li>
      <li class="bor_left"><a href="<?=Yii::$app->params["baseurl.frontend"]?>">电脑版</a></li>
      <li  class="bor_left bor_right"><a href="<?=Yii::$app->params["downloadApp.android"]?>">客户端</a></li>
      <li><a href="<?=Yii::$app->params["baseurl.m"]?>/index.php/site/wechat">微信版</a></li>
   </ul>
   <div class="foot_div"><a href="<?=Yii::$app->params["baseurl.frontend"]?>">求职版</a><a href="<?=Yii::$app->params["baseurl.corp"]?>">企业版</a></div>
   <div class="foot_div1">北京米多多兼职   京ICP备15019760号-3</div>
</div>
<?php $this->endBody() ?>
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
    GB={};
    GB.is_mobile = (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent));
    GB.click_event = GB.is_mobile?'touchstart':'click';
    $(function() {
        FastClick.attach(document.body);
    });
</script>
<?php echo isset($this->blocks['js'])?$this->blocks['js']:''; ?>
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
