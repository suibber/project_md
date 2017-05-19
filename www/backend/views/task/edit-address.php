<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = '设置地址';
?>
    <h1>为<?=$task->title?>设置地址</h1>
<div class="form-group field-task-city_id required col-xs-8">
    <label class="control-label">地址（可添加多个）</label>
    <hr />
    <?php if (count($task->addresses)==0) {
        echo "无";
    } ?>
    <ul id="address-list" class="list-group">
        <?php foreach ($task->addresses as $address){ ?>
            <li class="list-group-item">
                <h5>
                <?=$address->city?>, <?=$address->address?>, <?=$address->title?>
                <a href="#" onclick="remove_address(this, <?=$address->id?>);" class="pull-right">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
                </h5>
            </li>
        <?php }?>
    </ul>
    <hr />
        <div id="map" class="row hidden" style="height:0px;">
        </div>
        <div class="row">
            <div class="input-group">
              <input type="text" class="form-control" id="keyword" placeholder="省市+小区大厦等" />
              <span class="input-group-addon" id="search">
                <span class="glyphicon glyphicon-search"></span>
              </span>
            </div>
        </div>
        <div class="row">
            <ul class="list-group" id="search-result">
            </ul>
        </div>

    <hr />
    <a class="btn btn-primary" href="/task/view?id=<?=$task->id?>">完成</a>
<div>
<!-- Modal -->
<div class="modal fade" id="edit-address" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">添加位置</h4>
      </div>
      <div class="modal-body">
<?php $form = ActiveForm::begin(); ?>
    <div class="container-fluid">
    </div>
    <div id="log"></div>
<?php $form = ActiveForm::end(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">完成</button>
      </div>
    </div>
  </div>
</div>

<?php $this->beginBlock('css') ?>
<style>
.list-group-item {
    padding: 2px 10px 2px 10px;
}
</style>
<?php $this->endBlock('css') ?>
<?php $this->beginBlock('js') ?>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=GB9AZpYwfhnkMysnlzwSdRqq"> </script>

<script type="text/javascript">
 $(function(){
    var pois={};
    function remove_address(btn, id){
        $.ajax({
            url: '/task-address/delete?id=' + id,
            method: 'post',
        }).done(function(dstr){
            var data = $.parseJSON(dstr);
            if (data.success){
                $(btn).closest('li').remove();
            }
        })
    }
    window.remove_address = remove_address;
    function pick_poi(btn, i){
        var poi = pois[i];
        var address = {
            'TaskAddress[lat]': poi.point.lat,
            'TaskAddress[lng]': poi.point.lng,
            'TaskAddress[address]': poi.address,
            'TaskAddress[city]': poi.city,
            'TaskAddress[province]': poi.province,
            'TaskAddress[title]': poi.title
        };
        $.ajax({
            url: '/task-address/create?task_id=' + '<?=$task->id?>',
            method: 'post',
            data: address,
        }).done(function(dstr){
            var data = $.parseJSON(dstr);
            if (data.success){
                $(btn).closest('li').remove();
                var nli = '<li class="list-group-item"> '
                + '<h5>'
                +data.result.city + ',' + data.result.title + ',' + data.result.address
                +'<a href="#" onclick="remove_address(this, ' + data.result.id + ');" class="pull-right">'
                +'    <span class="glyphicon glyphicon-remove"></span>'
                +'</a>'
                +'</h5>'
                +'</li>';
                $("#address-list").append(nli);
            }
        })
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
            lis += '<li class="list-group-item"><h5>' + poi.title + '<button class="btn btn-danger pull-right" type="button" onclick="pick_poi(this, ' + i + ')" >添加</button></h5>  '+ poi.address +'</li>';
         }
         sr.html(lis);
       }
     }
    };
    var local = new BMap.LocalSearch(map, options);
    $("#search").click(function(){
        local.search(kwipt.val());
    });
});
</script>
<?php $this->endBlock() ?>
