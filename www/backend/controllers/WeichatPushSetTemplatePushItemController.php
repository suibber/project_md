<?php

namespace backend\controllers;

use Yii;
use common\models\WeichatPushSetTemplatePushItem;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\BBaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WeichatPushSetTemplatePushItemController implements the CRUD actions for WeichatPushSetTemplatePushItem model.
 */
class WeichatPushSetTemplatePushItemController extends BBaseController
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
        return Yii::getAlias('@backend/views/wechat/weichat-push-set-template-push-item');
    }

    /**
     * Lists all WeichatPushSetTemplatePushItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        // 获得所属模板ID
        $template_push_id   = is_numeric(Yii::$app->request->get('template_push_id')) ? Yii::$app->request->get('template_push_id') : 0;

        $dataProvider = new ActiveDataProvider([
            'query' => WeichatPushSetTemplatePushItem::find()->where(['template_push_id'=>$template_push_id]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'template_push_id' => $template_push_id,
        ]);
    }

    /**
     * Displays a single WeichatPushSetTemplatePushItem model.
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
     * Creates a new WeichatPushSetTemplatePushItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        // 获得所属模板ID
        $template_push_id   = is_numeric(Yii::$app->request->get('template_push_id')) ? Yii::$app->request->get('template_push_id') : 0;
        
        $model = new WeichatPushSetTemplatePushItem();

        // 设置默认属性
        $model->template_push_id    = $template_push_id;
        $model->display_order       = 1;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WeichatPushSetTemplatePushItem model.
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
     * Deletes an existing WeichatPushSetTemplatePushItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        // 删除跳转回列表
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * Finds the WeichatPushSetTemplatePushItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WeichatPushSetTemplatePushItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WeichatPushSetTemplatePushItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
