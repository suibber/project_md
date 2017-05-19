<?php
namespace common;

use common\models\JobQueue;

class JobUtils
{

    /*
     *
     *  $model  需要上传文件的对象
     *  $column 文件的字段名
     *
     */
    public static function addSyncFileJob($model, $column)
    {
        $params = [
            'model' => $model->className(),
            'column' => $column,
            'pk' => $model->getPrimaryKey(),
        ];
        $job = new JobQueue;
        $job->task_name = 'cloud-storage/sync-file';
        $job->setParams($params);
        $job->save();
    }

}
