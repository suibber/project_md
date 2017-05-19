<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = '已报名兼职';

$this->nav_left_link = 'javascript:window.history.back()';
$this->nav_right_link = Url::to(['site/index']);
$this->nav_right_title = '首页';
?>

<!--
<nav class="navbar-fixed-top top-nav" role="navigation">
<div class="nav-head"><a href="#" class="text-left pull-left" style="padding:0 10px;font-size:1.4rem;" ><span class="glyphicon glyphicon-menu-left" aria-hidden="true" style="top:3px;"></span></a>我的收藏<a href="#" class="pull-right" style="font-size:1.4rem; padding:0 10px;">首页</a></div>
</nav>
<div class="nav-tabs">
<a href="#" class="pull-left text-center active">已报名</a><a href="#" class="pull-right text-center">已收藏</a>
</div>
<div style="height:110px;"></div>
-->
<!--===========以上是固定在顶部的==============-->

<?=
    $this->render('@m/views/task/task-apply-list.php', [
        'tasks' => $tasks,
        'pages' => $pages
    ])
?>

