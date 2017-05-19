<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Address */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
.map-result {
    position:fixed;
    bottom: 0;
    left: 0;
    right: 0;
    top: 300px;
    z-index: 100;
}

.map-result.top {
    top: 64px !important;
    height:100vh !important;
}
.map-result.top .list-content {
    padding-bottom: 84px;
}

.search-box {
    position: fixed;
    top: 0;
    height: 64px;
    left: 0;
    right: 0;
}
.map {
    position: fixed;
    top: 64px;
    height: 240px;
    left: 0;
    right: 0;
    z-index: 10;

}

</style>

   <div class="seat-input search-box">
       <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
        <input type="text" id="search" class="form-control" placeholder="搜索地点（如：商业街、小区……）">
   </div>
   <div class="map" id="map" >
   </div>
    <div id="result" class="list-bottom map-result">
       <div class="list-title" style="margin-top:-100px;padding-top:100px;">附近地点</div>
       <div class="list-content" style="height: 100%; overflow: auto;">
        <ul class="area-list">
           <li>
               <span class="li-title">加利大厦写字楼</span>
               <span class="li-area">朝阳区亚运村北苑路108号</span>
           </li>
           <li>
               <span class="li-title">加利大厦写字楼</span>
               <span class="li-area">朝阳区亚运村北苑路108号</span>
           </li>
           <li>
               <span class="li-title">加利大厦写字楼</span>
               <span class="li-area">朝阳区亚运村北苑路108号</span>
           </li>
           <li>
               <span class="li-title">加利大厦写字楼</span>
               <span class="li-area">朝阳区亚运村北苑路108号</span>
           </li>
           <li>
               <span class="li-title">加利大厦写字楼</span>
               <span class="li-area">朝阳区亚运村北苑路108号</span>
           </li>

           <li>
               <span class="li-title">加利大厦写字楼</span>
               <span class="li-area">朝阳区亚运村北苑路108号</span>
           </li>
           <li>
               <span class="li-title">加利大厦写字楼</span>
               <span class="li-area">朝阳区亚运村北苑路108号</span>
           </li>
           <li>
               <span class="li-title">加利大厦写字楼</span>
               <span class="li-area">朝阳区亚运村北苑路108号</span>
           </li>
           <li>
               <span class="li-title">加利大厦写字楼</span>
               <span class="li-area">朝阳区亚运村北苑路108号</span>
           </li>
           <li>
               <span class="li-title">加利大厦写字楼</span>
               <span class="li-area">朝阳区亚运村北苑路108号</span>
           </li>

           <li>
               <span class="li-title">加利大厦写字楼</span>
               <span class="li-area">朝阳区亚运村北苑路108号</span>
           </li>
           <li>
               <span class="li-title">加利大厦写字楼</span>
               <span class="li-area">朝阳区亚运村北苑路108号</span>
           </li>
           <li>
               <span class="li-title">加利大厦写字楼</span>
               <span class="li-area">朝阳区亚运村北苑路108号</span>
           </li>
           <li>
               <span class="li-title">加利大厦写字楼</span>
               <span class="li-area">朝阳区亚运村北苑路108号</span>
           </li>
           <li>
               <span class="li-title">加利大厦写字楼</span>
               <span class="li-area">朝阳区亚运村北苑路108号</span>
           </li>
       </ul>
       </div>
    </div>
<?php $this->beginBlock('js') ?>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=GB9AZpYwfhnkMysnlzwSdRqq"> </script>

<script type="text/javascript">
 $(function(){
     var rdom = $('#result');
     $("#search").focus(function(){
        rdom.addClass('top');
     }).focusout(function(){
        rdom.removeClass('top');
     });

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
       }
     }
    };
    var local = new BMap.LocalSearch(map, options);
    
    local.search("公园");
});
</script>
<?php $this->endBlock() ?>
