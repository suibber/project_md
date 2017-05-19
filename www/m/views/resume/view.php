<div class="alert alert-success" role="alert">填写基本资料，红包马上到碗里！</div>
<div class="jl-xq">
    <table class="table">
      <tr>
        <td class="tab-jll"><div>手机号</div></td>
        <td class="tab-jlr"><div><?=$model->phonenum?> </div></td>
      </tr>
      <tr>
        <td class="tab-jll"><div>姓名</div></td>
        <td class="tab-jlr"><div><?=$model->name?> </div></td>
      </tr>
      <tr>
        <td class="tab-jll"><div>出生年月</div></td>
        <td class="tab-jlr"><div><?=$model->birthdate?></div></td>
      </tr>
      <tr>
        <td class="tab-jll"><div>性别</div></td>
        <td class="tab-jlr"><div><?=$model::$GENDERS[$model->gender]?></div></td>
      </tr>
     <tr>
        <td class="tab-jll"><div>学校</div></td>
        <td class="tab-jlr"><div><?=$model->college?></div></td>
      </tr>
    </table>
</div>
<div class="jl-xq">
   <div class="jz-time">
      <table class="table table-bordered tab-jz">
         <caption>可兼职时间</caption>
         <thead>
            <tr>
               <th><div></div></th>
               <th><div>周一</div></th>
               <th><div>周二</div></th>
               <th><div>周三</div></th>
               <th><div>周四</div></th>
               <th><div>周五</div></th>
               <th><div>周六</div></th>
               <th><div>周日</div></th>
            </tr>
         </thead>
         <tbody>
<?php 
$time_maps = ['morning'=>'上午',
    'afternoon'=>'下午',
    'evening'=>'晚上'
];
foreach ($time_maps as $when=>$title){
?>
    <tr>
        <td><em><?=$title?></em></td>
      <?php for($i=1;$i<=7;$i++) {
        $class = '';
        if (isset($freetimes[$i])){
            $ft = $freetimes[$i];
            $class = $ft->$when?'pitch-on':'';
        }
        ?>
        <td><div data-dayofweek="<?=$i?>" data-when="<?=$when?>" class="diy-checkbox span <?=$class?>"></div></td>
      <?php }?>
    </tr>
<?php } ?>
         </tbody>
     </table>
  </div>
</div>

<p class="block-btn">
   <a href="./edit" class="btn btn-primary btn-lg btn-block">
      修改资料
   </a>
 </p>
