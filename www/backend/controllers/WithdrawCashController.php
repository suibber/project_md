<?php

namespace backend\controllers;

use Yii;
use common\models\WithdrawCash;
use common\models\WithdrawCashSearch;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\BBaseController;

/**
 * WithdrawCashController implements the CRUD actions for WithdrawCash model.
 */
class WithdrawCashController extends BBaseController
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
     * Lists all WithdrawCash models.
     * @return mixed
     */
    public function actionIndex($action='')
    {
        $searchModel = new WithdrawCashSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $money_all_success  = WithdrawCash::find()->where(['status'=>3])->sum('value');

        if( $action == 'download' ){
            $this->downloadExcel(Yii::$app->request->queryParams);
        }else{
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'money_all_success' => $money_all_success,
            ]);
        }
    }

    /**
     * Displays a single WithdrawCash model.
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
     * Creates a new WithdrawCash model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WithdrawCash();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WithdrawCash model.
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
     * Deletes an existing WithdrawCash model.
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
     * Finds the WithdrawCash model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WithdrawCash the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WithdrawCash::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function downloadExcel($param){
        $name       = '提现导出（'.date("Y-m-d H-i-s").'）';
        $excel_arr  = ['A1'=>'hh'];

        if( isset($param['WithdrawCashSearch']['id']) ){
            $data   = WithdrawCash::find()
                ->andFilterWhere([
                    '`jz_withdraw_cash`.id' => $param['WithdrawCashSearch']['id'],
                    '`jz_withdraw_cash`.user_id' => $param['WithdrawCashSearch']['user_id'],
                    '`jz_withdraw_cash`.value' => $param['WithdrawCashSearch']['value'],
                    '`jz_withdraw_cash`.withdraw_time' => $param['WithdrawCashSearch']['withdraw_time'],
                    '`jz_withdraw_cash`.`status`' => $param['WithdrawCashSearch']['status'],
                    '`jz_withdraw_cash`.updated_time' => $param['WithdrawCashSearch']['updated_time'],
                ])
                ->joinWith('payout')
                ->joinWith('userinfo')
                ->joinWith('operatorinfo') 
                ->all();
        }else{
           $data   = WithdrawCash::find()
                ->joinWith('payout')
                ->joinWith('userinfo')
                ->joinWith('operatorinfo') 
                ->all(); 
        }

        $withdraw_cash  = new WithdrawCash();
        $excel_arr = $withdraw_cash->makeExcelArr($data);

        Yii::$app->office_phpexcel->arrayToExcel($excel_arr,$name);
    }
}
