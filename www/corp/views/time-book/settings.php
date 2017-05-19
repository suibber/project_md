<?php

$this->title = '设置兼职内容';
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
          <div class="conter-title1">考勤管理 &gt; 汽车之家APP推广 &gt; 设置兼职内容 </div>
          <ul class="tianxie-box" style="border:none">
            <li>
              <div class="pull-left title-left text-center">兼职人员</div>
              <div style="padding-top: 12px;" > <?=$applicant->resume->name?> </div>
            </li>
            <li>
                  <div class="pull-left title-left text-center">工作日期</div>
                  <div class="pull-left right-box div">
                    <div class="riqi jz_in">
                      <input type="text" readonly="" style="width: 330px" name="reservation" class="reservation" placeholder="选择工作日期范围">
                  </div>
                  <p class="cuowu">内容不能为空!</p>
                </div></li>
            <li>
              <div class="pull-left title-left text-center">工作地点</div>
              <div class="pull-left right-box zhiweileibie">
                <div class="nice-select jz_in" name="nice-select">
                  <input type="text" placeholder="选择工作地点">
                  <ul class="in500" style="display: none;">
                    <?php foreach ($applicant->task->addresses as $address) { ?>
                    <li data-value="<?=$address->id?>"><?=$address->title?></li>
                    <?php }?>
                  </ul>
                </div>
              </div>
            </li>
            <li>
              <div class="pull-left title-left text-center">打卡坐标</div>
              <div class="pull-left right-box jz_in">
                 <div class="map_box"><img src="img/ditu_pic.jpg" width="500" height="312"></div>
                 <p class="map_ts">*拖动地图图标可更改打卡地点</p>
              </div>
            </li>
            <li>
              <div class="pull-left title-left text-center">上下班时间</div> 
              <div class="time-xz">
                      <div class="nice-select times" name="nice-select">
                        <input type="text" placeholder="上班时间">
                        <ul style="display: none;">
                          <li>00:00</li>
                          <li>00:30</li>
                          <li>01:00</li>
                          <li>01:30</li>
                          <li>02:00</li>
                          <li>02:30</li>
                          <li>03:00</li>
                          <li>03:30</li>
                        </ul>
                      </div>
                      <span class="pull-left">至</span>
                      <div class="nice-select times" name="nice-select">
                        <input type="text" placeholder="下班时间">
                        <ul style="display: none;">
                          <li>00:00</li>
                          <li>00:30</li>
                          <li>01:00</li>
                          <li>01:30</li>
                          <li>02:00</li>
                          <li>02:30</li>
                          <li>03:00</li>
                          <li>03:30</li>
                        </ul>
                      </div>
                  </div>
            </li>
          <button class="queding-bt">提交</button>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="js/miduoduo.js"></script> 
<script src="js/data/moment.js"></script> 
<script src="js/data/daterangepicker.js"></script> 
<script src="js/fuwenben/bootstrap-wysiwyg.js"></script> 
<script src="js/fuwenben/external/jquery.hotkeys.js"></script> 
<script src="js/jquery.tagbox.js"></script> 
<script>
$(".jz_renyuan").on("click","input",function(){
    $(this).next().show();
});
$(".jz_name").on("click","span",function(){
    $(this).toggleClass("span_on");
})
$(".jz_ry_qd").on("click","button",function(){
    $(this).parent().parent().hide();
    var arr = [];
    $(".span_on").each(function() {
        arr.push($(this).text());
    });
    //alert(arr);
    $(".input_t").val(arr.join(","));
    
});
</script>
<!-- InstanceEndEditable -->
<div class="foots">
  <div class="container foot">
    <div class="row">
      <div class="col-sm-12 col-md-4 col-lg-4">
        <h2>联系我们</h2>
        <p>邮箱：pangleimewe@126.com</p>
        <p>电话：400-7890886</p>
      </div>
      <div class="col-sm-12 col-md-4 col-lg-4">
        <h2>关于我们</h2>
        <p><a href="#">公司介绍</a></p>
        <p><a href="#">团队介绍</a></p>
      </div>
      <div class="col-sm-12 col-md-4 col-lg-4">
        <h2>关注我们</h2>
        <div class="erwei"><img src="img/mzhan.png" width="70" height="70">
          <div class="er-text">扫码进入m站</div>
        </div>
        <div class="erwei"><img src="img/weixin.png" width="70" height="70">
          <div class="er-text">关注微信公众号</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- InstanceEnd -->

</div>
