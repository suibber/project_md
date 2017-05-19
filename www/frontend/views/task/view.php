<?php

use yii\helpers\Url;

use common\models\District;
use common\models\ServiceType;
use common\Seo;
use yii\widgets\LinkPager;
use common\BaseController;

/********* seo start ***********/
$city       = isset($task->city->name)?$task->city->name:'';
$block      = '';
$type       = '';
$clearance_type = '';
$conpany    = $task->company_name;
$task_title = $task->title;
$page_type  = 'detail';

$need_quantity  = $task->need_quantity;
$address        = '';
if(isset($task->addresses)){
    foreach($task->addresses as $k => $v){ 
        $address    .= $v->title.','.$v->address.';';
    }
}
$salary         = floor($task->salary);
$detail         = $task->detail;

$seo_code   = Seo::makeSeoCode($city,$block,$type,$clearance_type,$conpany,$task_title,$page_type,$need_quantity,$address,$salary,$detail);

$this->title = '兼职详情';
$this->page_title = $seo_code['title'];
$this->page_keywords = $seo_code['keywords'];
$this->page_description = strip_tags($seo_code['description']);
/********* seo end ***********/
?>
<div class="nav_title">
    <a href="<?=Yii::$app->params['baseurl.frontend']?>">米多多</a> &gt; 
    <a href="http://<?=$_SERVER['HTTP_HOST']?>"><?=$city?>兼职</a> &gt; 
    <a href="http://<?=$_SERVER['HTTP_HOST']?>/<?=$task->service_type->pinyin?>/"><?=$city?><?=$task->service_type->name?></a>
</div>
<div class="center_c">
  <div class="cnter_left">
    <div class="midd_title">
      <div class="lis_left_11">
        <h2><?= $task->title ?></h2>
        <span class="red_r"><?= floor($task->salary); ?>/<?= $task::$SALARY_UNITS[$task->salary_unit] ?></span><span>|</span><span><?=$task::$CLEARANCE_PERIODS[$task->clearance_period]?></span><span>|</span>
        <span>
            <a href="http://<?=$_SERVER['HTTP_HOST']?>/<?=$task->service_type->pinyin?>/"><?=$task->service_type->name?></a>    
        </span>
        <span>
            <a href="http://<?=$_SERVER['HTTP_HOST']?>/<?php
                if( $task->district ){
                    echo $task->district->seo_pinyin;
                }else{
                    echo '';
                }
            ?>">
            <?php
            if ($task->city) {
                echo $task->city->name;
            }
            if ($task->district) {
                echo ' - '.$task->district->name;
            } ?>
            <?=$task->address?>
            </a>
        </span> </div>
      <div class="lis_left_22"><?=isset($task->updated_time)?BaseController::timePast($task->updated_time):BaseController::timePast($task->created_time)?></div>
    </div>
    <div class="midd_yq">
      <div><span>要求：</span>
            <?=$task->gender_requirement ? $task::$GENDER_REQUIREMENT[$task->gender_requirement].' ' : ''?>
            <?=$task->degree_requirement ? $task::$DEGREE_REQUIREMENT[$task->degree_requirement].' ' : ''?>
            <?=$task->height_requirement ? $task::$HEIGHT_REQUIREMENT[$task->height_requirement].' ' : ''?>
            <?=$task->health_certificated ? $task::$HEALTH_CERTIFICATED[$task->health_certificated].' ' : ''?>
            <?php
                if( !$task->gender_requirement && !$task->degree_requirement
                && !$task->height_requirement && !$task->health_certificated){
                    echo '无特殊要求';
                }
            ?>
      </div>
      <div><span>日期：</span>
            <?php if($task->is_longterm){ ?>
            长期兼职
            <?php }else{ ?>
            <?=substr($task->from_date, 5);?>
            至
            <?=substr($task->to_date, 5)?>
            <?php } ?>
      </div>
      <div><span>时间：</span>
            <?php if($task->is_allday){ ?>
             不限工作时间
            <?php }else{ ?>
             <?=substr($task->from_time, 0,5);?>
                至
             <?=substr($task->to_time, 0,5)?>
            <?php } ?>
      </div>
      <?php if($task->tasktime){ ?>
      <div><span>兼职时间：</span>
            <table class="tasktime" cellSpacing=0 cellPadding=0>
                <tr>
                    <td></td>
                    <td>星期一</td>
                    <td>星期二</td>
                    <td>星期三</td>
                    <td>星期四</td>
                    <td>星期五</td>
                    <td>星期六</td>
                    <td>星期日</td>
                </tr>
                <?php 
                    $time_maps = ['morning'=>'上午',
                        'afternoon'=>'下午',
                        'evening'=>'晚上'
                    ];
                    foreach ($time_maps as $when=>$title){
                ?>
                    <tr>
                        <td><em><?=$title?></em></td>
                      <?php for($i=0;$i<=6;$i++) {
                        $checked = '';
                        if (isset($task->tasktime[$i])){
                            $ft = $task->tasktime[$i];
                            $checked = $ft->$when?'checked=checked':'';
                        }
                        ?>
                        <td>
                            <input class='tasktime' type='checkbox' disabled="disabled" name='tasktime[]' value="<?=$i?>_<?=$when?>" <?=$checked?>>
                        </td>
                      <?php }?>
                    </tr>
                <?php } ?>
            </table>
      </div>
      <?php } ?>
      <div><span>地址：</span><?php if(isset($task->addresses)){foreach($task->addresses as $k => $v){ ?><?=$v->title?><?=$v->address?'，':''?><?=$v->address?>；<?php }} ?></div>
    </div>
    <div class="midd_xq_title">职位描述</div>
    <div class="midd_xq_text">
        <?=$task->detail?>
    </div>
    <div class="midd_xq_title">公司信息</div>
    <div class="midd_xq_text">
      <P><?=$task->company_name?></P>
    </div>
    <div class="midd_xq_title">求职说明</div>
    <div class="midd_xq_text">
      <P>如果您在求职中，遇到企业无理要求支付押金，或者工作内容与实际发布内容不符，请与我们及时联系。扫描下方二维码，关注米多多后，点击信息，举报该职位即可。米多多会及时处理。</P>
      <p>如果您遇到欺诈，米多多提供兼职呢欺诈赔付，<a href="<?=Yii::$app->params['baseurl.frontend']?>/site/assurance" target="_blank">赔付方案</a></p>
    </div>
    <div class="midd_xq_title">报名方式</div>
    <div class="midd_xq_text">
      <div class="tex">微信扫码关注米多多，点击链接即可报名！</div>
      <img src="<?=$task_erweima?>" width="287" height="287"> </div>
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
    <div class="right_title">扫码快速找兼职</div>
    <div class="erwei_img"><img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/erwei.jpg" width="287" height="287"></div>
    <!--div class="right_title">热门兼职</div>
    <div class="remen_jz">
        <a href="#">长期客服</a>
    </div-->
  </div>
</div>
<!--div class="zhiwei_tj">
    <a href="#">长期客服</a>
</div-->
<div class="img_pc">
    <img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/xinyu.jpg">
</div>
