<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AppReleaseVersion */

$this->title = 'Update App Release Version: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'App Release Versions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="app-release-version-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
