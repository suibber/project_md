<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TaskApplicantOnlinejob */

$this->title = Yii::t('app', 'Create Task Applicant Onlinejob');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Task Applicant Onlinejobs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-applicant-onlinejob-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
