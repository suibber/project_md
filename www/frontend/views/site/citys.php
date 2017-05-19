<?php
use common\Seo;
use common\Utils;

/* @var $this yii\web\View */
$this->title = '首页';
$this->nav_left_link = 'javascript:window.history.back()';
$this->nav_right_link = '/user';
$this->nav_right_title = '个人中心';
$this->nav_left_title = '';

/********* seo start ***********/
$seocity    = isset($city->short_name)?$city->short_name:'';
$block      = '';
$type       = '';
$clearance_type = '';
$conpany    = '';
$task_title = '';
$page_type  = 'index';

$seo_code   = Seo::makeSeoCode($seocity,$block,$type,$clearance_type,$conpany,$task_title,$page_type);
/********* seo end ***********/

$this->page_title = $seo_code['title'];
$this->page_keywords = $seo_code['keywords'];
$this->page_description = $seo_code['description'];

?>

<div class="nav_title"><a href="#">米多多</a> &gt; 城市选择</div>
<div class="city_on">
    <!--<div class="dq_city">进入北京站</div>-->
    <div class="sousuo">
        <input name="" class="text_in" id="search-city" type="text" placeholder="输入城市名称">
        <input name="" class="bnt_in" type="button" value="搜索">
        <div class="search_city" style="display:none;"></div>
    </div>
</div>
<div class="remen">
     <h2>热门城市</h2>
     <div class="rm_box">
        <?php foreach($citys as $city){ ?>
           <?php if($city->is_hot==1){ ?>
               <a href="http://<?=$city->seo_pinyin?>.<?=Yii::$app->params['baseurl']?>"><?=$city->short_name?></a>
           <?php } ?>
       <?php } ?>
     </div>
</div>
<div class="more_city">
     <h2>更多城市</h2>
     <div class="sou_tab"> 
        <?php foreach($pinyins as $pinyin){ ?>
           <a href="#pinyin_<?=$pinyin?>"><?=$pinyin?></a>
       <?php } ?>
     </div>
</div>
<div class="city_tabb">
    <?php foreach($pinyins as $pinyin){ ?>
        <dl id="pinyin_<?=$pinyin?>" class="pinyin">
            <dt class="city_title1"><?=$pinyin?></dt>
            <dd class="tag_list">
                <?php foreach($citys as $city){ ?>
                    <?php if( substr($city->seo_pinyin,0,1)==strtolower($pinyin) ){ ?>
                        <a href="http://<?=$city->seo_pinyin?>.<?=Yii::$app->params['baseurl']?>"><?=$city->short_name?></a>
                    <?php } ?>
                <?php } ?>
            </dd>
        <dl>
    <?php } ?>
</div>
<?php $this->beginBlock('js') ?>
<script>
    $(document).ready(function(){
        var citys_json = <?=$citys_json?>;
        $("#search-city").on('keyup',function(){
            var keyword = $(this).val();
            if(keyword.length > 0){
                var search_city = '';
                var p_limit = 4;
                var p_num   = 0;
                $.each(citys_json, function(i, v) {
                    if (v.name.search(keyword) > -1) {
                        search_city += '<a href="http://'+v.seo_pinyin+'.<?=Yii::$app->params['baseurl']?>">'+v.name+'</a>';
                        p_num ++;
                    }
                    if(p_num > p_limit){
                        return false;
                    }
                });
                //alert(search_city.length);
                if( search_city.length > 0 ){
                    $(".search_city").html(search_city);
                    $(".search_city").show();
                }else{
                    $(".search_city").html('');
                    $(".search_city").hide();
                }

            }
        });
    });
</script>
<?php $this->endBlock('js') ?>