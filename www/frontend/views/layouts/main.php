<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use common\models\District;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

$city_seo_pinyin = Yii::$app->request->get('city_pinyin')?Yii::$app->request->get('city_pinyin'):Yii::$app->request->get('param_one');
if( $city_seo_pinyin ){
    $city = District::findOne(['seo_pinyin'=>$city_seo_pinyin]);
}

$lastest_seo_pinyin = Yii::$app->session->get('lastest_seo_pinyin');
if( $city_seo_pinyin && ($lastest_seo_pinyin != $city_seo_pinyin) ){
    $lastest_seo_pinyin = $city_seo_pinyin;
    Yii::$app->session->set('lastest_seo_pinyin', $lastest_seo_pinyin);
}
if( $lastest_seo_pinyin ){
    $jz_url = Yii::$app->params["baseurl.frontend"].'/'.$lastest_seo_pinyin.'/p1/';
}else{
    $jz_url = Yii::$app->params["baseurl.frontend"].'/change-city';
}

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <?= Html::csrfMetaTags() ?>
    <title><?=isset($this->page_title)?$this->page_title:''?><?=isset($this->title)?$this->title:''?> - 米多多兼职</title>
    <meta name="keywords"  content="<?=isset($this->page_keywords)?$this->page_keywords:''?>"/>
    <meta name="description"  content="<?=isset($this->page_description)?$this->page_description:''?>"/>
    <link rel="shortcut icon"  href="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/miduoduo.ico" />
    <link href="<?=Yii::$app->params["baseurl.static.www"]?>/static/css/miduoduo.css" type="text/css" rel="stylesheet" >
    <link href="<?=Yii::$app->params["baseurl.static.www"]?>/static/css/task.css" type="text/css" rel="stylesheet" >
    <?php echo isset($this->blocks['css'])?$this->blocks['css']:''; ?>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="nav-top">
        <div class="nav">
            <div class="qiuzhi-logo">
                <a href="<?=Yii::$app->params["baseurl.frontend"]?>" style="margin-left:0px;">
                    <img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/qiuzhi-logo.png" width="60" height="60" alt="米多多兼职">
                </a>
                <?php //echo $city->short_name;exit; ?>
                <?php if(isset($city->short_name)){ ?>
                    <span><?=$city->short_name?><a href="<?=Yii::$app->params["baseurl.frontend"]?>/change-city">[切换城市]</a></span>
                <?php } ?>
            </div>
            <ul>
                <li><a href="<?=Yii::$app->params["baseurl.frontend"]?>">首页</a></li>
                <li><a href="<?=Yii::$app->params["baseurl.frontend"]?>/change-city">米多多网页版</a></li>
                <li><a href="<?=Yii::$app->params["baseurl.m"]?>">手机版</a></li>
                <li><a href="<?=Yii::$app->params["baseurl.corp"]?>">企业版</a></li>
            </ul>
        </div>
    </div>
    <?= $content ?>

    <footer>
      <ul>
        <li class="contact-us1">
          <div class="foot_nav">
            <a href="<?=Yii::$app->params["baseurl.frontend"]?>">米多多求职版</a>
            <a href="<?=Yii::$app->params["baseurl.corp"]?>">米多多企业版</a>
            <a href="#">地推达人</a>
            <a href="<?=Yii::$app->params['downloadApp.android']?>">客户端下载</a>
          </div>
          <div class="lianxi">
            联系我们：&nbsp;&nbsp;邮箱：<?=Yii::$app->params['supportEmail']?>&nbsp;&nbsp;&nbsp;&nbsp;电话：<?=Yii::$app->params['supportTel']?>
          </div>
          <div  class="lianxi">京ICP 备15019760号-3</div>
          <h2>米多多，最快兼职招聘平台！</h2>
        </li>
        <li class="xian"></li>
        <li class="attention-us">
          <div class="erwei_l">
            <div class="er_t">微信二维码</div><img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/ban-erwei.jpg" width="140" height="140"> </div>
          <div class="erwei_r"><div class="er_t">APP下载二维码</div><img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/app.jpg" width="140" height="140"> </div>
        </li>
      </ul>
    </footer>
</body>
</html>
<script src="<?=Yii::$app->params["baseurl.static.www"]?>/static/js/jquery.min.js"></script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function()
    { (i[r].q=i[r].q||[]).push(arguments)}

    ,i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-64201170-1', 'auto');
    ga('send', 'pageview');
    </script>
    <script>
    var _hmt = _hmt || [];
    (function()
    { var hm = document.createElement("script"); hm.src = "//hm.baidu.com/hm.js?71fce0b5ae66cac6b8ba9fc072998791"; var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(hm, s); }

    )();
</script>
<?php echo isset($this->blocks['js'])?$this->blocks['js']:''; ?>
<?php $this->endPage() ?>
