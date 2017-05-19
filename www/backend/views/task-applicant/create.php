<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TaskApplicant */

$this->title = 'Create Task Applicant';
$this->params['breadcrumbs'][] = ['label' => 'Task Applicants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-applicant-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
