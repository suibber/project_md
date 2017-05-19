<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Task;
use common\models\District;

$city_id = isset($task->city_id) ? $task->city_id : 3;
if( $city_id ){
    $city = District::findOne(['id'=>$city_id]);
    $province_id = $city['parent_id'];
}else{
    $province_id = 2;
}

$sheng  = District::find()
    ->where(['level'=>'province','is_alive'=>1])->addOrderBy(['id'=>SORT_ASC])->all();
$shi    = District::find()
    ->where(['parent_id'=>$province_id])->addOrderBy(['id'=>SORT_ASC])->all();
$qu     = District::find()
    ->where(['parent_id'=>$city_id])->addOrderBy(['id'=>SORT_ASC])->all();

$api_url= Yii::$app->params['baseurl.api'];

/* @var $this yii\web\View */
$this->title = '米多多兼职平台';
?>
<!-- InstanceBeginEditable name="EditRegion3" -->
<div class="body-box" style="min-width: 1100px;">
                <div class="col-sm-10 padding-0 ">
                    <div class="right-center">
                        <div class="conter-title">发布兼职职位</div>
                        
                        <?php $form = ActiveForm::begin();?>
                        <ul class="tianxie-box">
                            <li>
                                <div class="pull-left title-left text-center"><em>*</em>兼职标题</div>
                                <div class="pull-left right-box">
                                    <input name="title" type="text" placeholder="请简述职位标题，字数控制在20字内" value="<?=$task->title?>">
                                    <p class="cuowu title-error">内容不能为空!</p>
                                </div>
                            </li>
                          <li>
                                <div class="pull-left title-left text-center"><em>*</em>兼职类别</div>
                                <div class="pull-left right-box zhiweileibie">
                                    <div class="nice-select tl" name="nice-select">
                                        <input type="text" readonly placeholder=" ===选择职位类别===" value="<?=$task->service_type_id?$task->getService_type()->one()->name:''?>">
                                        <ul>
                                        	<?php foreach($services as $service) {?>
                        					<li><?=$service->name?></li>
                        					<?php }?>
                                        </ul>
                                        <input type="hidden" name="service_type_id" value="<?=$task->service_type_id?$task->getService_type()->one()->name:''?>"/>
                                        <p class="cuowu service_type_id-error">内容不能为空!</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                              <div class="pull-left title-left text-center"><em>*</em>工作时间</div>
                              <div class="pull-left right-box div">
                                <div class="riqi">
                                  <input type="text" style="width: 330px" class="reservation" value="<?=$task->from_date&&$task->to_date?$task->from_date.' - '.$task->to_date:date('Y-m-d').' - '.date('Y-m-d')?>" placeholder="选择您的工作起始日期"/>
                                  <label><input name="is_longterm" type="checkbox" class="changqi" <?=$task&&$task->is_longterm?'checked':''?>>长期招聘</label>
                                  <input name="from_date" type="hidden" value="<?=$task->from_date?$task->from_date:date('Y-m-d')?>"/>
                                  <input name="to_date" type="hidden" value="<?=$task->to_date?$task->to_date:date('Y-m-d')?>"/>
                              </div>
                              <p class="cuowu from_time-error">内容不能为空!</p>
                              <div class="time-xz">
                                  <div class="nice-select times" name="nice-select">
                                    <input name="from_time" type="text" placeholder="上班时间" readonly value="<?=$task->from_time?$task->from_time:''?>" >
                                    <ul>
                                        <li>06:00</li>
                                        <li>07:00</li>
                                        <li>08:00</li>
                                        <li>09:00</li>
                                        <li>10:00</li>
                                        <li>11:00</li>
                                        <li>12:00</li>
                                        <li>13:00</li>
                                        <li>14:00</li>
                                        <li>15:00</li>
                                        <li>16:00</li>
                                        <li>17:00</li>
                                        <li>18:00</li>
                                        <li>19:00</li>
                                        <li>20:00</li>
                                        <li>21:00</li>
                                        <li>22:00</li>
                                        <li>23:00</li>
                                    </ul>
                                  </div>
                                  <span class="pull-left">至</span>
                                  <div class="nice-select times" name="nice-select">
                                    <input name="to_time" type="text" placeholder="下班时间" readonly value="<?=$task->to_time?$task->to_time:''?>" >
                                    <ul>
                                        <li>06:00</li>
                                        <li>07:00</li>
                                        <li>08:00</li>
                                        <li>09:00</li>
                                        <li>10:00</li>
                                        <li>11:00</li>
                                        <li>12:00</li>
                                        <li>13:00</li>
                                        <li>14:00</li>
                                        <li>15:00</li>
                                        <li>16:00</li>
                                        <li>17:00</li>
                                        <li>18:00</li>
                                        <li>19:00</li>
                                        <li>20:00</li>
                                        <li>21:00</li>
                                        <li>22:00</li>
                                        <li>23:00</li>
                                    </ul>
                                  </div>
                                  <label><input name="is_allday" type="checkbox" class="changqi" <?=$task&&$task->is_allday?'checked':''?>>不限工作时间</label>
                              </div>
                              <p class="cuowu to_time-error">内容不能为空!</p>
                            </li>
                            <!--
                            <li>
                                <div class="pull-left title-left text-center"><em>*</em>报名截止日期</div>
                                <div class="pull-left right-box">
                                    <div class="riqi">
                                        <input name="end_date" type="text" readonly style="width: 330px" name="birthday" id="birthday" value="<?=$task->to_date?$task->to_date:date('Y-m-d')?>" /></div>
                                        <p class="cuowu">内容不能为空!</p>
                                    </div>
                                </li>
                                -->
                                <li>
                                    <div class="pull-left title-left text-center"><em>*</em>工作地址</div>
                                    <div class="pull-left right-box address">
