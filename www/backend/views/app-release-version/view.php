<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AppReleaseVersion */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'App Release Versions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-release-version-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'device_type',
            'app_version',
            'html_version',
            'update_url:url',
            'release_time',
            'h5_map_file',
            'features:html',
        ],
    ]) ?>

</div>
