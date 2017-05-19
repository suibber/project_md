<?php

namespace console\jobs;

use Yii;
use console\BaseJob;

class CloudStorageJob extends BaseJob
{

    public function actionSyncFile($model, $column, $pk)
    {
        $obj = $model::findOne($pk);
        if (!$obj){
            return false;
        }
        $path = Yii::getAlias('@media/' . $obj->{$column});
        $http_path = Yii::$app->cloud_storage->uploadFile($path, 'media/' . $obj->{$column});
        $obj->$column = $http_path;
        return $obj->save();
    }
}
