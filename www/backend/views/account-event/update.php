<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AccountEvent */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Account Event',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Account Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="account-event-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
