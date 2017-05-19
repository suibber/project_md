<?php

namespace backend\controllers;

use Yii;
use common\models\Resume;
use common\models\Freetime;
use common\models\ResumeSearch;
use backend\BBaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * ResumeController implements the CRUD actions for Resume model.
 */
class ResumeController extends BBaseController
{

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'examine' => ['post'],
                ],
            ],
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


    /**
     * Lists all Resume models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ResumeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Resume model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id=null, $user_id=null)
    {
        if ($id) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }

        if ($user_id) {
            return $this->render('view', [
                'model' => Resume::find()->where(['user_id'=>$user_id])->one(),
            ]);
        }
    }

    /**
     * Creates a new Resume model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Resume();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Resume model.
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
     * Deletes an existing Resume model.
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
     * Finds the Resume model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Resume the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Resume::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionFreetimes()
    {
        $user_id = intval(Yii::$app->request->get('user_id'));
        if (!$user_id){
            throw new HttpException(404, '未知的用户信息');
        }
        if (Yii::$app->request->isPost){
            $dayofweek = intval(Yii::$app->request->post('dayofweek'));
            $when = Yii::$app->request->post('when');
            $is_availiable = filter_var(
                Yii::$app->request->post('is_availiable'),
                FILTER_VALIDATE_BOOLEAN);
            if ($this->setFreetime($user_id, $dayofweek, $when, $is_availiable)){
                $this->renderJson([
                    'result'=> true,
                    'is_availiable'=> $is_availiable
                ]);
            } else {
                $this->renderJson([
                    'result'=> false,
                ]);
            }
        }
        $freetimes = Freetime::findAll(['user_id'=>$user_id]);
        $freetimes_dict = [];
        foreach($freetimes as $freetime){
            $freetimes_dict[$freetime->dayofweek] = $freetime;
        }
        return $this->render('freetimes', ['freetimes' => $freetimes_dict]);
    }

    protected function setFreetime($user_id, $dayofweek, $when, $is_availiable)
    {
        $freetime = Freetime::findOne(['user_id'=>$user_id, 'dayofweek'=>$dayofweek]);
        if (!$freetime){
            $freetime = new Freetime();
            $freetime->dayofweek = $dayofweek;
            $freetime->user_id = $user_id;
            $freetime->$when = $is_availiable;
        } else {
            $freetime->$when = $is_availiable;
        }
        if (!$freetime->hasErrors()){
            $freetime->save();
            return true;
        }
        return false;
    }

    public function actionExamine($id, $passed)
    {
        $resume = $this->findModel($id);
        $note = Yii::$app->request->post('note');
        if ($note){
            $resume->exam_note = $note;
        }else{
            $resume->exam_note = NULL;
        }
        $app_pusher = Yii::$app->app_pusher;
        $app_pusher_options = ['url' => 'native://identity/auth'];
        if ($passed){
            $resume->exam_status = Resume::EXAM_DONE;
            $app_pusher->notification($resume->user_id, "恭喜，您的个人认证已通过！\r\n请到\"个人认证\"页面查看详情。", $app_pusher_options);
        } else {
            $resume->exam_status = Resume::EXAM_NOT_PASSED;
            $app_pusher->notification($resume->user_id, "抱歉，您的个人认证未通过！\r\n请到\"个人认证\"页面查看详情。", $app_pusher_options);
        }
        $resume->save();
        return $this->redirect('view?id=' . $id);
    }
}
