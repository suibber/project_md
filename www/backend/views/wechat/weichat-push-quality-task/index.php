<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '微信推送-优单';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jz-weichat-push-quality-task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('创建新的优单', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'company_name',
            'task_name',
            [
                'label' => '操作',
                'format' => 'raw',
                'value' => function($model){
                    $hasPushed  = $model->has_pushed ? '已推送' : '未推送';
                    return "<a href='javascript:;' onclick='pushWeichatMsg(".$model->id.")' id='tuisong_".$model->id."'>开始推送 [".$hasPushed ."]</a>";
                }
            ],
            // 'task_type',
            // 'location',
            // 'price',
            // 'created_time',
            // 'updated_time',
            // 'has_pushed',
            [
                'label' => '推送时间',
                'format'=> 'raw',
                'value' => function($model){return $model->pushed_time;}
            ],
            /*
            [
                'label' => '推送分组',
                'format'=> 'raw',
                'value' => function($model){return $model->push_group;}
            ],*/

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

<?php $this->beginBlock('js') ?>
<script type="text/javascript">
  function pushWeichatMsg(msgid){
    var queryUrl    = '/weichat-push-quality-task/pushit?id='+msgid;
    if(confirm('确认开始推送消息？')){
        document.getElementById('tuisong_'+msgid).innerHTML = '开始推送 [已推送]';
        $(document).load(queryUrl);
    }else{
        alert(queryUrl);
    }
  }
</script>
<?php $this->endBlock('js') ?>
