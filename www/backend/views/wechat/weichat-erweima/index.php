<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\WeichatErweimaLog;

/* @var $this yii\web\View */
/* @var $searchModel common\models\WeichatErweimaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '微信二维码';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weichat-erweima-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建二维码', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'title',
            //'comment',
            //'type',
            [
                'label' => '二维码类型',
                'format'=> 'raw',
                'value' => function($model){
                    return ($model->type == 1) ? '一周有效' : '永久有效';
                }
            ],
            'create_time',
            // 'update_time',
            // 'scene_id',
            [
                'label' => '操作',
                'format'=> 'raw',
                'value' => function($model){
                    return '<a href="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$model->ticket.'" target="_blank" >看二维码</a> | <a href="/weichat-erweima-log?id='.$model->id.'" target="_blank" >查看数据</a> | <a href="'.Yii::$app->params['baseurl.m'].'/weichat-erweima-log?id='.$model->id.'&sc='.$model->scene_id.'&sort=-create_time" target="_blank" >数据链接</a>';
                }
            ],
            [
                'label' => '扫描次数',
                'format'=> 'raw',
                'value' => function($model){
                    return $model->scan_num;
                },
                'attribute'=>'scan_num',
            ],
            // 'ticket',
            // 'after_msg',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
