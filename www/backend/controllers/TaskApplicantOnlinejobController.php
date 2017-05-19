<?php

namespace backend\controllers;

use Yii;
use common\models\TaskApplicantOnlinejob;
use common\models\TaskApplicantOnlinejobSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\TaskOnlinejobNeedinfo;
use common\WeichatBase;
use common\models\AccountEvent;

/**
 * TaskApplicantOnlinejobController implements the CRUD actions for TaskApplicantOnlinejob model.
 */
class TaskApplicantOnlinejobController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all TaskApplicantOnlinejob models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskApplicantOnlinejobSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TaskApplicantOnlinejob model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $needinfos = TaskOnlinejobNeedinfo::findAll(['task_id'=>$model->task_id]);
        return $this->render('view', [
            'model' => $model,
            'needinfos' => $needinfos,
        ]);
    }

    /**
     * Creates a new TaskApplicantOnlinejob model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TaskApplicantOnlinejob();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TaskApplicantOnlinejob model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TaskApplicantOnlinejob model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TaskApplicantOnlinejob model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaskApplicantOnlinejob the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaskApplicantOnlinejob::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExamine($id, $passed)
    {
        $app_onlinejob_obj = TaskApplicantOnlinejob::find()->where(['id' => $id])
            ->with('task')
            ->one();
        $note = Yii::$app->request->post('note');
        if ($note){
            $app_onlinejob_obj->reason = $note;
        }else{
            $app_onlinejob_obj->reason = NULL;
        }
        if ($passed){
            $app_onlinejob_obj->status = TaskApplicantOnlinejob::STATUS_PASSED;
            $this->payoffMoney($app_onlinejob_obj);
        } else {
            $app_onlinejob_obj->status = TaskApplicantOnlinejob::STATUS_NOT_PASSED;
        }
        $app_onlinejob_obj->save();
        return $this->redirect('view?id=' . $id);
    }

    private function payoffMoney($app_onlinejob_obj){
        $data = [
            'date'      => date("Y-m-d"),
            'user_id'   => $app_onlinejob_obj->user_id,
            'value'     => $app_onlinejob_obj->task->salary,
            'note'      => "任务‘".$app_onlinejob_obj->task->title."’通过审核！",
            'operator_id'  => Yii::$app->user->id,
            'created_time' => date("Y-m-d H:i:s"),
            'red_packet_accept_by' => '',
            'type'      => AccountEvent::TYPES_ONLINEJOB,
        ];
        $weichat_base = new WeichatBase();
        $weichat_base->putMoneyToAccount($data);    
    }
}
