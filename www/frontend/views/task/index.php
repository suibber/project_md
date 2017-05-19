<?php

use yii\helpers\Url;
use common\Utils;
use common\models\District;
use common\models\ServiceType;
use common\Seo;
use yii\widgets\LinkPager;
use common\BaseController;

$districts = District::find()->where(['parent_id'=>$city->id])->all();
$service_types = ServiceType::find()->where(['status'=>0])->all();

/********* seo start ***********/
$seocity    = isset($city->short_name)?$city->short_name:'';
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

$this->title = ($current_service_type?$current_service_type->name:'') . '兼职列表';
$this->page_title = $seo_code['title'];
$this->page_keywords = $seo_code['keywords'];
$this->page_description = $seo_code['description'];
/********* seo end ***********/
?>
<div class="nav_title">
    <a href="<?=Yii::$app->params['baseurl.frontend']?>">米多多</a> &gt; 
    <a href="http://<?=$_SERVER['HTTP_HOST']?>"><?=$city->short_name?>兼职</a>
    <?php if( isset($current_district->seo_pinyin) && ($current_district->id != $city->id ) ){ ?>
         &gt; <a href="http://<?=$_SERVER['HTTP_HOST']?>/<?=$current_district->seo_pinyin?>/"><?=$current_district->short_name?>兼职</a>
    <?php } ?>
    <?php if(isset($current_service_type->pinyin)){ ?>
        &gt; <a href="http://<?=$_SERVER['HTTP_HOST']?>/<?=$current_service_type->pinyin?>/"><?=$current_service_type->name?></a>
    <?php } ?>
</div>
<ul class="nav_sx">
   <li>
   		<div class="nav_sx_left">区域：</div>
        <div class="nav_sx_right">
            <a href="<?=Seo::formatFrontendUrl(Url::current(['district_pinyin'=>'']))?>" 
                <?php if($current_district->id == $city->id){ ?>
                    class="current"
                <?php } ?>
            >
                全城
            </a>
            <?php foreach($districts as $district) { ?>
                <a href="<?=Seo::formatFrontendUrl(Url::current(['district_pinyin'=>$district->seo_pinyin]))?>"
                    <?php if($district->seo_pinyin == $current_district->seo_pinyin){ ?>
                        class="current"
                    <?php } ?>
                >
                    <?=$district->short_name?>
                </a>
            <?php } ?>
        </div>
   </li>
   <li>
   		<div class="nav_sx_left">分类：</div>
        <div class="nav_sx_right">
            <a href="<?=Seo::formatFrontendUrl(Url::current(['type_pinyin'=>'']))?>" 
                <?php if(!isset($current_service_type->pinyin)){ ?>
                    class="current"
                <?php } ?>
            >
                全部
            </a>
            <?php foreach($service_types as $st) { ?>
                <a href="<?=Seo::formatFrontendUrl(Url::current(['type_pinyin'=>$st['pinyin']]))?>"
                    <?php if(isset($current_service_type->pinyin) && $st->pinyin == $current_service_type->pinyin){ ?>
                        class="current"
                    <?php } ?>
                >
                    <?=$st->name?>
                </a>
            <?php } ?>
        </div>
   </li>
</ul>
<div class="center_c">
<div class="cnter_left">
    <ul class="lis">
        <?php foreach ($tasks as $task){ if(isset($task->id)){ ?>
            <li>
            <a href="/<?=$task->service_type->pinyin?>/<?=$task->gid?>" target="_blank">
               <div class="lis_left_1">
                  <h2><?=$task->title ?></h2>
                  <span><?=$task->service_type->name?></span>
                  <span>
                    <?php
                    if ($task->city) {
                        echo $task->city->name;
                    }
                    if ($task->district) {
                        echo ' - '.$task->district->name;
                    } ?>
                    <?=$task->address?>
                  </span>
               </div>
               <div class="lis_left_2"><span class="red_r"><?=str_ireplace('.00','',$task->salary)?>元/<?=$task::$SALARY_UNITS[$task->salary_unit]?></span><span><?=$task::$CLEARANCE_PERIODS[$task->clearance_period]?></span></div>
               <div class="lis_left_3"><?=isset($task->updated_time)?BaseController::timePast($task->updated_time):BaseController::timePast($task->created_time)?></div>
             </a>
            </li>
        <?php }} ?>
        <div class="page">
        <?php
            //var_dump($pages);exit;
        ?>
            <?=Seo::formatFrontendUrl(LinkPager::widget([
                'pagination' => $pages,
                'maxButtonCount'=>8,
                'lastPageLabel'=>'末页', 'nextPageLabel'=>'下一页',
                'prevPageLabel'=>'上一页', 'firstPageLabel'=>'首页'
            ]), 'pager')?>
        </div>
    </ul>
</div>
<div class="cnter_right">
    <?php if($recommend_task_list){ ?>
        <div class="right_title">推荐岗位</div>
        <ul class="jipin_list">
            <?php foreach($recommend_task_list as $task){ ?>
                <li><a href="/<?=$task->service_type->pinyin?>/<?=$task->gid?>" target="_blank"><span><?=str_ireplace('.00','',$task->salary)?>元/<?=$task::$SALARY_UNITS[$task->salary_unit]?></span><?=$task->title?></a></li>
            <?php } ?>
        </ul>
    <?php } ?>
    <div class="right_title">微信扫一扫，快速找兼职</div>
    <div class="erwei_img"><img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/erwei.jpg" width="287" height="287"></div>
    <!--div class="right_title">热门兼职</div>
    <div class="remen_jz">
        <a href="#">长期客服</a>
    </div-->
  </div>
</div>
<!--div class="zhiwei_tj">
    <a href="#">长期客服长期客服</a>
</div-->
<div class="img_pc">
    <img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/xinyu.jpg">
</div>