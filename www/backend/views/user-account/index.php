<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\UserAccount;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '用户资金');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-account-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--p>
        <?= Html::a(Yii::t('app', 'Create User Account'), ['create'], ['class' => 'btn btn-success']) ?>
    </p-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'user_id',
            [
                'label' => '姓名',
                'value' => function($model){
                    return isset($model->userinfo->name) ? $model->userinfo->name : '';
                }
            ],
            [
                'label' => '手机',
                'value' => function($model){
                    return isset($model->userinfo->phonenum) ? $model->userinfo->phonenum : '';
                }
            ],
            //'defalut_withdraw_type',
            [
                'label' => '默认提现方式',
                'attribute' => 'defalut_withdraw_type',
                'filter'=> UserAccount::$DEFAULT_WITHDRAW_TYPES,
                'value' => function($model){
                    return $model->defalutwithdrawtype_label;
                }
            ],
            'money_all',
            'money_balance',
            // 'money_success',
            // 'money_doing',
            // 'updated_time',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
