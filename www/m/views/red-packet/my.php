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
<div class="midd_top"><img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/midd_top.jpg"></div>
<div class="midd_main"> <img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/hongbao.png" >
  <div class="title_hb"><img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/my_hb.png"></div>
  <div class="jin_e"><?=str_ireplace('.00','',$invited_all_value)?><span style="font-size:14px; margin-top:-10px;">元</span></div>
  <div class="text_b"> <div class="pic"><img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/hb_sm.png"></div>
  <a href="javascript:;" class="fenx cd-popup-trigger fenxiang-btn">分享给好友去赚红包</a> <a href="<?=Yii::$app->params['baseurl.wechat']?>/view/pay/cash-account.html" class="tix">去提现</a> </div>
</div>
<div class="bot_box"><img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/bot_img.jpg"></div>
<div id="tab">
  <div class="ta_l"><span></span></div><div class="ta_r"><span></span></div>
  <ul class="tab_menu">
    <li class="selected">邀请记录</li>
    <li>活动规则</li>
  </ul>
  <div class="tab_box">
    <div>
      <h2>共计<?=$invited_all_people?>人，已获得<?=$invited_all_value?>元</h2>
      <?php if( $inviteds ){ ?>
        <ul>
            <?php foreach($inviteds as $invited){ ?>
                <li>
                    <span>
                        <?=isset($invited->created_time)?str_ireplace(' ','日 ',str_ireplace('-','月',substr($invited->created_time,5,11))):'未注册'?></li>
                    </span>
                    <?=isset($invited->invitee->username)?(substr($invited->invitee->username,0,3).'****'.substr($invited->invitee->username,-4)):'未注册'?></li>
            <?php } ?>
        </ul>
        <a href="<?=Yii::$app->params['baseurl.m']?>/red-packet/my-records">查看更多<br />
        <img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/more.png" width="29" height="21"></a> </div>
      <?php }else{ ?>
        <a href="<?=Yii::$app->params['baseurl.m']?>/red-packet?id=<?=$user_id?>" style="border:0px;">您还木有收入哦，快快行动吧！</a>
      <?php } ?>
    <div class="hide">
      <p>1、活动时间：即日起至2015年12月30日</p>
      <p>2、注册用户可得1元</p>
      <p>3、邀请好友注册可得2元</p>
      <p>4、满10元以即可微信提现！</p>
    </div>
  </div>
</div>
<!--=======隐藏的弹出层======-->
<div class="cd-popup" role="alert">
    <img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/fex.png" />
</div>

<script type="text/javascript" src="<?=Yii::$app->params['baseurl.static.m']?>/static/js/jquery.min.js"></script> 

<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  $.get("<?=Yii::$app->params['baseurl.m']?>/wechat/env", function(data) {
        wx.config({
            debug:false
            , appId: data.wx_config.appId
            , timestamp: data.wx_config.timestamp
            , nonceStr: data.wx_config.nonceStr
            , signature: data.wx_config.signature
            , jsApiList: [
                'checkJsApi',
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo',
                'getLocation',
                'openLocation',
                'hideMenuItems',
            ]
        });
    }, "json");
    wx.ready(function(){
        wx.hideMenuItems({
            menuList: [
                'menuItem:share:timeline',  
                "menuItem:share:qq",
                "menuItem:share:weiboApp",
                "menuItem:favorite",
                "menuItem:share:facebook",
                "menuItem:openWithSafari",
                "menuItem:openWithQQBrowser",
            ],
            fail: function (res) {
                //alert(JSON.stringify(res));
            }
        });

        wx.onMenuShareTimeline({
            title: '<?=isset($userinfo->resume->name)?$userinfo->resume->name:"我"?>分享的米多多现金红包，百万现金红包大派送！', // 分享标题
            link: "<?=Yii::$app->params['baseurl.m']?>/red-packet?id=<?=isset($userinfo->id)?$userinfo->id:2006?>", // 分享链接
            imgUrl: "<?=Yii::$app->params['baseurl.static.m']?>/static/img/hongbao.jpg", // 分享图标
            success: function () { 
                // 用户确认分享后执行的回调函数
            },
            cancel: function () { 
                // 用户取消分享后执行的回调函数
            }
        });

        wx.onMenuShareAppMessage({
            title: '<?=isset($userinfo->resume->name)?$userinfo->resume->name:"我"?>分享的米多多百万现金红包大派送，立即领取！', // 分享标题
            desc: '来领取现金红包，还可帮【<?=isset($userinfo->resume->name)?$userinfo->resume->name:"TA"?>】获得奖励哦！', // 分享描述
            link: "<?=Yii::$app->params['baseurl.m']?>/red-packet?id=<?=isset($userinfo->id)?$userinfo->id:2006?>", // 分享链接
            imgUrl: "<?=Yii::$app->params['baseurl.static.m']?>/static/img/hongbao.jpg", // 分享图标
            type: '', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () { 
                // 用户确认分享后执行的回调函数
            },
            cancel: function () { 
                // 用户取消分享后执行的回调函数
            }
        });
    });
</script>

<script type="text/javascript">
$(document).ready(function(){
	var $tab_li = $('#tab ul li');
	$tab_li.click(function(){
		$(this).addClass('selected').siblings().removeClass('selected');
		var index = $tab_li.index(this);
		$('div.tab_box > div').eq(index).show().siblings().hide();
	});	
});
</script>
<script src="<?=Yii::$app->params['baseurl.static.m']?>/static/js/red-packet.js"></script>
</body>
</html>
