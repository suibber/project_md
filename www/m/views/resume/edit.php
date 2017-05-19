<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

$this->title = '编辑简历';
$this->params['breadcrumbs'][] = $this->title;

$this->nav_left_link = 'javascript:window.history.back()';
$this->nav_right_link = Url::to(['site/index']);
$this->nav_right_title = '首页';


?>
<?php $form = ActiveForm::begin(); ?>
<div class="alert alert-success" role="alert">填写基本资料，红包马上到碗里！</div>
<div class="form-list">
  <div class="jl-xq">
    <?= $form->field($model, 'name') ?>
    <?= ''//$form->field($model, 'birthdate')->textInput(['type'=>'date']) ?>
    <?= $form->field($model, 'college') ?>
    <?= $form->field($model, 'major') ?>


    <div class="form-group">
        <label>性别</label>
        <div class="btn-group" data-toggle="buttons">
        <input id="<?=Html::getInputId($model, 'gender')?>" class="form-control hidden"
            name="<?=Html::getInputName($model, 'gender')?>" type="hidden" value="<?=$model->gender?>" />
        <?php foreach($model::$GENDERS as $v=>$name){
        ?>
            <label class="btn btn-primary <?=$model->gender==$v?'active':''?>">
            <input onchange="$('#<?=Html::getInputId($model, 'gender')?>').val($(this).val());" type="radio" value="<?=$v?>">
            <?=$name?></label>
        <?php
        } ?>
        </div>
        <div class="help-block"></div>
    </div>
    <?= $form->field($model, 'job_wishes') ?>
   <div class="form-group">
    <label>可兼职时间</label>
      <table class="table table-bordered tab-jz">
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
</div>
<p class="block-btn">
    <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
</p>
<?php ActiveForm::end(); ?>
<?php $this->beginBlock('js') ?>
<script>
$(function(){
    $('.diy-checkbox').bind(GB.click_event,
        function(){
            var _this=$(this);
            $.ajax({url: './freetimes',
                'method': 'POST',
                'data': {'dayofweek': _this.attr('data-dayofweek'),
                    'when': _this.attr('data-when'),
                    'is_availiable': _this.hasClass('pitch-on')?'0':'1'
                }
            }).done(function(text){
                 data=$.parseJSON(text);
                 if (data['result']){
                     data['is_availiable']?_this.addClass('pitch-on'):_this.removeClass('pitch-on');
                 } else {
                 }
            });
        });
});
</script>
<?php $this->endBlock('js') ?>

