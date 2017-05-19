<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\WeichatUserInfo;

/* @var $this yii\web\View */
/* @var $searchModel common\models\WeichatUserInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '微信绑定用户');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weichat-user-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--p>
        <?= Html::a(Yii::t('app', 'Create Weichat User Info'), ['create'], ['class' => 'btn btn-success']) ?>
    </p-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'openid',
            'userid',
            //'status',
            'created_time',
            [
                'label' => '是否接受微信推送',
                'attribute' => 'is_receive_nearby_msg',
                'filter' => WeichatUserInfo::$IS_RECEIVE_NEARBY_MSG,
                'format'=> 'raw',
                'value' => function($model){
                    if( $model->is_receive_nearby_msg == 1 ){
                        return '是';
                    }else{
                        return '否';
                    } 
                }
            ],
            // 'updated_time',
            // 'weichat_name',
            // 'weichat_head_pic',
            // 'is_receive_nearby_msg',
            // 'origin_type',
            // 'origin_detail',
            // 'erweima_ticket',
            // 'erweima_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
