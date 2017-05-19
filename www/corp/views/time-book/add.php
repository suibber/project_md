<?php

?>
<div class="body-box">
<div class="midd-kong"></div>
<div class="container">
  <div class="row">
    <div class="fabu-box padding-0">
      <div class="col-sm-12 col-md-2 col-lg-2 padding-0">
        <?= $this->render('../layouts/sidebar', ['active_menu'=> 'time_book'])?>
      </div>
      <div class="col-sm-12 col-md-10 col-lg-10 padding-0 ">
        <div class="right-center">
          <div class="conter-title1">
            <a href="/time-book/">考勤管理 </a>&gt; 
            <a href="/time-book/worker-summary?gid=<?=$task->gid?>"><?=$task->title?>考勤</a> &gt; 
            添加日程安排 
          </div>
          <form action="#" method="POST">
          <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" / >
          <ul class="tianxie-box" style="border:none">
            <li>
              <div class="pull-left title-left text-center">兼职人员</div>
              <div class="pull-left right-box jz_renyuan jz_in">
                <input type="text" readonly="" id="user_names" class="input_t" placeholder="从已报名兼职库里选兼职人员">
                <div class="jz_name">
                    <input type="hidden" id="user_ids" name="user_ids" />
                    <?php foreach ($task->resumes as $resume ) {?>
                    <span data-id="<?=$resume->user_id?>"><?=$resume->name?></span>
                    <?php } ?>
                    <div class="jz_ry_qd"><button type="button">确定</button></div>
                </div>
                 <p class="cuowu">内容不能为空!</p>
               </div>
            </li>
            <li>
                  <div class="pull-left title-left text-center">工作日期</div>
                  <div class="pull-left right-box div">
                    <div class="riqi jz_in">
                      <input type="text" readonly="" style="width: 330px" class="reservation" name="dates" id="dates" placeholder="选择工作日期">
                  </div>
                  <p class="cuowu">内容不能为空!</p>
                </div></li>
            <li>
              <div class="pull-left title-left text-center">工作地点</div>
              <div class="pull-left right-box zhiweileibie">
                <div class="nice-select jz_in" name="nice-select">
                  <input id="address" type="text" placeholder="选择地点">
                  <ul class="in500">
                    <?php foreach ($task->addresses as $address) { ?>
                    <li class="pick_address" data-id="<?=$address->id?>" data-lng="<?=$address->lng?>" data-lat="<?=$address->lat?>"><?=$address->title . '(' . $address->address . ')'?></li>
                    <?php }?>
                  </ul>
                </div>
                <input id="address_id" name="address_id" type="hidden">
                 <p class="cuowu">内容不能为空!</p>
              </div>
            </li>
            <li>
              <div class="pull-left title-left text-center">打卡地点</div>
              <div class="pull-left right-box jz_in">
                <input id="lng" name="lng" readonly = "readonly"  type="text" placeholder="纬度" style="width: 180px !important;">
                &nbsp; &nbsp;
                <input id="lat" name="lat" readonly = "readonly"  type="text" placeholder="经度" style="width: 180px !important;">
                 <p class="cuowu">内容不能为空!</p>
                 <p class="">*拖动地图设置精准坐标，打卡更精准</p>
                 <div class="map_box" style="width: 500px;height: 312px; position:relative;">
                    <div id="map"></div>
                    <img src="<?=Yii::$app->params['baseurl.static.corp']?>/static/img/marker.png" style="position: absolute; top: 132px; left: 240px; width: 20px; height: 25px;" />
                 </div>
              </div>
            </li>
            <li>
              <div class="pull-left title-left text-center">上下班时间</div> 
              <div class="time-xz">
                      <div class="nice-select times" name="nice-select">
                        <input id="from_time" name="from_time" type="text" placeholder="上班时间" value="<?=substr($task->from_time, 0, -3)?>">
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
                        <input id="to_time" name="to_time" type="text" placeholder="下班时间" value="<?=substr($task->to_time, 0, -3)?>">
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
                 <p class="cuowu">内容不能为空!</p>
                 </div>
            </li>
            <li>
              <div class="pull-left title-left text-center"></div>
              <div class="pull-left right-box jz_in">
                <button type="submit" id="submit" class="queding-bt">提交</button>
              </div>
            </li>
          </ul>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->beginBlock('css') ?>
