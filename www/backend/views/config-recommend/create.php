<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ConfigRecommend */

$this->title = '创建推荐兼职';
$this->params['breadcrumbs'][] = ['label' => 'Config Recommends', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-recommend-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
