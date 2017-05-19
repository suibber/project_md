<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;

use common\Utils;
use common\WeichatBase;
use common\models\District;
use common\models\ServiceType;
use m\assets\WechatAsset;

$this->title = '附近' . ($current_service_type?$current_service_type->name:'') . '兼职列表';

$districts = District::find()->where(['parent_id'=>$city->id])->all();
$service_types = ServiceType::find()->where(['status'=>0])->all();

$this->nav_left_link = 'javascript:window.history.back()';
$this->nav_right_link = '/';
$this->nav_right_title = '首页';
/* @var $this yii\web\View */

$this->wechat_apis = ['getLocation'];

?>

  <nav class="navbar-fixed-top top-nav" style="top: 50px;" role="navigation">
    <dl class="select">
        <dt style=" white-space: nowrap;">
            <?php if( Yii::$app->request->get('lat') ){ ?> 
                附近
            <?php }else{ ?>
                <?=$current_district->name?> 
            <?php } ?>
        
        <span class="caret"></span>
</dt><span class="inverted-triangle"></span>
        <dd> 
          <ul>
          <li><a href="/task/index?city=<?= $city->id ?>&service_type=<?= Yii::$app->request->get('service_type') ?>">全城</a></li>
          <li><a href="/task/nearest?lat=<?= Yii::$app->request->get('lat') ?>&lng=<?= Yii::$app->request->get('lng') ?>&service_type=<?= Yii::$app->request->get('service_type') ?>">附近</a></li>
<?php foreach($districts as $district) { ?>
    <li><a href="/task/index?city=<?= $city->id ?>&district=<?= $district->id ?>&service_type=<?= Yii::$app->request->get('service_type') ?>"><?=$district->name?></a></li>
<?php } ?>
          </ul>
        </dd>
     </dl>
    <dl class="select">
        <dt><?=$current_service_type?$current_service_type->name:'分类 '?><span class="caret"></span> </dt>
        <dd> 
          <ul>
    <li><a href="<?=Url::current(['service_type'=>''])?>">全部 </a></li>
<?php foreach($service_types as $st) { ?>
    <li><a href="<?=Url::current(['service_type'=>$st->id])?>"><?=$st->name?></a></li>
<?php } ?>
          </ul>
        </dd>
     </dl>
     <dl class="select">
        <dt>排序 <span class="caret"></span> </dt>
        <dd> 
          <ul>
            <li><a href="/task?service_type=<?= Yii::$app->request->get('service_type') ?>">综合排序</a></li>
            <li><a href="/task?sort=fromdate&service_type=<?= Yii::$app->request->get('service_type') ?>">按开工时间由近到远</a></li>
            
          </ul>
        </dd>
     </dl>
  </nav>
  <div style="height:50px;"></div>
  <div style="padding:10px 0 10px 15px;" id="street"></div>
<?=
  $this->render('@m/views/task/nearest-task-list.php', [
        'tasks' => $tasks,
        'pages' => $pages
    ]);
?>
  <!--===========以上是固定在顶部的==============--> 
<?php $this->beginBlock('js') ?>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?=Yii::$app->params['baidu.map.web_key']?>"></script>
<script type="text/javascript">
window.wx_ready = false;
function getLocation(callback) {
    if (window.wx_ready){
        getWxLocation(callback);
    } else {
        getH5Location(callback);
    }
}
<?php
if (Utils::isInWechat()){ ?>
    wx.ready(function(){
        window.wx_ready = true;
    });
<?php } ?>
function getWxLocation(callback) {
    wx.getLocation({
        type: 'wgs84',
        success: function (res) {
            var lat = res.latitude; // 纬度
            var lng = res.longitude; // 经度
            tranLocation({lat: lat, lng: lng}, function(loc){
                callback(loc);
            })
        },
        fail: function(){ getH5Location(callback);},
        cancel: function(){getH5Location(callback);}
    });
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
function setLocation(poi){
    setCookie('lat', poi.lat, 60 * 60);
    setCookie('lng', poi.lng, 60 * 60);
}
function setCookie(cname, cvalue, seconds) {
    var d = new Date();
    d.setTime(d.getTime() + (seconds*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
$(function(){
    $(".select").each(function(){
      var s=$(this);
      var z=parseInt(s.css("z-index"));
      var dt=$(this).children("dt");
      var dd=$(this).children("dd");
      var _show=function(){dd.slideDown(200);dt.addClass("cur");s.css("z-index",z+1);};   //展开效果
      var _hide=function(){dd.slideUp(200);dt.removeClass("cur");s.css("z-index",z);};    //关闭效果
      dt.on(GB.click_event, function(){dd.is(":hidden")?_show():_hide();});
      dd.find("a").click(function(){dt.html($(this).html());_hide();});     //选择效果（如需要传值，可自定义参数，在此处返回对应的“value”值 ）
      $("body").click(function(i){ !$(i.target).parents(".select").first().is(s) ? _hide():"";});
    });
});

// 坐标转地址
<?php if(Yii::$app->request->get('lat')){ ?>
    pointToStreet(<?= Yii::$app->request->get('lat') ?>,<?= Yii::$app->request->get('lng') ?>,1);
<?php } ?>
function pointToStreet(lng,lat,type){
	// 百度地图API功能
	var map = new BMap.Map("allmap");
    
	var point = new BMap.Point(lat,lng);
    
	//map.centerAndZoom(point,12);
    //alert(map);
	var geoc = new BMap.Geocoder();    
    geoc.getLocation(point, function(rs){
        var addComp = rs.addressComponents;
        if(type==1){
            document.getElementById('street').innerHTML = ''+ addComp.district + ", " + addComp.street + addComp.streetNumber+"附近 <a href='javascript:;' onclick='reLocation()'>[重新定位]</a>";
        }else{
            location.href='/task/nearest?lat='+lat+'&'+'lng='+lng;
        }
    });  
}

function reLocation(){
    document.getElementById('street').innerHTML = '正在重新定位...'
    getLocation(function(loc){
        pointToStreet(loc.lng,loc.lat,2);
    });
}

<?php if(Yii::$app->request->get('lat')==0){ ?>
    document.getElementById('street').innerHTML = '正在定位您的位置...'
    getLocation(function(loc){
        pointToStreet(loc.lng,loc.lat,2);
    });
<?php } ?>
</script>
<?php $this->endBlock('js') ?>


