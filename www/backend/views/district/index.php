<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DistrictSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Districts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="district-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create District', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'short_name:ntext',
            [
                'attribute' => 'level',
                'filter' => [
                    'province'=> '省',
                    'city'=> '市',
                    'district'=> '县/区',
                ],
            ],
            'pinyin:ntext',
            [
                'attribute' => 'is_hot',
                'format' => 'boolean',
                'filter' => [
                    1 => '是',
                    0 => '否',
                ],
            ],
            [
                'attribute' => 'is_alive',
                'format' => 'boolean',
                'filter' => [
                    1 => '是',
                    0 => '否',
                ],
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
