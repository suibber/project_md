<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '推送模板';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jz-weichat-push-set-template-push-list-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('创建推送模板', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'label' => '模板名称',
                'format' => 'raw',
                'value' => function($model){
                    //var_dump($model);die();
                    return "<a href='/weichat-push-set-template-push-item?template_push_id=" . $model->id ."'>".$model->id . '--' . $model->title . "</a>";
                }
            ],
            'created_time', 
            //'status',
            // 'create_user',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