<!--
                                    <div class="nice-select quyu" name="nice-select">
                                        <input id="address_count" type="text" placeholder="地址" value="一个">
                                        
                                        <ul>
                                            <li>不限</li>
                                            <li>一个</li>
                                            <li>多个</li>
                                        </ul>
                                    </div> 
                                        <div class="nice-select quyu" name="nice-select">
                                            <input type="text" readonly value="北京" >
                                        </div> -->
                                        <span id="api_url" style="display:none;"><?=$api_url?></span>
                                        <select id="address_sheng">
                                            <option value="0">
                                                省份/直辖市
                                            </option>
                                            <?php foreach($sheng as $k=>$v){ ?>
                                                <option value="<?=$v->id;?>"
                                                <?=($v->id==$province_id)?'selected=selected':''?>
                                                >
                                                    <?=$v->short_name;?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <select id="address_shi" name="city_id">
                                            <?php foreach($shi as $k=>$v){ ?>
                                                <option value="<?=$v->id;?>"
                                                <?=($v->id==$city_id)?'selected=selected':''?>
                                                >
                                                    <?=$v->short_name;?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <select id="address_qu" name="district_id">
                                            <option value="0">区/县</option>
                                            <option value="-1">不限工作地点</option>
                                            <?php foreach($qu as $k=>$v){ ?>
                                                <option value="<?=$v->id;?>">
                                                    <?=$v->short_name;?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <input type="text" autocomplete="off" placeholder="详细位置" name="address" id="jquery-tagbox-text1" class="add-v"/>
                                        <span class="tianj">+添加</span>
                                        <input type="hidden" name="address_list"/>
                                        <ul class="dizhi" id="search-result" style="display:none"></ul>
                                        <p class="cuowu address_error">内容不能为空!</p>
                                    </div>
                                    <div class="zhi" id="selected-address">
                                    <?php foreach($address as $item){?>
                                        <div class="p-box" id="<?=$item->id?>"><span>&times;</span><div class="dz-v"><?=$item->title?></div></div>
                                    <?php }?>
                                    </div>
                                </li>
                                <li>
                                    <div class="pull-left title-left text-center"><em>*</em>工作内容</div>
                                    <div class="pull-left right-box">
                                        <div id="editor" class="edit">
                                            <?php if($task->detail) {
                                                echo $task->detail;
                                            }else{?>
                                            <p>工作时间：</p>
                                            <p>工作薪酬：</p>
                                            <p>工作要求：</p>
                                            <?php  }?>
                                        </div>
                                        <input type="hidden" name="detail" value="$task->detail"/>
                                        <p class="cuowu detail-error">内容不能为空!</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="pull-left title-left text-center"><em>*</em>人员要求</div>
                                    <div class="pull-left right-box input-z">
                                        <div class="nice-select pull-left ma-right wsj">
                                            <input name="need_quantity" type="text" class="pull-left" placeholder="人数" value="<?=$task?$task->need_quantity:''?>">
                                        </div>
                                        <div class="nice-select pull-left ma-right" name="nice-select">
                                            <input name="gender_requirement" readonly type="text" placeholder="性别" value="<?=$task->gender_requirement!=false?TASK::$GENDER_REQUIREMENT[$task->gender_requirement]:'男女不限'?>">
                                            
                                            <ul>
                                                <li>男女不限</li>
                                                <li>男</li>
                                                <li>女</li>
                                            </ul>
                                        </div>
                                        <div class="nice-select pull-left ma-right" name="nice-select">
                                            <input name="height_requirement" type="text" readonly placeholder="身高" value="<?=$task->height_requirement!=false?TASK::$HEIGHT_REQUIREMENT[$task->height_requirement]:'身高无要求'?>">
                                            
                                            <ul>
                                                <li>身高无要求</li>
                                                <li>155cm以上</li>
                                                <li>165cm以上</li>
                                                <li>170cm以上</li>
                                                <li>175cm以上</li>
                                            </ul>
                                        </div>
                                        <span class="add-xs">+其他要求</span>
                                    </div>
                                    <div class="add-ons">
                                        <div class="nice-select pull-left add-ons-input" name="nice-select">
                                            <input name="face_requirement" type="text" readonly placeholder="形象" value="<?=$task->face_requirement!=false?TASK::$FACE_REQUIREMENT[$task->face_requirement]:'形象无要求'?>">
                                            
                                            <ul>
                                                <li>形象无要求</li>
                                                <li>形象好</li>
                                                <li>形象非常好</li>
                                            </ul>
                                        </div>
                                        <div class="nice-select pull-left add-ons-input" name="nice-select">
                                            <input name="talk_requirement" type="text" readonly placeholder="沟通能力" value="<?=$task->talk_requirement!=false?TASK::$TALK_REQUIREMENT[$task->talk_requirement]:'沟通能力无要求'?>">
                                            
                                            <ul>
                                                <li>沟通能力无要求</li>
                                                <li>沟通能力强</li>
                                            </ul>
                                        </div>
                                        <div class="nice-select pull-left add-ons-input" name="nice-select">
                                            <input name="health_certificated" type="text" readonly placeholder="健康证" value="<?=$task->health_certificated!=false?TASK::$HEALTH_CERTIFICATED[$task->health_certificated]:'健康证无要求'?>">
                                            
                                            <ul>
                                                <li>有健康证</li>
                                                <li>健康证无要求</li>
                                            </ul>
                                        </div>
                                        <div class="nice-select pull-left add-ons-input" name="nice-select">
                                            <input name="degree_requirement" type="text" readonly placeholder="学历" value="<?=$task->degree_requirement!=false?TASK::$DEGREE_REQUIREMENT[$task->degree_requirement]:'学历无要求'?>">
                                            
                                            <ul>
                                                <li>本科以上</li>
                                                <li>本科</li>
                                                <li>大专</li>
                                                <li>高中</li>
                                                <li>学历无要求</li>
                                            </ul>
                                        </div>
                                        <div class="nice-select pull-left add-ons-input" name="nice-select">
                                            <input name="weight_requirement" type="text" readonly placeholder="体重" value="<?=$task->weight_requirement!=false?TASK::$WEIGHT_REQUIREMENT[$task->weight_requirement]:'体重无要求'?>">
                                            
                                            <ul>
                                                <li>体重无要求</li>
                                                <li>60kg以下</li>
                                                <li>60-65kg</li>
                                                <li>65-70kg</li>
                                                <li>70-75kg</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="cuowu need_quantity-error ql">内容不能为空!</p>
                                </li>
                                <li>
                                    <div class="pull-left title-left text-center"><em>*</em>薪酬</div>
                                    <div class="pull-left right-box input-z">
                                        <div class="nice-select pull-left ma-right wsj">
                                            <input name="salary" type="text" class="pull-left" placeholder="数量，如100" value="<?=$task->salary?sprintf("%.1f",$task->salary):''?>">
                                        </div>
                                        <div class="nice-select pull-left ma-right" name="nice-select">
                                            <input name="salary_unit" type="text" readonly placeholder="薪酬单位" value="<?=strlen($task->salary_unit)>0?'元/'.TASK::$SALARY_UNITS[$task->salary_unit]:''?>">
                                            
                                            <ul>
                                                <li>元/小时</li>
                                                <li>元/天</li>
                                                <li>元/周</li>
                                                <li>元/月</li>
                                                <li>元/次</li>
                                            </ul>
                                        </div>
                                        <div class="nice-select pull-left ma-right ma-right" name="nice-select">
                                            <input type="text" name="clearance_period" readonly placeholder="结算方式" value="<?=$task->clearance_period!=false?TASK::$CLEARANCE_PERIODS[$task->clearance_period]:''?>">
                                            
                                            <ul>
                                                <li>月结</li>
                                                <li>周结</li>
                                                <li>日结</li>
                                                <li>完工结</li>
                                            </ul>
                                        </div>
                                        <!--<div class="pull-left yuji">预计有25名应聘者</div>-->
                                        <p class="cuowu salary-error">内容不能为空!</p>
                                    </div>
                                </li>
                                <!-- 公司 -->
                                <li>
	                                <div class="pull-left title-left text-center"><em>*</em>公司</div>
	                                <div class="pull-left right-box">
	                                    <input name="company_name" type="text" placeholder="输入公司名" value="<?=$task->company_name?>">
	                                    <p class="cuowu company-error">内容不能为空!</p>
	                                </div>
	                            </li>
                                <!-- 联系人 -->
                                <li>
	                                <div class="pull-left title-left text-center"><em>*</em>联系人</div>
	                                <div class="pull-left right-box">
	                                    <input name="contact" type="text" placeholder="输入联系人" value="<?=$task->contact?>">
	                                    <p class="cuowu contact-error">内容不能为空!</p>
	                                </div>
	                            </li>
                                <!-- 联系电话 -->
                                 <li>
	                                <div class="pull-left title-left text-center"><em>*</em>联系电话</div>
	                                <div class="pull-left right-box">
	                                    <input name="contact_phonenum" type="text" placeholder="输入联系电话" value="<?=$task->contact_phonenum?>">
	                                    <p class="cuowu contact_phonenum-error">内容不能为空!</p>
	                                </div>
	                            </li>
                                <!-- 运营 -->
                               
                                <li>
	                                <div class="pull-left title-left text-center"><em>*</em>优单</div>
	                                <div class="pull-left right-box zhiweileibie">
	                                    <div class="nice-select tl" name="nice-select">
	                                        <input type="text" readonly placeholder=" ===是否为优单===" value="<?= ($task->recommend)!==null ? Task::$RECOMMEND[$task->recommend] : ''?>">
	                                        <ul>
	                                        	<li>是</li>
	                                        	<li>否</li>
	                                        </ul>
	                                        <input type="hidden" name="recommend" value="<?= ($task->recommend)!==null ? Task::$RECOMMEND[$task->recommend] : ''?>"/>
	                                        <p class="cuowu recommend-error">内容不能为空!</p>
	                                    </div>
	                                </div>
	                            </li>
                                <!-- 状态 -->
                         
                                 <li>
	                                <div class="pull-left title-left text-center"><em>*</em>状态</div>
	                                <div class="pull-left right-box zhiweileibie">
	                                    <div class="nice-select tl" name="nice-select">
	                                        <input type="text" readonly placeholder=" ===状态===" value="<?= ($task->status) !==null ? Task::$STATUSES[$task->status] : ''?>">
	                                         <ul>
	                                        	<?php foreach(Task::$STATUSES as $st) {?>
	                        					<li><?=$st?></li>
	                        					<?php }?>
	                                        </ul>
	                                        <input type="hidden" name="status" value="<?= ($task->status) !==null ? Task::$STATUSES[$task->status] : ''?>"/>
	                                        <p class="cuowu status-error">内容不能为空!</p>
	                                    </div>
	                                </div>
	                            </li>
	                            <li>
	                            	


	                            </li>
                            </ul>
                            
                          
                                <button class="fabu-bt">提交</button>
                          
                            <?php ActiveForm::end(); ?>
    </div>
<div id="map" style="display:none"></div>
<?php $this->beginBlock('css')?>
	<link href="<?=Yii::$app->params["baseurl.static.dashboard"]?>/static/font/iconfont.css" type="text/css" rel="stylesheet">
    <link href="<?=Yii::$app->params["baseurl.static.dashboard"]?>/static/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <link href="<?=Yii::$app->params["baseurl.static.dashboard"]?>/static/css/miduoduo-qy.css" type="text/css" rel="stylesheet" />
    <link href="<?=Yii::$app->params["baseurl.static.dashboard"]?>/static/js/data/daterangepicker-bs3.css" type="text/css" rel="stylesheet" />
<?php $this->endBlock('css')?>

<?php $this->beginBlock('js')?>
	<script src="<?=Yii::$app->params["baseurl.static.dashboard"]?>/static/js/miduoduo.js"></script>
	<script>

$(function() {
      $(".tagBox-add-tag").hide();
});

$('form').on('submit', function(){
    $('.cuowu').hide();
    var form = document.forms[0];
    form.detail.value = $("#editor").html();
    var su = form.salary_unit.value;
    if(su.indexOf('/') >= 0) su = su.substring(2);
    form.salary_unit.value = su;
    if (form.is_longterm.checked) {
        form.is_longterm.value = 1;
    }else {
        form.is_longterm.value = 0;
    }
    if (form.is_allday.checked) {
        form.is_allday.value = 1;
    }else {
        form.is_allday.value = 0;
    }
    var address = '';
    $('#selected-address .p-box').each(function(){
        var addr = $(this).attr('id');
        if(address.length > 0) address = address + ' ';
        address = address + addr;
    });
    form.address_list.value = address;

    var valid = true;
    if (form.title.value.length == 0) {
        $('.title-error').html('请输入兼职标题');
        $('.title-error').show();
        valid = false;
    }
    if (form.service_type_id.value.length == 0) {
        $('.service_type_id-error').html('请选择兼职类别');
        $('.service_type_id-error').show();
        valid = false;
    }

function getNowFormatDate() {
    var date = new Date();
    var seperator1 = "-";
    var seperator2 = ":";
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    var currentdate = year + seperator1 + month + seperator1 + strDate;
    return currentdate;
}

    var today = getNowFormatDate();
    if( form.to_date.value < today && !form.is_longterm.checked ){
        $('.to_time-error').html('您的工作日期需要修改，截止日期应在今天之后');
        $('.to_time-error').show();
        valid = false;
    }
    if ( form.is_allday.checked ==false && (form.from_time.value.length == 0 || form.to_time.value.length == 0)){
        $('.to_time-error').html('请选择上班时间和下班时间');
        $('.to_time-error').show();
        valid = false;
    }
    if (form.address_list.value.length == 0) {
        $('.address_error').html('请输入工作地点');
        $('.address_error').show();
        valid = false;
    }
    if (form.need_quantity.value.length == 0) {
        $('.need_quantity-error').html('请输入人数');
        $('.need_quantity-error').show();
        valid = false;
    }else {
        var value = form.need_quantity.value;
        if (value != value.replace(/[^0-9\.]/g, '')) {
            $('.need_quantity-error').html('人数请输入数字');
            $('.need_quantity-error').show();
            valid = false;
        }
    }
    if (form.salary.value.length == 0) {
        $('.salary-error').html('请输入薪酬');
        $('.salary-error').show();
        valid = false;
    }else {
        var value = form.salary.value;
        if (value != value.replace(/[^0-9\.]/g, '')) {
            $('.salary-error').html('薪酬请输入数字');
            $('.salary-error').show();
            valid = false;
        }
    }
    if (form.salary_unit.value.length == 0) {
        $('.salary-error').html('请选择金额单位');
        $('.salary-error').show();
        valid = false;
    }
    if (form.clearance_period.value.length == 0) {
        $('.salary-error').html('请选择结算方式');
        $('.salary-error').show();
        valid = false;
    }
    // 公司
    if (form.company_name.value.length == 0) {
        $('.company-error').html('请输入公司名');
        $('.company-error').show();
        valid = false;
    }
    // 联系人
    if (form.contact.value.length == 0) {
        $('.contact-error').html('请输入联系人');
        $('.contact-error').show();
        valid = false;
    }
    // 联系电话
    if (form.contact_phonenum.value.length == 0) {
        $('.contact_phonenum-error').html('请输入联系电话');
        $('.contact_phonenum-error').show();
        valid = false;
    }else{
        var value = form.contact_phonenum.value;
        if(!value.match(/^1[0-9][0-9]\d{4,8}$/)){
            $('.contact_phonenum-error').html("请输入正确的手机号");
            $('.contact_phonenum-error').show();
            valid = false;
        }
    }
    // 优单
    if (form.recommend.value.length == 0) {
        $('.recommend-error').html('请选择是否为优单');
        $('.recommend-error').show();
        valid = false;
    }
    // 状态
    if (form.status.value.length == 0) {
        $('.status-error').html('请选择任务状态');
        $('.status-error').show();
        valid = false;
    }

   

    if(valid === false){
        $('html,body').scrollTop(0);
    }

    return valid;

});

$('#address_count').change(function(){
    var value = $(this).val();
    if (value == '一个') {
        $(".tagBox-add-tag").hide();
        $("#jquery-tagbox-text1-input").attr('placeholder', '请输入工作地址');
        $(".tagBox-input").show();
    }else if (value == '不限') {
        $(".tagBox-add-tag").hide();
        $("#jquery-tagbox-text1").hide();
    }else{
        $(".tagBox-add-tag").hide();
        $("#jquery-tagbox-text1").attr('placeholder', '请输入工作地址,多个地址用逗号分隔');
        $("#jquery-tagbox-text1").show();
    }
});

$(function(){
    var pois={};
    var current_poi = false;
    var added_pois = new Array();
    function remove_address(id){
        $.ajax({
            url: '/task/delete-address?id=' + id,
            method: 'get',
        }).done(function(dstr){
            var data = $.parseJSON(dstr);
            console.log(data);
        })
    }
    window.remove_address = remove_address;
    function pick_poi(poi){
        var address = {
            'lat': poi.point.lat,
            'lng': poi.point.lng,
            'address': poi.address,
            'city': poi.city,
            'province': poi.province,
            'title': poi.title
        };
        $.post('/task/add-address', {
            lat: poi.point.lat,
            lng: poi.point.lng,
            address: poi.address,
            city: poi.city,
            province: poi.province,
            title: poi.title
        }, function(str){
            var data = JSON.parse(str);
            if(data.success === true){
                var content = '<div class="p-box" id="' + data.result.id + '"><span>&times;</span><div class="dz-v">' + current_poi.title +'</div></div>';
                $('#selected-address').html($('#selected-address').html() + content);
                added_pois.push(current_poi);
                current_poi = false;
                $('#jquery-tagbox-text1').val('');
                $('#selected-address div.p-box span').click(function(){
                    var aid = $(this).parent().attr('id');
                    remove_address(aid);
                    var index = $(this).parent().index();
                    $(this).parent().remove();
                });
            }
        });
    }
    window.pick_poi = pick_poi;
    var map = new BMap.Map("map");
    var sr = $("#search-result");
    var kwipt = $("#keyword");
    map.centerAndZoom(new BMap.Point(116.422820,39.996632), 11);
    var options = {
     onSearchComplete: function(results){
       if (local.getStatus() == BMAP_STATUS_SUCCESS){
         // 判断状态是否正确
         var s = [];
         pois = {};
         var lis = '';
         for (var i = 0; i < results.getCurrentNumPois(); i ++){
            var poi = results.getPoi(i);
            pois[i] = poi;
            lis += '<li idx="' + i + '"><h2>' + poi.title + '</h2><p>' + poi.address +'</p></li>';
         }
         sr.html(lis);
         sr.find('li').each(function(){
            $(this).click(function(){

                var title = $(this).find('h2').html();
                $('#jquery-tagbox-text1').val(title+' ');
                $('#jquery-tagbox-text1').focus();
                sr.hide();
                var index = $(this).attr('idx');
                current_poi = pois[index];
            });
         })
         
            var qu_id  = $("#address_qu").val();
            if( qu_id == -1 ){
                // 不限工作地点（区县）
                var index = $(this).attr('idx');
                current_poi = pois[0];

                var sheng       = '';
                var sheng_show  = '';
                var shi     = '北京';
                if( $("#address_sheng").val() > 0 ){
                    sheng      = $("#address_sheng").find("option:selected").text().replace(/(^\s*)|(\s*$)/g, "")+' ';
                    sheng_show = sheng;
                    if( sheng == '北京 ' || sheng == '天津 ' || sheng == '上海 ' || sheng == '重庆 ' ){
                        sheng_show = '';
                    }
                }
                if( $("#address_shi").val() > 0 ){
                    shi  = $("#address_shi").find("option:selected").text().replace(/(^\s*)|(\s*$)/g, "")+' ';
                }
                var address_info = sheng_show+shi;
                if(address_info.length == 0) return;
                current_poi.city = shi;
                current_poi.province = sheng;
                current_poi.title = address_info;
                pick_poi(current_poi);
            }else{
                sr.show();
            }
       }
     }
    };
    $("body").on("click", function(){
        $("#search-result").hide();
    });
    var local = new BMap.LocalSearch(map, options);
    $('#jquery-tagbox-text1').keyup(function(e){
        var sheng   = '';
        var shi     = '';
        var qu      = '';
        if( $("#address_sheng").val() > 0 ){
            sheng= $("#address_sheng").find("option:selected").text().replace(/(^\s*)|(\s*$)/g, "")+' ';
        }
        if( $("#address_shi").val() > 0 ){
            shi  = $("#address_shi").find("option:selected").text().replace(/(^\s*)|(\s*$)/g, "")+' ';
        }
        if( $("#address_qu").val() > 0 ){
            qu   = $("#address_qu").find("option:selected").text().replace(/(^\s*)|(\s*$)/g, "")+' ';
        }
        var address_info = sheng+shi+qu;
        var keywordlen = $(this).val().length;
        //var code = (e.keyCode ? e.keyCode : e.which);
        //if( code == 13 ) {
        var has_space   = $(this).val().search(' ');
        if( keywordlen >= 2 && has_space < 0 ) {
            local.search(address_info+$(this).val());
            sr.html();
            return false;
        }
    });
    $('.tianj').click(function(){
        var sheng   = '';
        var sheng_show = '';
        var shi     = '北京';
        var qu      = '';
        if( $("#address_sheng").val() > 0 ){
            sheng     = $("#address_sheng").find("option:selected").text().replace(/(^\s*)|(\s*$)/g, "")+' ';
            sheng_show= sheng;
            if( sheng == '北京 ' || sheng == '天津 ' || sheng == '上海 ' || sheng == '重庆 ' ){
                sheng_show = '';
            }
        }
        if( $("#address_shi").val() > 0 ){
            shi  = $("#address_shi").find("option:selected").text().replace(/(^\s*)|(\s*$)/g, "")+' ';
        }
        if( $("#address_qu").val() > 0 ){
            qu   = $("#address_qu").find("option:selected").text().replace(/(^\s*)|(\s*$)/g, "")+' ';
        }
        var address_info = sheng_show+shi+qu;

        if($('#jquery-tagbox-text1').val().length == 0) return;
        if(current_poi === false){
            current_poi = {};
            current_poi.address = '';
            current_poi.city = shi;
            current_poi.province = '';
            current_poi.point = {lat:0, lng:0};
        }
        current_poi.city = shi;
        current_poi.province = sheng;
        current_poi.title = address_info+$('#jquery-tagbox-text1').val();
        if( current_poi.title.length > 0 ){
            pick_poi(current_poi);
        }
    });
    $('#selected-address div.p-box span').click(function(){
        var aid = $(this).parent().attr('id');
        remove_address(aid);
        var index = $(this).parent().index();
        $(this).parent().remove();
    });

    // 选择省份
    $('#address_sheng').on('change',function(){
        $('#jquery-tagbox-text1').removeAttr('readonly');
        $("#address_qu").html('<option value="0">区/县</option><option value="-1">不限工作地点</option>');

        var parent_id  = $(this).val();
        $.ajax({ url: $("#api_url").text()+'/v1/district?filters=[["=","parent_id",'+parent_id+']]', context: document.body, success: function(data){
            var option_obj  = data;
            var option_str  = '';
            for( var i=0;i < option_obj.items.length;i++){
                var shi_selected = '';
                if( parent_id == 20 || parent_id == 2 || parent_id == 795 || parent_id == 2259 ){
                    shi_selected = 'selected="selected"';
                }
                changeShi(option_obj.items[i].id);
                option_str  += '<option '+shi_selected+' value="'+option_obj.items[i].id+'">'+option_obj.items[i].short_name+'</option>';
            }
            option_str  += '';
            $("#address_shi").html(option_str);
        }});
    });
    // 选择市
    $('#address_shi').on('change',function(){
        changeShi(0);
    });
    function changeShi(parent_id){
        $('#jquery-tagbox-text1').removeAttr('readonly');
        $("#address_qu").html('<option value="0">区/县</option');

        var parent_id  = parent_id ? parent_id : $('#address_shi').val();
        if( parent_id == 0 ){
            return false;
        }
        $.ajax({ url: $("#api_url").text()+'/v1/district?filters=[["=","parent_id",'+parent_id+']]', context: document.body, success: function(data){
            var option_obj  = data;
            var option_str  = '<option value="0">区/县</option><option value="-1">不限工作地点</option>';
            for( var i=0;i < option_obj.items.length;i++){
                option_str  += '<option value="'+option_obj.items[i].id+'">'+option_obj.items[i].short_name+'</option>';
            }
            option_str  += '';
            $("#address_qu").html(option_str);
        }});
    }
    // 不限工作地点（区县）
    $('#address_qu').on('change',function(){
        var parent_id  = $(this).val();
        if( parent_id == -1 ){
            $('#jquery-tagbox-text1').attr('readonly','readonly');
            var sheng   = '';
            var shi     = '';
            if( $("#address_sheng").val() > 0 ){
                sheng= $("#address_sheng").find("option:selected").text().replace(/(^\s*)|(\s*$)/g, "")+' ';
            }
            if( $("#address_shi").val() > 0 ){
                shi  = $("#address_shi").find("option:selected").text().replace(/(^\s*)|(\s*$)/g, "")+' ';
            }
            var address_info = sheng+shi;
            local.search(address_info);
            sr.html();
            
            return false;
        }else{
            $('#jquery-tagbox-text1').removeAttr('readonly');
        }
    });

    $('.reservation').daterangepicker(null, function(start, end, label) {
        var form = document.forms[0];
        form.from_date.value = start.format('YYYY-MM-DD');
        form.to_date.value = end.format('YYYY-MM-DD');
        //console.log(start.format('YYYY-MM-DD'));
    });  
});


	</script>
	<script src="<?=Yii::$app->params["baseurl.static.dashboard"]?>/static/js/data/moment.js"></script>
	<script src="<?=Yii::$app->params["baseurl.static.dashboard"]?>/static/js/data/daterangepicker.js"></script>

	<script src="<?=Yii::$app->params["baseurl.static.dashboard"]?>/static/js/fuwenben/bootstrap-wysiwyg.js"></script>
	<script src="<?=Yii::$app->params["baseurl.static.dashboard"]?>/static/js/fuwenben/external/jquery.hotkeys.js"></script>
	<script src="<?=Yii::$app->params["baseurl.static.dashboard"]?>/static/js/jquery.tagbox.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=GB9AZpYwfhnkMysnlzwSdRqq"> </script>
<?php $this->endBlock('js')?>

	
<!-- InstanceEndEditable -->


    <!--
    <?php print_r($address);?>
-->
