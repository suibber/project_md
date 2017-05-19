<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Address */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="address-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'province')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'district')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lng')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'belong_to')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="container col-xs-12">
        <div id="map" class="row" style="height:400px;">
        </div>
        <div class="row">
            <div class="input-group">
              <input type="text" class="form-control" id="search-content" placeholder="省市+小区大厦等" />
              <span class="input-group-addon" id="search">
                <span class="glyphicon glyphicon-search"></span>
              </span>
            </div>
        </div>
        <div class="row">
            <ul class="list-group" id="search-result">
              <li class="list-group-item">-------</li>
            </ul>
        </div>
    </div>
</div>

<?php $this->beginBlock('js') ?>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=GB9AZpYwfhnkMysnlzwSdRqq"> </script>

<script type="text/javascript">
 $(function(){
    var map = new BMap.Map("map");
    map.centerAndZoom(new BMap.Point(116.422820,39.996632), 11);
    var options = {
     onSearchComplete: function(results){
       if (local.getStatus() == BMAP_STATUS_SUCCESS){
         // 判断状态是否正确
         var s = [];
         for (var i = 0; i < results.getCurrentNumPois(); i ++){  
           s.push(results.getPoi(i).title + ", " + results.getPoi(i).address);  
         }
         document.getElementById("log").innerHTML = s.join("<br />");
       }
     }
    };
    var local = new BMap.LocalSearch(map, options);
    
    local.search("公园");
});
</script>
<?php $this->endBlock() ?>
