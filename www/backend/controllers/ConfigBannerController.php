<?php

namespace backend\controllers;

use Yii;
use common\models\ConfigBanner;
use common\models\ConfigBannerSearch;
use common\JobUtils;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\Utils;

/**
 * ConfigBannerController implements the CRUD actions for ConfigBanner model.
 */
class ConfigBannerController extends Controller
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
     * Lists all ConfigBanner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConfigBannerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ConfigBanner model.
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
     * Creates a new ConfigBanner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ConfigBanner();
        $data  = Yii::$app->request->post();
        
        if( Yii::$app->request->isPost ){
            $data['ConfigBanner']['offline_date'] = $data['ConfigBanner']['offline_date'] ? $data['ConfigBanner']['offline_date'] : '2115-01-01';
            if( $_FILES['ConfigBanner']['size']['pic'] > 0 ){
                $files  = [];
                foreach( $_FILES['ConfigBanner'] as $k => $v ){
                    $files[$k]  = $v['pic'];
                }
                $filename = Utils::saveUploadFile($files);
                $data['ConfigBanner']['pic'] = $filename;
            }
        }

        if ($model->load($data) && $model->save()) {
            JobUtils::addSyncFileJob($model, 'pic');
            return $this->redirect(['index?sort=-id']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ConfigBanner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $data  = Yii::$app->request->post();
        if( Yii::$app->request->isPost ){
            if( $_FILES['ConfigBanner']['size']['pic'] > 0 ){
                $files  = [];
                foreach( $_FILES['ConfigBanner'] as $k => $v ){
                    $files[$k]  = $v['pic'];
                }
                $filename = Utils::saveUploadFile($files);
                $data['ConfigBanner']['pic'] = $filename;
            }else{
                $data['ConfigBanner']['pic'] = $model->pic;
            }
        }

        if ($model->load($data) && $model->save()) {
            return $this->redirect(['index?sort=-id']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ConfigBanner model.
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
     * Finds the ConfigBanner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ConfigBanner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ConfigBanner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
