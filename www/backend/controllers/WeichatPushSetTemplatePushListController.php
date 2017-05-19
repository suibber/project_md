<?php

namespace backend\controllers;

use Yii;
use common\models\WeichatPushSetTemplatePushList;
use yii\data\ActiveDataProvider;
use backend\BBaseController;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WeichatPushSetTemplatePushListController implements the CRUD actions for WeichatPushSetTemplatePushList model.
 */
class WeichatPushSetTemplatePushListController extends BBaseController
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
        return Yii::getAlias('@backend/views/wechat/weichat-push-set-template-push-list');
    }

    /**
     * Lists all WeichatPushSetTemplatePushList models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => WeichatPushSetTemplatePushList::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WeichatPushSetTemplatePushList model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new WeichatPushSetTemplatePushList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WeichatPushSetTemplatePushList();

        $date_tiem              = date("Y-m-d H:i:s",time());
        $model->created_time    = $date_tiem;
        $model->updated_time    = $date_tiem;
        $model->status          = 1;
        $model->create_user     = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WeichatPushSetTemplatePushList model.
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
     * Deletes an existing WeichatPushSetTemplatePushList model.
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
     * Finds the WeichatPushSetTemplatePushList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WeichatPushSetTemplatePushList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WeichatPushSetTemplatePushList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
