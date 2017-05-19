<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>

        <?= Html::a('编辑地址', ['edit-address', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'origin',
            'title',
            'user_id',
            'contact',
            'contact_phonenum',
            'clearance_period_label',
            'salary',
            'salary_unit_label',
            'salary_note:ntext',
            'from_date',
            'to_date',
            'from_time',
            'to_time',
            'need_quantity',
            'got_quantity',
            'created_time',
            'updated_time',
            'detail:html',
            'requirement:ntext',
            'service_type.name',
/**
            'gender_requirement',
            'degree_requirement',
            'age_requirement',
            'height_requirement',
**/
            'status',

            'company.name',
            'address',
            'city_id',
        ],
    ]) ?>

</div>
