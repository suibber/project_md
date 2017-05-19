<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AppReleaseVersion */

$this->title = 'Create App Release Version';
$this->params['breadcrumbs'][] = ['label' => 'App Release Versions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-release-version-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
