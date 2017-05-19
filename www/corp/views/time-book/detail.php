<?php


?>
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
            <?=$resume->name?>的考勤
          </div>
 <ul class="tianxie-box1" style="border:none">
    <li>
      <form action="#" method="GET">
          <input type="hidden" name="user_id" value="<?=$task->user_id?>">
          <input type="hidden" name="task_id" value="<?=$task->id?>">
          <input type="hidden" id="on_late"  name="on_late" value="<?=Yii::$app->request->get('on_late')?>">
          <input type="hidden" id="off_early" name="off_early" value="<?=Yii::$app->request->get('off_early')?>">
          <input type="hidden" id="out_work" name="out_work" value="<?=Yii::$app->request->get('out_work')?>">
          <div class="time-xz">
            <div class="nice-select times" name="nice-select">
              <input type="text" placeholder="是否迟到" name="n1" value="<?=Yii::$app->request->get('n1')?>">
              <ul style="display: none;">
                <li onclick="javascript:$('#on_late').val('');"></li>
                <li onclick="javascript:$('#on_late').val('1');">迟到</li>
                <li onclick="javascript:$('#on_late').val('0');">没迟到</li>
              </ul>
            </div>
          </div>
          <div class="time-xz">
            <div class="nice-select times" name="nice-select">
              <input type="text" name="n2" placeholder="是否早退" value="<?=Yii::$app->request->get('n2')?>">
              <ul style="display: none;">
                <li onclick="javascript:$('#off_early').val('');"></li>
                <li onclick="javascript:$('#off_early').val('1');">早退</li>
                <li onclick="javascript:$('#off_early').val('0');">没早退</li>
              </ul>
            </div>
          </div>
          <div class="time-xz">
            <div class="nice-select times" name="nice-select">
              <input type="text" name="n3" placeholder="是否旷工" value="<?=Yii::$app->request->get('n3')?>">
              <ul style="display: none;">
                 <li onclick="javascript:$('#out_work').val('');" ></li>
                 <li onclick="javascript:$('#out_work').val('1');">旷工</li>
                 <li onclick="javascript:$('#out_work').val('0');">没旷工</li>
              </ul>
            </div>
          </div>
          <button class="sech_1" style="background: #fff; ">搜索</button>
      </form>
    </li>
  </ul>
          <dl class="jz_tab1">
            <dt>
              <div class="jzqb_tab_1">工作日期</div>
              <div class="jzqb_tab_2" style="border:none">上下班情况</div>
              <div class="jzqb_tab_3">操作</div>
            </dt>
<?php foreach ($schedules as $schedule) {?>
            <dd>
            <div class="jzqb_tab_1"><?=$schedule->date?></div>
              <div class="jzqb_tab_2">
                <div><span>工作地点：</span><?=$schedule->address?></div>
              <?php if (!$schedule->is_past){ ?>
                <div> <span>上班时间：</span><?=$schedule->from_time?> </div>
                <div> <span>下班时间：</span><?=$schedule->to_time?> </div>
                <div> <span>工作状态：</span>未开始 </div>
              <?php } else { ?>
                <?php if ($schedule->out_work){ ?>
                <div>
                    <span></span>旷工
                </div>
                <?php } else { ?>
                <div>
                    <span>上班情况：</span>
                        <?=$schedule->on_late?'迟到':($schedule->out_work_on?'未打卡':'正常')?>
                     <?php if ($schedule->on_record) { 
                        $record=$schedule->on_record;
                     ?>
                        |
                        <?=$record->time?>
                        |  [<?=$record->distance?>]
                            <a target="_blank" href="http://api.map.baidu.com/marker?location=<?=$record->lat?>,<?=$record->lng?>&output=html">查看地图</a>
                     <?php } else {?>
                        |  无记录
                     <?php }?>
                </div>
                <div>
                    <span>下班情况：</span>
                        <?=$schedule->off_early?'早退':($schedule->out_work_off?'未打卡':'正常')?>
                     <?php if ($schedule->off_record) { 
                        $record=$schedule->off_record;
                     ?>
                        |
                        <?=$record->time?>
                        |  [<?=$record->distance?>]
                            <a target="_blank" href="http://api.map.baidu.com/marker?location=<?=$record->lat?>,<?=$record->lng?>&title=<?=$schedule->date.'-'.$resume->name.'-'.'上班打卡地点'?>&output=html">查看地图</a>
                     <?php } else {?>
                        |  无记录
                     <?php }?>
                </div>
                <?php } ?>
                <div>
                    <span>工作记录：</span><?=$schedule->note?>
                </div>
              <?php } ?>
              </div>
              <?php if ($schedule->is_past){ ?>
              <form action="/time-book/change-schedule" method="post">
              <div class="jzqb_tab_3">
                  <div class="box_t"> <span>修改</span>
                  <div class="kq_box1">
                  <div class="jl_jt3"><img src="<?=Yii::$app->params['baseurl.static.corp']?>/static/img/jl_jt.png" width="34" height="18"></div>
                  <input type="hidden" name="schedule_id" value="<?=$schedule->id?>" >
                  <div class="form_b">
                    <label><input name="action" value="on_late" type="radio"> 迟到</label>
                    <label><input name="action" value="off_early" type="radio">早退</label>
                    <label><input name="action" value="out_work" type="radio">矿工</label>
                    <label class="jl"><input name="action" value="record_note" type="radio">记录</label>
                  </div>
                  <span class="change-schedule">确定</span><span>取消</span>
                  <input type="text" name="note" class="ji_nr" placeholder="请输入要记录的内容">
                </div>
              </div>
              </form>
              <?php } else { ?>
               <form action="change-schedule" method="post">
               <input type="hidden" name="schedule_id" value="<?=$schedule->id?>" >
               <input type="hidden" name="action" value="delete" >
               <div class="jzqb_tab_3">
                  <div class="box_t"> <span class="change-schedule">删除</span></div>
                </div>
                </form>
              <?php }?>
            </dd>
<?php } ?>
          </dl>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->beginBlock('js') ?>
<script type="text/javascript">
    $(function(){
        $(".change-schedule").click(function(){
            var form = $(this).closest('form');
            var url = form.attr('action');
            var posts = {};
            $.each(form.serializeArray(), function(_, kv){
                posts[kv.name] = kv.value;
            });
            posts['_csrf'] = $('meta[name="csrf-token"]').attr("content");;
            $.post(url, posts, function(data, status){
                var r = $.parseJSON(data);
                if (r.success){
                    location.reload();
                } else {
                    alert(r.msg);
                }
            });
        });
    });
    $(".box_t").on("click","span",function(){
        $(this).parent().parent().find(".kq_box1").hide().eq($(this).index()).show()
    });
    $(".kq_box1").on("click","span",function(){
        $(this).parent().hide();
    });
    $(".kq_box1").on("click","label",function(){
        var i=$(this).index();
        if($(this).index() != 3){
               $(this).parent().parent().find(".ji_nr").hide(); 
            }else{
              $(this).parent().parent().find(".ji_nr").show();  
        }
    });
    
</script> 
<?php $this->endBlock('js') ?>

