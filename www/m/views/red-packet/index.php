<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
<meta http-equiv="pragma" content="no-cache">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta http-equiv="pragma" content="no-cache">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<title>
    <?php if(isset($weichat_user->resume->name)){ ?>
        <?=$weichat_user->resume->name?>分享的米多多百万现金红包大派送，立即领取！
    <?php }else{ ?>
        我分享的米多多百万现金红包大派送，立即领取！
    <?php } ?>
</title>
<link href="<?=Yii::$app->params['baseurl.static.m']?>/static/css/red-packet.css" type="text/css" rel="stylesheet">
</head>

<body>
<!-- 添加隐藏的logo图片300*300用于微信分享图标 - start -->
<div style="display:none;">
    <img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/hongbao.jpg" /> 
</div>
<!-- 添加隐藏的logo图片300*300用于微信分享图标 - end -->
<div class="top_banner"><img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/fx_top.jpg"></div>
<a href="#" class="fx_box">
    <img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/fx_erwei.jpg" >
    <div class="erweima"><img src="<?=Yii::$app->params['weichat']['url']['erweima_show'].$erweima_ticket?>" ></div>
</a>


</body>
</html>

