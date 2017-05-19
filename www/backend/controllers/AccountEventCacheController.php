<?php

namespace backend\controllers;

use Yii;
use common\models\AccountEventCache;
use common\models\AccountEventCacheSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\BBaseController;

/**
 * AccountEventCacheController implements the CRUD actions for AccountEventCache model.
 */
class AccountEventCacheController extends BBaseController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['finance_manager'],
                    ],

                ],
            ],
        ]);
 
    }

    /**
     * Lists all AccountEventCache models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccountEventCacheSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $money_all  = AccountEventCache::find()->sum('value');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'money_all' => $money_all,
        ]);
    }

    /**
     * Displays a single AccountEventCache model.
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
     * Creates a new AccountEventCache model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AccountEventCache();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AccountEventCache model.
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
     * Deletes an existing AccountEventCache model.
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
     * Finds the AccountEventCache model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AccountEventCache the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AccountEventCache::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpload(){
        if( Yii::$app->request->isPost && $_FILES['excelfile']['error'] == 0 && $_FILES['excelfile']['size'] > 0 ){
            $excel_path  = $_FILES['excelfile']['tmp_name'];
            $excel_data  = Yii::$app->office_phpexcel->excelToArray($excel_path);
            
            $accountevent      = new AccountEventCache();
            $import_data       = $accountevent->saveUploadData($excel_data);
            if( $import_data ){
                //$this->layout=false;
                return $this->render('upload', [
                    'import_data' => $import_data,
                ]);
            }else{
                echo '{"result"="false","errmsg"="上传错误"}';
            }
        }else{
            $excel_data = '';
            //$this->layout=false;
            return $this->render('upload', [
                'excel_data' => $excel_data,
            ]);
        }
    }

    public function actionDownloaddemo(){
        $row_array  = [
            'A1'=>'日期',
            'B1'=>'职位id',
            'C1'=>'姓名',
            'D1'=>'手机号',
            'E1'=>'金额',
            'F1'=>'金额说明',
            'A2'=>'日期：2015-06-23',
            'B2'=>"'14374778022702043",
            'C2'=>'张三',
            'D2'=>'18611299991',
            'E2'=>'5000',
            'F2'=>'日结工资',
        ];
        Yii::$app->office_phpexcel->arrayToExcel($row_array);
    }

    public function actionPayoff(){
        $account_envents= AccountEventCache::find()->with('userinfo')->asArray()->all();
        $accountevent   = new AccountEventCache();
        $errmsg         = $accountevent->saveDataToAccountEvent($account_envents);
        if( $errmsg ){
            echo $errmsg;
        }else{
            return $this->redirect(['index']);
        }
    }
}
