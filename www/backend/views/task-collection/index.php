<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskCollectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Task Collections';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-collection-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Task Collection', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'created_time',
            'user_id',
            'task_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
