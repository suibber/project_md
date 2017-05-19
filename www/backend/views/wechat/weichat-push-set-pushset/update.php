<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\JzWeichatPushSetPushset */

$this->title = '微信推送-附近-编辑';
$this->params['breadcrumbs'][] = ['label' => 'Jz Weichat Push Set Pushsets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jz-weichat-push-set-pushset-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'ops' => $ops,
    ]) ?>

</div>
