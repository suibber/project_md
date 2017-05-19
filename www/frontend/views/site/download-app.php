<?php

?>
<html>
<head>
    <title>米多多兼职app下载</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
    <meta http-equiv="pragma" content="no-cache">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="pragma" content="no-cache">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">

</head>
<body>
<a href="<?=Yii::$app->params['downloadApp.android']?>">
    <button style="position: fixed; top: 0;bottom: 50%; left: 0;right: 0; width: 100%; background-color:#f39c12; text-align:center; color: #fff; font-size: 10em;border:none;">
        Android
    </button>
</a>
<a href="<?=Yii::$app->params['downloadApp.ios']?>">
    <button style="position: fixed; top: 50%;bottom: 0; left: 0;right: 0; width: 100%; background-color: #27ae60; text-align: center; color: #fff; font-size: 10em;border: none;">
        Ios
    </button>
</a>
</body>
</html>
