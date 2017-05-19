  <dl class="jz_tab">
    <dt>
      <div class="jz_tab_1">兼职人员</div>
      <div class="jz_tab_2">当前工作地点</div>
      <div class="jz_tab_3">上岗天数</div>
      <div class="jz_tab_4">工作记录</div>
      <div class="jz_tab_5">操作</div>
    </dt>
<?php foreach ($task->resumes as $resume) {?>
    <dd>
      <div class="jz_tab_1"><a href="#"><?=$resume->name?></a></div>
      <div class="jz_tab_2">西直门必胜客</div>
      <div class="jz_tab_3">38天</div>
      <div class="jz_tab_4"><span>迟到<em>3</em></span><span>早退<em>3</em></span><span>旷工<em class="red">3</em></span><span>记录<em>3</em></span></div>
      <div class="jz_tab_5">
        <div class="box_t">
            <span><a target="_blank" href="/time-book/settings?user_id=<?=$resume->user_id?>&task_id=<?=$task->id?>">工作内容设置</a></span>
            <span><a target="_blank" href="/time-book/detail?user_id=<?=$resume->user_id?>&task_id=<?=$task->id?>">工作明细</a></span>
    </div>
    </dd>
<?php } ?>
  </dl>
<div class="daka_foot">
      <div class="daka_page">
          <a href="#">上一页</a><a href="#" class="on">1</a><a href="#">2</a><a href="#">...</a><a href="#">6</a><a href="#">下一页</a>
      </div>
      <div class="daka_r">
         <a href="#" class="xiazai">下载考勤表</a>
         <a href="#">添加兼职人员</a>
      </div>
</div>

