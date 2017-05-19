<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

$user = Yii::$app->user;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php echo isset($this->blocks['css'])?$this->blocks['css']:''; ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
              <ul id="sidebar" class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="/"> 米多多 </a>
                </li>
<?php if ($user->can('admin')) { ?>
                <li class="mtitle" data-group="admin"><a>账号，简历，任务分类</a></li>
                <li class="mmenu" data-group="admin"><a href="/user">账号管理</a></li>
                <li class="mmenu" data-group="admin"><a href="/user/set-role">角色管理</a></li>
                <li class="mmenu" data-group="admin"><a href="/district">城市</a></li>
                <li class="mmenu" data-group="admin"><a href="/service-type">任务类型</a></li>
<?php } ?>

<?php if ($user->can('operation_manager')) { ?>
                <li class="mtitle" data-group="operation"><a>信息运营</a></li>
                <li class="mmenu" data-group="operation"><a href="/task">任务</a></li>
                <li class="mmenu" data-group="operation"><a href="/task?TaskSearch[service_type_id]=17">在线任务</a></li>
                <li class="mmenu" data-group="operation"><a href="/task-applicant-onlinejob/index?sort=-created_time">在线任务报名</a></li>
                <li class="mmenu" data-group="operation"><a href="/task-applicant">任务报名单</a></li>
                <li class="mmenu" data-group="operation"><a href="/task-pool">爬虫-任务列表</a></li>
                <li class="mmenu" data-group="operation"><a href="/task-pool-white-list">爬虫-白名单(黑名单)</a></li>
                <li class="mmenu" data-group="operation"><a href="/company">企业库</a></li>
                <li class="mmenu" data-group="operation"><a href="/resume">人才库</a></li>
                <li class="mmenu" data-group="operation"><a href="/config-recommend/index?sort=-id">配置-推荐兼职</a></li>
                <li class="mmenu" data-group="operation"><a href="/config-banner/index?sort=-id">配置-首页广告</a></li>
<?php } ?>
<?php if ($user->can('operation_manager')) { ?>
    <li class="mtitle" data-group="yunying"><a>运营</a></li>
    <li class="mmenu" data-group="yunying"><a href="/red-packet/index?sort=-red_packet_num">微信红包</a></li>
<?php } ?>

<?php if ($user->can('operation_manager')) { ?>
                <li class="mtitle" data-group="wechat"><a>微信</a></li>
                <li class="mmenu" data-group="wechat"><a href="/weichat-push-set-pushset">微信推送-附近</a></li>
                <li class="mmenu" data-group="wechat"><a href="/weichat-push-set-template-push-list">微信推送-附近-模板</a></li>
                <li class="mmenu" data-group="wechat"><a href="/weichat-push-quality-task">微信推送-优单</a></li>
                <li class="mmenu" data-group="wechat"><a href="/weichat-user-info">微信推送-绑定用户</a></li>
                <li class="mmenu" data-group="wechat"><a href="/weichat-erweima?sort=-id">微信二维码</a></li>
                <li class="mmenu" data-group="wechat"><a href="/weichat-autoresponse">微信自动回复</a></li>
<?php } ?>

<?php if ($user->can('finance_manager')) { ?>
                <li class="mtitle" data-group="finance"><a>资金账户管理</a></li>
                <li class="mmenu" data-group="finance"><a href="/account-event-cache">工资流水-待发工资</a></li>
                <li class="mmenu" data-group="finance"><a href="/account-event">工资流水-已发工资</a></li>
                <li class="mmenu" data-group="finance"><a href="/withdraw-cash">提现流水</a></li>
                <li class="mmenu" data-group="finance"><a href="/user-account">用户资金</a></li>
<?php } ?>

<?php if ($user->can('operation_manager')) { ?>
                <li class="mtitle" data-group="feedback"><a>用户反馈</a></li>
                <li class="mmenu"  data-group="feedback"><a href="/complaint">投诉列表</a></li>
                <li class="mmenu"  data-group="feedback"><a href="/contact-us">联系我们的客户</a></li>
<?php } ?>

<?php if ($user->can('admin')) { ?>
                <li class="mtitle" data-group="analytics"><a>统计</a></li>
                <li class="operation_managermmenu" data-group="analytics"><a href="/data-user">数据统计</a></li>
                <li class="operation_managermmenu" data-group="analytics"><a href="/analytics/applicant">多城市报名统计</a></li>
<?php } ?>

<?php if ($user->can('developer')) { ?>
                <li class="mtitle" data-group="dev"><a>产品研发</a></li>
                <li class="mmenu" data-group="dev"><a href="/app-release-version">应用发布管理</a></li>
                <li class="mmenu" data-group="dev"><a href="/job-queue">异步任务</a></li>
                <li class="mmenu" data-group="dev"><a href="/user/delete-myself" data-method="post" data-confirm="删除后所有的数据将被清掉，确定删除?">自杀</a></li>
<?php } ?>

                <li class="hidden">
                    <a href="/support/report-bug">
                    <span class="glyphicon glyphicon-flag" style="color:red;"></span> 提交bug
                    </a>
                </li>
                <li>&nbsp;</li>
<?php if (Yii::$app->user->isGuest) { ?>
                <li><a href="/site/login">登陆</a></li>
<?php } else { ?>
                <li><a href="/site/logout" data-method="post">退出</a></li>
<?php } ?>


        </div>
        <div id="page-content-wrapper">
            <div id="sidebar-toggle" class="text-right">
                <span class="glyphicon glyphicon-list"></span>
            </div>
            <div class="container-fluid">
<?= $content ?>
            </div>
        </div>
    </div>
    <?php $this->endBody() ?>
    <script>
        GB={};
        GB.is_mobile = (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent));
        GB.click_event = GB.is_mobile?'touchstart':'click';
    </script>
    <?php echo isset($this->blocks['js'])?$this->blocks['js']:''; ?>
    <script>
        $(function(){
            var uri=location.pathname.split('?')[0];
            console.info(uri);

            $.each($('#sidebar a'), function(i, v){
                var a =$(v);
                var muri = a.attr('href');
                if (muri && uri==muri.split('?')[0]){
                    var li = a.closest('li');
                    li.addClass('active');
                    $(".mmenu").hide();
                    $("[data-group='" + li.attr('data-group') +"']").show();
                }
            });
            $(".mtitle").click(function(){
                $("[data-group='"+ $(this).attr('data-group') +"']").toggle();
                $(this).toggle();
            });
        });

    </script>
        <script>
    $("#sidebar-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
</body>
</html>
<?php $this->endPage() ?>
