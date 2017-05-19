<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TaskPoolWhiteListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Task Pool White Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-pool-white-list-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Task Pool White List', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'origin',
            'attr',
            'value',
            // 'examined_by',
            'type_label',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
