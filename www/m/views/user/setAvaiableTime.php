<?php
/* @var $this yii\web\View */
$this->title = '空闲时间';
?>
<div class="row">
    <div class="col-lg-8">
      <table class="table table-bordered">
      <thead>
       <tr>
          <th>#</th>
          <th>上午</th>
          <th>中午</th>
          <th>下午</th>
        </tr>
      </thead>
      <tbody>
<?php
foreach(['一', '二', '三', '四', '五', '六', '日'] as $v){
    echo '
        <tr>
        <th scope="row">周<? =$v ?></th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
        </tr>
        ';
}
?>
      </tbody>
    </table>
    </div>
</div>
