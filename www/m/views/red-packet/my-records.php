<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
<meta http-equiv="pragma" content="no-cache">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta http-equiv="pragma" content="no-cache">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<title>米多多百万现金红包大派送！</title>
<link href="<?=Yii::$app->params['baseurl.static.m']?>/static/css/red-packet.css" type="text/css" rel="stylesheet">
</head>

<body>
<div class="bot_box"><img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/bot_img.jpg"></div>
<div id="tab">
  <div class="tab_box">
    <div>
      <h2>共计<?=$invited_all_people?>人，可提现<?=$invited_all_value?>元</h2>
      <ul>
            <?php foreach($inviteds as $invited){ ?>
                <li>
                    <span>
                        <?=isset($invited->created_time)?str_ireplace(' ','日 ',str_ireplace('-','月',substr($invited->created_time,5,11))):'未注册'?></li>
                    </span>
                    <?=isset($invited->invitee->username)?(substr($invited->invitee->username,0,3).'****'.substr($invited->invitee->username,-4)):'未注册'?></li>
            <?php } ?>
        </ul>
    </div>
  </div>
</div>
</body>
</html>