<link rel="stylesheet" type="text/css" media="all" href="<?=Yii::$app->params['baseurl.static.corp']?>/static/js/data/daterangepicker-bs3.css">
<style>
    #map {
        width: 100%;
        height: 100%;
    }
</style>
<?php $this->endBlock('css') ?>
<?php $this->beginBlock('js') ?>
<script type="text/javascript" src="<?=Yii::$app->params['baseurl.static.corp']?>/static/js/data/daterangepicker.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?=Yii::$app->params['baidu.map.web_key']?>"></script>
<script type="text/javascript">
$("form").submit(function(e){
    var ec=0;
    $('.cuowu').hide();
    if (!$('#user_ids').val()){
        ec++;
        $('#user_ids').closest('li').find('.cuowu').html('不可没有兼职人员').show();
        console.info('user_ids 没有');
    }
    if (!$('#dates').val()){
        ec++;
        console.info('日期未选择');
        $('#dates').closest('li').find('.cuowu').html('没有日期').show();
    }
    if (!$('#from_time').val() && !$('#to_time').val()){
        ec++;
        console.info('上班时间');
        $('#from_time').closest('li').find('.cuowu').html('请设定上下班时间').show();
    }
    if (!$('#address_id').val()){
        ec++;
        console.info('地址没选');
        $('#address_id').closest('li').find('.cuowu').html('请选择地址').show();
    }
    if (!$('#lat').val() || !$('#lng').val()){
        ec++;
        console.info('坐标没有');
        $('#lat').closest('li').find('.cuowu').html('请设置坐标').show();
    }
    console.info('error count: '+ ec);
    if (ec==0){
        return true;
    }
    return false;
});
    // 百度地图API功能
var map = new BMap.Map("map");
var point=new BMap.Point(116.4035,39.915);
map.centerAndZoom(point, 17);  //初始化时，即可设置中心点和地图缩放级别。
map.enableScrollWheelZoom();
map.addControl(new BMap.NavigationControl());
map.enableDragging(); 
$('.pick_address').click(function(){
    var li = $(this);
    var lng = parseFloat(li.attr('data-lng'));
    var lat = parseFloat(li.attr('data-lat'));
    $('#lat').val(lat);
    $('#lng').val(lng);
    $("#address_id").val(li.attr('data-id'));
    map.centerAndZoom(new BMap.Point(lng, lat), 17);
});
function resetCenter(){
    var point = map.getCenter();
    $('#lat').val(point.lat);
    $('#lng').val(point.lng);
}
map.addEventListener('dragging', resetCenter);
map.addEventListener('dragend', resetCenter);
map.addEventListener('zoomend', resetCenter);

$(".jz_renyuan").on("click","input",function(){
    $(this).next().show();
});
var user_ipt = $('#user_ids');
var user_name_ipt = $("#user_names");
$(".jz_name").on("click","span",function(){
    $(this).toggleClass("span_on");
    var _id = $(this).attr('data-id');
    var name = $(this).html();

    var user_ids = user_ipt.val().split(',');
    var idx = user_ids.indexOf(_id);
    if (idx>=0){ user_ids.splice(idx, 1); } else { user_ids.push(_id); }
    user_ipt.val(user_ids.join(','));

    var user_names = user_name_ipt.val().split(',');
    var idx = user_names.indexOf(name);
    if (idx>=0){ user_names.splice(idx, 1); } else { user_names.push(name); }
    user_name_ipt.val(user_names.join(','));

})
$(".jz_ry_qd").on("click","button",function(){
    $(this).parent().parent().hide();
});
</script>
<?php $this->endBlock('js') ?>
</div>
