<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\WeichatAutoresponse;

/* @var $this yii\web\View */
/* @var $searchModel common\models\WeichatAutoresponseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '微信自动回复';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weichat-autoresponse-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新建自动回复', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'type',
            [
                'label' => '类型',
                'format'=> 'raw',
                'attribute'=>'type',
                'filter'    => WeichatAutoresponse::$TYPE,
                'value' => function($model){
                    return $model->type_label;
                },
            ],
            [
                'label' => '状态',
                'format'=> 'raw',
                'attribute'=> 'status',
                'filter'    => WeichatAutoresponse::$STATUS,
                'value' => function($model){
                    return $model->status_label;
                },
            ],
            //'status',
            'keywords',
            'response_msg',
            // 'created_time',
            // 'updated_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
