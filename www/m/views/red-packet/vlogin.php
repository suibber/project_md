<?php
use yii\helpers\Html;
use common\Utils;
use common\WeichatBase;
use m\assets\BootstrapAsset;
use m\assets\WechatAsset;
use yii\bootstrap\ButtonGroup;
use yii\bootstrap\ActiveForm;

/* @var $this \yii\web\View */
/* @var $content string */

BootstrapAsset::register($this);

if (Utils::isInWechat()){
    WechatAsset::register($this);
}

$this->title = '米多多百万现金红包大派送！';

?>
<link href="<?=Yii::$app->params['baseurl.static.m']?>/static/css/red-packet.css" type="text/css" rel="stylesheet">

<body>
<div class="midd_top"><img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/midd_top.jpg"></div>
<div class="midd_main"> <img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/hongbao.png" >
  <div class="title_hb"><img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/xianjian.png" ></div>
  <div class="title_qb"><img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/qianb.png" ></div>
  <div class="input_k">
  <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
     <?= $form->field($model, 'phonenum')->label(false)
              ->input('tel', $options = ['data-id'=>'phonenum' ,'class'=>"input_z", 'placeholder'=>"请输入您的手机号领红包"] ) ?>
     <div class="yz">
        <input type="text" id="<?= Html::getInputId($model, 'code') ?>"
            class="input_z" name="<?= Html::getInputName($model, 'code')?>">
        <button class="bott" id="svcode">获取验证码</button>
        <input type="hidden" id="red_packet_city"
            class="input_z" name="red_packet_city">
     </div>
     <?= Html::submitButton('立即领取', ['class' => 'botton_l', 'name' => 'login-button']) ?>
   <?php ActiveForm::end(); ?>
     <div class="ts">分享好友，每注册成功一个，则返现<b><?=$inviter_value?></b>元，多邀多送！</div>
  </div>
</div>
<div class="bot_box"><img src="<?=Yii::$app->params['baseurl.static.m']?>/static/img/red-packet/bot_img.jpg"></div>
<div id="tab">
  <div class="ta_l"><span></span></div><div class="ta_r"><span></span></div>
  <ul class="tab_menu">
    <li  style="text-align:center; width:100%">活动规则</li>
  </ul>
  <div class="tab_box">
    <div>
      <p>1、活动时间：即日起至2015年12月30日</p>
      <p>2、注册用户可得1元</p>
      <p>3、邀请好友注册，邀请人可得2元</p>
      <p>4、满10元以上即可微信提现！</p>
    </div>
   </div>
</div>
<div id="tab">
  <div class="ta_l"><span></span></div><div class="ta_r"><span></span></div>
  <ul class="tab_menu">
    <li style="text-align:center; width:100%">红包榜</li>
  </ul>
  <div class="tab_box">
    <div>
      <dl>
        <dd>第一名</dd>
        <dd>**明</dd>
        <dd>156元</dd>
      </dl>
      <dl>
        <dd>第二名</dd>
        <dd>**诺</dd>
        <dd>127元</dd>
      </dl>
      <dl>
        <dd>第三名</dd>
        <dd>**舵</dd>
        <dd>79元</dd>
      </dl>
      <dl>
        <dd>第四名</dd>
        <dd>**川</dd>
        <dd>55元</dd>
      </dl>
      <dl>
        <dd>第五名</dd>
        <dd>**亮</dd>
        <dd>43元</dd>
      </dl>
    </div>
   </div>
</div>

<?php $this->beginBlock('js') ?>
<script>
    $(function(){
        var flag=false;
        var vbtn = $("#svcode");
        var pipt = $('input[data-id="phonenum"]');
        var fp = pipt.closest('.form-group');
        var help=fp.find('.help-block');
        var wait=60;
        $(vbtn).on('click',function(){
            return false;
        });
        function time(o) {
            help.html('请您留意短信或来电');
            if (wait == 0) { 
                o.removeClass('form-yzm-c').removeAttr("disabled");
                o.html("获取验证码");
                wait = 60;
            } else {
                o.html(wait + "秒后重试");
                wait--;
                setTimeout(function() { time(o); }, 1000);
            }
        }

        vbtn.bind(GB.click_event, function(){
            if (flag) {
                return false;
            }
            flag = true;
            setTimeout(function(){ flag = false; }, 100);
            $.ajax({url: "/user/vcode",
                'method': 'POST',
                'data': {'phonenum': pipt.val(), 't': $.now()}})
            .done(function(text){
                data =$.parseJSON(text);
                if (data['result']){
                    vbtn.addClass('form-yzm-c').attr("disabled","disabled");
                    time(vbtn);
                } else {
                    fp.addClass('has-error');
                    help.html(data['msg']);
                }
            }).fail(function(){
                fp.addClass('has-error');
                help.html("网络出现问题，请重试.");
            });
        });
    });
</script>

<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?=Yii::$app->params['baidu.map.web_key']?>"></script>
<script type="text/javascript">

function setCookie(cname, cvalue, seconds) {
    var d = new Date();
    d.setTime(d.getTime() + (seconds*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(c_name){
    if (document.cookie.length>0)
      {
      c_start=document.cookie.indexOf(c_name + "=")
      if (c_start!=-1)
        { 
        c_start=c_start + c_name.length+1 
        c_end=document.cookie.indexOf(";",c_start)
        if (c_end==-1) c_end=document.cookie.length
        return unescape(document.cookie.substring(c_start,c_end))
        } 
      }
    return ""
}

function getLocation(callback) {
    var current_city_pinyin = getCookie('current_city_pinyin');
    var current_city_name = getCookie('current_city_name');
    if( current_city_pinyin ){
        document.getElementById('current_city').innerHTML = "<a href='/"+current_city_pinyin+"/'>"+unescape(current_city_name)+"</a>";
    }else{
        getH5Location(callback);
    }
}

function getH5Location(callback) {
  if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position){
        var c= position.coords;
        tranLocation({lat: c.latitude, lng: c.longitude}, function(loc){
            callback(loc);
        });
      });
  } else {
      callback();
  }
}

function tranLocation(poi, callback) {
  var url = 'http://api.map.baidu.com/geoconv/v1/?coords='
      + poi.lng + ',' + poi.lat + '&from=1&to=5&ak='
      + "<?=Yii::$app->params['baidu.map.web_key']?>";
  $.ajax({
    'dataType': 'jsonp',
    'url': url,
    success: function(json){
        console.log(json);
        if(json['status']==0){
            callback({lng: json.result[0].x, lat: json.result[0].y})
        }
    },
    error: function(e){
        console.log(e);
    }
  });
}

function pointToStreet(lng,lat,type){
    // 百度地图API功能
	var map = new BMap.Map("allmap");
    
	var point = new BMap.Point(lng,lat);
       
	var geoc = new BMap.Geocoder();   
    geoc.getLocation(point, function(rs){
        var addComp = rs.addressComponents;

        var citys_json = <?=$citys_json?>;
        var keyword = addComp.city;
        if(keyword.length > 0){
            $.each(citys_json, function(i, v) {
                if (v.name.search(keyword) > -1) {
                    var city_id = v.id;
                    $('#red_packet_city').val(city_id);
                    return false;
                }
            });
        }
    });  
}

getLocation(function(loc){
    pointToStreet(loc.lng,loc.lat,1);
});
</script>

<?php $this->endBlock('js') ?>

</body>
</html>

