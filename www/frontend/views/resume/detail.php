<?php
use Yii;
use common\models\Resume;
use common\models\ServiceType;

$service_types = ServiceType::find()->asArray()->all();
$service_types_arr  = array();
foreach( $service_types as $k => $v ){
   $service_types_arr[$v['id']] = $v['name'];
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>简历详情</title>
    <link href="<?=Yii::$app->params["baseurl.static.www"]?>/static/css/jianli.css" type="text/css" rel="stylesheet" />
</head>

<body>
<div class="top">
  <div class="top-logo">
    <div class="logo-box"><div class="logo"><img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/logo.jpg" width="96" height="50"></div></div>
  </div>
    <div class="head-img"><img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/head-img.png"></div>
</div>
<div class="name-bg">
    <div class="name-nav">
        <div class="name-center"><a href="<?= Yii::$app->params['baseurl.frontend'] ?>">进入米多多兼职平台查看&nbsp;&gt;</a><?= $resume['name'] ?></div>
    </div>
</div>
<div class="center">
     <div class="center-box">
         <div class="tag">基本信息</div>
         <ul class="jiben">
            <!--li><span>年龄：</span>无字段</li-->
            <li><span>性别：</span><?= Resume::$GENDERS[$resume['gender']] ?></li>
            <!--li><span>身高：</span><?= $resume['height'] ?></li-->
            <!--li class="shenfen"><span>身份证已认证</span></li-->
         </ul>
         <div class="tag">联系方式</div>
         <ul class="xinxi">
            <li><span>电话：</span><?= $resume['phonenum'] ?></li>
            <!--li><span>微信：</span>你好米多多</li-->
            <!--li><span>地址：</span><?= $resume['workplace'] ?></li-->
            <li><span>学校：</span><?= $resume['college'] ?></li>
         </ul>
         <div class="tag">兼职信息</div>
         <ul class="xinxi">
            <!--li><span>做过的兼职：</span><?= $resume['job_wishes'] ?></li-->
            <li><span>兼职意愿：</span><?= $resume['job_wishes'] ?></li>
         </ul>
         <div class="tag">米多多兼职</div>
         <ul class="jingyan">
            <?php foreach($resume['applicantDone'] as $k => $v){ ?>
                <li><em></em><p><?= $v['task']['from_date'] ?>至<?= $v['task']['to_date'] ?>    |    <?= $service_types_arr[$v['task']['service_type_id']] ?>    |    <?= $v['task']['title'] ?></p></li>
            <?php } ?>
         </ul>
     </div>
</div>
</body>
</html>
