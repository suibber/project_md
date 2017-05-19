<?php

use yii\helpers\Url;

use common\models\District;
use common\models\ServiceType;
use common\Seo;

$districts = District::find()->where(['parent_id'=>$city->id])->all();
$service_types = ServiceType::find()->where(['status'=>0])->all();


/********* seo start ***********/
$seocity    = isset($city->name)?$city->name:'';
if( $current_district->id != $city->id ){
    $block      = $current_district->name;
    $page_type  = 'block';
}else{
    $block      = '';
    $page_type  = 'city';
}
$type       = $current_service_type?$current_service_type->name:'';
if( $type ){
    $seocity    = $current_district->name;
    $page_type  = 'type';
}
$clearance_type = '';
$conpany    = '';
$task_title = '';

$seo_code   = Seo::makeSeoCode($seocity,$block,$type,$clearance_type,$conpany,$task_title,$page_type);
/********* seo end ***********/

$this->title = ($current_service_type?$current_service_type->name:'') . '兼职列表';
$this->page_title = $seo_code['title'];
$this->page_keywords = $seo_code['keywords'];
$this->page_description = $seo_code['description'];

$this->nav_left_link = 'javascript:window.history.back()';
$this->nav_right_link = $seo_params['city_pinyin'] ? '/'.$seo_params['city_pinyin'].'/' : '/';
$this->nav_right_title = '首页';
/* @var $this yii\web\View */

$this->wechat_apis = ['getLocation'];

?>
<div class="midd_xz">
    <span class="gble">×</span>
    <a href="<?=Yii::$app->params["downloadApp.android"]?>"><img src="<?=Yii::$app->params["baseurl.static.m"]?>/static/img/midd_xz.jpg"></a>
</div>
  <nav class="navbar-fixed-top top-nav" style="float: left; position: relative;width:100%;" role="navigation">
    <dl class="select">
        <dt style=" white-space: nowrap;">
            <?=$current_district->name?> <span class="caret"></span>
        </dt>
        <span class="inverted-triangle"></span>
        <dd> 
          <ul>
            <li><a href="<?=Url::current(['district_pinyin'=>''])?>">全城</a></li>
            <li style="display: none;">
                <?php if($location['id']){ ?>
                    <a href="/task/nearest?lat=<?= $location['latitude'] ?>&lng=<?= $location['longitude'] ?>&service_type=<?= Yii::$app->request->get('service_type') ?>">附近</a>
                <?php }else{ ?>
                    <a href="/task/nearest?service_type=<?= Yii::$app->request->get('service_type') ?>">附近</a>
                <?php } ?>
            </li>
            <?php foreach($districts as $district) { ?>
                <li><a href="<?=Url::current(['district_pinyin'=>$district->seo_pinyin])?>"><?=$district->name?></a></li>
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
                <li><a href="<?=Url::current(['type_pinyin'=>$st['pinyin']])?>"><?=$st->name?></a></li>
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
            
            <li><a href="?sort=default">综合排序</a></li>
            <li><a href="?sort=fromdate">按开工时间由近到远</a></li>
          </ul>
        </dd>
     </dl>
  </nav>
  <div style="height:50px;"></div>
<?=
  $this->render('@m/views/task/task-list.php', [
        'tasks' => $tasks,
        'pages' => $pages,
        'seo_params' => $seo_params,
    ]);
?>
  <!--===========以上是固定在顶部的==============--> 
<?php $this->beginBlock('js') ?>
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


