<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ConfigBanner */

$this->title = Yii::t('app', '创建广告位');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Config Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-banner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
