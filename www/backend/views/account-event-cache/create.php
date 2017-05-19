<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AccountEventCache */

$this->title = Yii::t('app', 'Create Account Event Cache');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Account Event Caches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-event-cache-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
