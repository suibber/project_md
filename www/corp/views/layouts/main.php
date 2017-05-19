<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use corp\assets\AppAsset;
use corp\widgets\Alert;
use common\Utils;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="pragma" content="no-cache">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?=isset($this->blocks['css'])?$this->blocks['css']:''?>
</head>
<body>
    <?php $this->beginBody() ?>
    <!--======导航======-->
    <div class="navbar midd-nav midd-2a3141 navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="midd-nav-head navbar-left">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target="#example-navbar-collapse"> <span class="sr-only">切换导航</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <a class="navbar-brand" href="/"><img src="<?=Yii::$app->params["baseurl.static.corp"]?>/static/img/qiye-logo.png"></a> </div>
                <div class="collapse navbar-collapse" id="example-navbar-collapse">
                    <ul class="nav navbar-nav navbar-right" style=" position:relative;">
                        <?php if (!Yii::$app->user->isGuest){ ?>
                            <li><a href="#" id="shoujifabu-a">手机发职位</a></li>
                            <li class="active"><a href="/task/">我的职位</a></li>
                            <li><a href="/task/publish">我要发布</a></li>
                            <li><a href="/resume/">简历管理
                                <?php if(Yii::$app->session->get('untreated_resume')){ ?>
                                    <em style="background:#fed732  ; border-radius:20px; padding:0 7px;  color:#fff; z-index:40"><?=Yii::$app->session->get('untreated_resume');?></em>
                                <?php } ?>
                            </a></li>
                            <!--
                            <li><a href="/site/message">消息<em style="background:#fed732  ; border-radius:20px; padding:0 10px;  color:#fff; z-index:40">1</em>
                            </a></li>-->
                            <li><a href="/user/info">用户中心</a></li>
                            <li><a href="/user/logout">退出</a></li>
                        <?php }else{ ?>
                            <li><a href="#" id="shoujifabu-a">手机发职位</a></li>
                            <li class="active"><a href="#">我的职位</a></li>
                            <li><a href="#">我要发布</a></li>
                            <li><a href="#">简历管理</a></li>
                            <li><a href="#">用户中心</a></li>
                        <?php }?>
			<div id="shoujifabu-div" style="display:none; background:#2a3141  none repeat scroll 0 0; padding: 20px;position: absolute;right: 0;top: 65px; width: 100%;"><img width="180" height="180" src="http://static.suixb.chongdd.cn/www/static/img/qiye.jpg" style="display:block; margin:0 auto;"><div style="text-align:center; font-size:18px; color:#fff;line-height:50px">扫一扫去手机发布职位</div></div>
                    </ul>
                </div>
            </div>
        </div>
        <!--main content start-->
        <?= $content ?>
        <!--main content end-->
        <div class="foots">
            <div class="container foot">
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <h2>联系我们</h2>
                        <p>邮箱：<?=Utils::getApp()->params['supportEmail']?></p>
                        <p>电话：<?=Utils::getApp()->params['supportTel']?></p>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <h2>关于我们</h2>
                        <p><a href="#">公司介绍</a></p>
                        <p><a href="#">团队介绍</a></p>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <h2>关注我们</h2>
                        <div class="erwei"><img src="<?=Yii::$app->params["baseurl.static.corp"]?>/static/img/mzhan.png" width="70" height="70"><div class="er-text">扫码进入m站</div></div>
                        <div class="erwei"><img src="<?=Yii::$app->params["baseurl.static.corp"]?>/static/img/weixin.png" width="70" height="70"><div class="er-text">关注微信公众号</div></div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endBody() ?>
<?=isset($this->blocks['js'])?$this->blocks['js']:''?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-64201170-1', 'auto');
  ga('send', 'pageview');
    $(document).ready(function(){
        $('#shoujifabu-a').on('click',function(){
            $('#shoujifabu-div').slideToggle(200);
        });
    });
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
