<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

use common\models\Company;
use common\models\Task;
use backend\models\TaskPool;
use backend\models\TaskPoolWhiteList;
use backend\models\TaskPoolSearch;
use backend\BBaseController;

/**
 * TaskPoolController implements the CRUD actions for TaskPool model.
 */
class TaskPoolController extends BBaseController
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
    public function getViewPath()
    {
        return Yii::getAlias('@backend/views/spider/task-pool');
    }

    /**
     * Lists all TaskPool models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskPoolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TaskPool model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionTransfer($id=null, $company_name=null, $origin=null)
    {
        if ($company_name && $origin){
            $w = TaskPoolWhiteList::find()->where(
                ['attr'=> 'company_name', 'value'=>$company_name, 'origin'=> $origin]
            )->one();
            if (!$w){
                $w = new TaskPoolWhiteList;
            }
            $w->origin = $origin;
            $w->attr = 'company_name';
            $w->value = $company_name;
            $w->is_white = true;
            $w->examined_by = Yii::$app->user->id;
            $w->save();
            $tasks = $w->examineTaskPool();
            $company = Company::find()->where(['name'=> $company_name])->one();
            $all_tasks = Task::find()->where([
                'company_id'=>$company->id,
            ])->all();
            return $this->render('transfer-company', [
                'all_tasks'=> $all_tasks,
                'company'=> $company,
                'count'=> count($tasks),
            ]);
        }
        elseif ($id){
            $t = TaskPool::findOne($id);
            if ($t->status!=0){
                $this->redirectHtml(Yii::$app->request->referrer, '该任务已经处理过，无法继续处理!');
            }
            $task = $t->exportTask($self_update=true);
            if (!$task){
                return $this->redirectHtml(Yii::$app->request->referrer, '导出出现问题，无法继续处理, 联系技术!');
            }
            return $this->redirect('/task/update?id='.$task->id);
        }
    }



    /**
     * Creates a new TaskPool model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TaskPool();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TaskPool model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id=null, $company_name=null, $origin=null)
    {
        if ($id){
            $model = $this->findModel($id);
            if ($model && $model->status==0){
                $model->status = 11;
                $model->save();
            } else {
                $this->redirectHtml(Yii::$app->request->referrer, '该任务不存在或已经处理过!');
            }
            return $this->redirect(Yii::$app->request->referrer);
        } elseif ($company_name && $origin) {
            $w = TaskPoolWhiteList::find()->where(
                ['attr'=> 'company_name', 'value'=>$company_name, 'origin'=> $origin]
            )->one();
            if (!$w){
                $w = new TaskPoolWhiteList;
            }
            $w->attr = 'company_name';
            $w->value = $company_name;
            $w->origin = $origin;
            $w->is_white = false;
            $w->examined_by = Yii::$app->user->id;
            $w->save();
            $w->examineTaskPool();

            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    /**
     * Finds the TaskPool model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaskPool the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaskPool::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
