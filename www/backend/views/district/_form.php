<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\District */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="district-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'pinyin')->textInput() ?>

    <?= $form->field($model, 'short_pinyin')->textInput() ?>

    <?= $form->field($model, 'is_hot')->DropDownList(['0' => '否', '1' => '是']) ?>

    <?= $form->field($model, 'is_alive')->DropDownList(['0' => '否', '1' => '是']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php if(!$model->isNewRecord){ ?>
    <p> 旗下的区域 </p>
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
    <?php } ?>


</div>
