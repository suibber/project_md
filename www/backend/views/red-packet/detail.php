<?php

use yii\helpers\Html;
use yii\grid\GridView;

use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ResumeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '微信红包';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resume-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            //'name',
            'username',
            'red_packet_num',
            [
                'label' => '已提现/总红包金额',
                'value' => function($model){
                    $money_all = 0;
                    $money_withdraw = 0;
                    foreach( $model->invite_account as $withdraw ){
                        if( $withdraw->related_id > 0 ){
                            $money_withdraw += $withdraw->value;
                        }
                        $money_all += $withdraw->value;
                    }
                    return $money_withdraw.'/'.$money_all;
                }
            ],
            [
                'label' => '城市',
                'attribute' => 'red_packet_city',
                'filter' => User::getCityList(),
                'value' => function($model){
                    $city_list = $model::getCityList();
                    $city_id = isset($model->red_packet_city) ? $model->red_packet_city : 0;
                    return $city_list[$city_id];
                }
            ],
            [
                'label' => '操作',
                'format' => 'raw',
                'value' => function($model){
                    $city_list = $model::getCityList();
                    $city_id = isset($model->red_packet_city) ? $model->red_packet_city : 0;
                    return "<a href='/red-packet/detail?invited_by=".$model->id."' target='_blank'>邀请列表(".$model->red_packet_num.")</a>";
                }
            ],
            // 邀请数量
            // 已提现
            // 注册城市
            // 操作

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
