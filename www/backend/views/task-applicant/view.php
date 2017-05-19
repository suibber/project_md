<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TaskApplicant */

$this->title = $model->resume->name . ' -> ' . $model->task->title;
$this->params['breadcrumbs'][] = ['label' => 'Task Applicants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-applicant-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'task.title',
            'resume.name',
            'created_time',
            'resume.name',
            'company_alerted:boolean',
            'applicant_alerted:boolean',
            'status_label',
        ],
    ]) ?>

</div>
