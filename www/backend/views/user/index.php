<?php

use yii\helpers\Html;
use yii\grid\GridView;

use common\models\User;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '账号';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建用户', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'id',
            'username',
            'name',
            ['attribute' => 'roles', 'value'=>function($model){
                $roles = '';
                foreach (\Yii::$app->authManager->getRolesByUser($model->id) as $role){
                    $roles .= ' ' . $role->name;
                }
                return $roles;
            }, 'label'=> '角色' ],
            'invited_by',
            'created_time:date',
            ['attribute' => 'status', 'value'=>function($model){
                return User::$STATUSES[$model->status];
                },
                'filter'=>User::$STATUSES
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
