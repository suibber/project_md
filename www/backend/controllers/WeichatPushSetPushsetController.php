<?php

namespace backend\controllers;

use Yii;
use common\models\WeichatPushSetPushset;
use common\models\WeichatPushSetTemplatePushList;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use backend\BBaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WeichatPushSetPushsetController implements the CRUD actions for WeichatPushSetPushset model.
 */
class WeichatPushSetPushsetController extends BBaseController
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
        return Yii::getAlias('@backend/views/wechat/weichat-push-set-pushset');
    }

    /**
     * Lists all WeichatPushSetPushset models.
     * @return mixed
     */
    public function actionIndex()
    {
        $ops    = $this->getOps();
        
        $dataProvider = new ActiveDataProvider([
            'query' => WeichatPushSetPushset::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'ops'          => $ops,
        ]);
    }

    /**
     * Displays a single WeichatPushSetPushset model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $ops    = $this->getOps();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'ops'   => $ops,
        ]);
    }

    /**
     * Creates a new WeichatPushSetPushset model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model  = new WeichatPushSetPushset();

        // 选项信息
        $ops    = $this->getOps();

        $time_date  = date("Y-m-d H:i:s",time());
        $model->created_time    = $time_date;
        $model->update_time     = $time_date;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'ops' => $ops,
            ]);
        }
    }

    /**
     * Updates an existing WeichatPushSetPushset model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // 选项信息
        $ops    = $this->getOps();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'ops'   => $ops,
            ]);
        }
    }

    /**
     * Deletes an existing WeichatPushSetPushset model.
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
     * Finds the WeichatPushSetPushset model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WeichatPushSetPushset the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WeichatPushSetPushset::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    // 得到编辑修改的选项
    public static function getOps(){
        // 可用模板
        $tempAll  = WeichatPushSetTemplatePushList::find()->where(['status'=>1])->asArray()->all();
        $tempArr  = array();
        foreach( $tempAll as $key => $value ){
            $tempArr[$value['id']]  = $value['id'].'--'.$value['title'];
        }

        // 选项信息
        $ops    = array(
            'pushtime'   => Yii::$app->params['weichat']['pushset']['pushtime'],
            'pushtype'   => Yii::$app->params['weichat']['pushset']['pushtype'],
            'status'     => Yii::$app->params['weichat']['pushset']['status'],
            'tmp_weichat'=> Yii::$app->params['weichat']['pushset']['tmp_weichat'],
            'tmp_list'   => $tempArr,
        );

        return $ops;
    }
}
