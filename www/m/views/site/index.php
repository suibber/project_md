<?php
use common\Seo;
use common\Utils;
use yii\helpers\Url;
use common\models\District;
use common\models\ServiceType;

$districts = District::find()->where(['parent_id'=>$city->id])->all();
$service_types = ServiceType::find()->where(['status'=>0])->all();

/* @var $this yii\web\View */
$this->title = '首页';
$this->nav_left_link = '/change-city';
$this->nav_right_link = '/user';
$this->nav_right_title = '个人中心';
$this->nav_left_title = isset($city->name)?$city->name.' &#9660;':'';

/********* seo start ***********/
$seocity    = isset($city->name)?$city->name:'';
$block      = '';
$type       = '';
$clearance_type = '';
$conpany    = '';
$task_title = '';
$page_type  = 'city';

$seo_code   = Seo::makeSeoCode($seocity,$block,$type,$clearance_type,$conpany,$task_title,$page_type);
/********* seo end ***********/

$this->page_title = $seo_code['title'];
$this->page_keywords = $seo_code['keywords'];
$this->page_description = $seo_code['description'];

?>
<div class="midd_xz">
    <span class="gble">×</span>
    <a href="<?=Yii::$app->params["downloadApp.android"]?>"><img src="<?=Yii::$app->params["baseurl.static.m"]?>/static/img/midd_xz.jpg"></a>
</div>


<?php $this->beginBlock('css') ?>
<style>
  /*================首页图片滚动===============*/
.bxslider{width:100%;}
.bxslider img{width:100%;}
.bx-wrapper .bx-pager {text-align: center;font-size: .85em;font-family: Arial;font-weight: bold;color: #666;}
.bx-wrapper .bx-pager .bx-pager-item,.bx-wrapper .bx-controls-auto .bx-controls-auto-item {display: inline-block;*zoom: 1;*display: inline;}
.bx-wrapper .bx-pager.bx-default-pager a {background: #ff694e;text-indent: -9999px;display: block;width: 10px;height: 10px;margin: 0 5px;outline: 0;-moz-border-radius: 5px;-webkit-border-radius: 5px;border-radius: 5px;}
.bx-wrapper .bx-pager.bx-default-pager a:hover,.bx-wrapper .bx-pager.bx-default-pager a.active {background: #fff;}
</style>
<?php $this->endBlock('css') ?>



<ul class="bxslider">
    <?php foreach($banners_city as $banner){ ?>
      <li><a href="<?=isset($banner->task->gid)?Yii::$app->params['baseurl.m'].'/task/view?gid='.$banner->task->gid:$banner->url?>"><img src="<?=$banner->pic_url?>" ></a></li>
    <?php } ?>
</ul>

<nav class="navbar-fixed-top top-nav" style="float: left; position: relative;width:100%;" role="navigation">
    <dl class="select">
        <dt style=" white-space: nowrap;">
            <?=$current_district->name?> <span class="caret"></span>
        </dt>
        <span class="inverted-triangle"></span>
        <dd> 
            <ul>
                <li>
                    <a href="<?=Url::current(['district_pinyin'=>''])?>">全城</a>
                </li>
                <?php foreach($districts as $district) { ?>
                    <li>
                        <a href="<?=Url::current()?><?=$district->seo_pinyin?>/"><?=$district->name?></a>
                    </li>
                <?php } ?>
            </ul>
        </dd>
    </dl>
    <dl class="select">
        <dt>
            <?=$current_service_type?$current_service_type->name:'分类 '?><span class="caret"></span> 
        </dt>
        <dd> 
            <ul>
                <li><a href="<?=Url::current(['type_pinyin'=>''])?>">全部</a></li>
                <?php foreach($service_types as $st) { ?>
                <li><a href="<?=Url::current()?><?=$st['pinyin']?>/"><?=$st->name?></a></li>
                <?php } ?>
            </ul>
        </dd>
    </dl>
    <dl class="select">
        <dt>
            <?php if( Yii::$app->request->get('sort')=='fromdate' ){ ?>
                按开工
            <?php }elseif( Yii::$app->request->get('sort')=='default' ){ ?>
                排序
            <?php }else{ ?>
                排序
            <?php } ?>
            <span class="caret"></span> 
        </dt>
        <dd> 
          <ul>
            
            <li><a href="<?=Url::current()?>p1/?sort=default">综合排序</a></li>
            <li><a href="<?=Url::current()?>p1/?sort=fromdate">按开工时间由近到远</a></li>
          </ul>
        </dd>
     </dl>
</nav>

<div id="content"> 
  <div class="recommend"><caption>热门推荐</caption></div>

<?php foreach ($tasks as $task){ ?>
<a href="/<?=$city_pinyin?>/<?=$task->service_type->pinyin?>/<?=$task->gid?>" class="list-group-item">
  <div class="panel panel-default zhiwei-list"> 
    <div class="border-bt">
        <div class="panel-heading">
            <h3 class="panel-title"><?=$task->title ?></h3>
        </div>
      <div class="panel-body list-bt">
        <p> <span class="label label-default">
            ￥<?= floor($task->salary) ?>/<?= $task::$SALARY_UNITS[$task->salary_unit] ?>
           </span> </p>
      </div>
    </div>
    <div class="border-bt">
      <div class="panel-body lnk">
        <p><span class="glyphicon glyphicon-time" aria-hidden="true"></span>
            <?=substr($task->from_date, 5) ?>至<?= substr($task->to_date, 5) ?>
        </p>
        <div class="te-x">
          <p><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
            <?php
            if ($task->city) {
                echo $task->city->name . '-';
            }
            if ($task->district) {
                echo $task->district->name . '-';
            } ?>
            <?=$task->address?>
          </p>
          <span class="label label-default train hidden">距我5km</span></div>
      </div>
    </div>
  </div>
</a>
<?php } ?>
<a href="/<?=$city_pinyin?>/p1/" style="color:#ffa005; display:block; padding:10px 0 15px; text-align:center; margin:0 auto;font-size:1.3em;">更多职位&nbsp;>></a>

  </div>
</div>

<?php $this->beginBlock('js') ?>
<script src="<?=Yii::$app->params["baseurl.static.m"]?>/static/js/bxslider.js"></script>
<script>
  $(document).ready(function(){
    $('.bxslider').bxSlider({
    captions: true,//自动控制
          auto: true,
          // speed: 5000,
          pause: 2000,
          infiniteLoop: true,
          controls: false,
          autoHover: false,
  });

    $('.bx-controls').css('position', 'relative');
    $('.bx-default-pager').css('position', 'absolute');
    $('.bx-default-pager').css('top', '-30px');
    $('.bx-default-pager').css('width', '100%');
    //$('.bx-default-pager').css('padding-left', '68%');
});
</script>
<script type="text/javascript">
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
    $('.gble').on('click', function(){
        $('.midd_xz').slideUp('400');
    });
});
</script>
<?php $this->endBlock('js') ?>
