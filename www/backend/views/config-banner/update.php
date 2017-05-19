<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ConfigBanner */

$this->title = Yii::t('app', '更新城市广告位: ', [
    'modelClass' => 'Config Banner',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Config Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="config-banner-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
