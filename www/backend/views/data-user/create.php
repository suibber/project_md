<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DataDaily */

$this->title = 'Create Data Daily';
$this->params['breadcrumbs'][] = ['label' => 'Data Dailies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-daily-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
