<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WeichatErweima */

$this->title = '创建微信二维码';
$this->params['breadcrumbs'][] = ['label' => 'Weichat Erweimas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weichat-erweima-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
