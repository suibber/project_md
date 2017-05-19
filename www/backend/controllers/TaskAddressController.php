<?php

namespace backend\controllers;

use Yii;
use common\models\Task;
use common\models\TaskAddress;
use backend\BBaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * TaskAddressController implements the CRUD actions for Address model.
 */
class TaskAddressController extends BBaseController
{

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['operation_manager'],
                    ],
                ],
            ],
        ]);
    }

    public function actionCreate($task_id)
    {
        $model = new TaskAddress();
        $task = Task::findOne($task_id);
        if ($task){
            $model->user_id = $task->user_id;
            $model->task_id = $task_id;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->renderJson([
                    'success'=> true,
                    'msg'=> '创建成功',
                    'result'=> $model->toArray()
                ]);
            }
        }
        return $this->renderJson([
            'success'=> false,
            'msg'=> '创建失败',
            'errors'=> $model->getErrors(),
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->renderJson([
            'success'=> true,
            'msg'=> '删除成功',
        ]);

    }

    protected function findModel($id)
    {
        if (($model = TaskAddress::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
