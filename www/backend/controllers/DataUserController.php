<?php

namespace backend\controllers;

use Yii;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\BDataBaseController;
use common\models\DataDaily;

/**
 * DataUserController implements the CRUD actions for DataDaily model.
 */
class DataUserController extends BDataBaseController
{

    public function behaviors()
    {
        $bhvs = parent::behaviors();
        return $bhvs;
    }

    /**
     * Lists all DataDaily models.
     * @return mixed
     */
    public function actionIndex()
    {
        // 默认时间范围
        $defaultDateStart   = date("Y-m-d",time()-7*24*60*60);
        $defaultDateEnd     = date("Y-m-d",time());

        // 快速筛选连接,昨天，七天，三十天
        $ztDateStart        = date("Y-m-d",time()-1*24*60*60);
        $ztDateEnd          = date("Y-m-d",time()-1*24*60*60);      
        $sstDateStart       = date("Y-m-d",time()-30*24*60*60);
        $sstDateEnd         = $defaultDateEnd;
        $ztUrl              = "&dateStart=".$ztDateStart."&dateEnd=".$ztDateEnd;
        $qtUrl              = "&dateStart=".$defaultDateStart."&dateEnd=".$defaultDateEnd;
        $sstUrl             = "&dateStart=".$sstDateStart."&dateEnd=".$sstDateEnd;

        // 得到选择的日期
        $dateStart  = Yii::$app->request->get('dateStart') ? Yii::$app->request->get('dateStart') : $defaultDateStart;
        $dateEnd    = Yii::$app->request->get('dateEnd') ? Yii::$app->request->get('dateEnd') : $defaultDateEnd;

        // 数据类型
        $data_type  = Yii::$app->request->get('type_id') ? Yii::$app->request->get('type_id') : 1;
        // 城市
        $city_id    = Yii::$app->request->get('city_id') ? Yii::$app->request->get('city_id') : 0;

        // 统计数据的列项 注册总量、简历总量
        $dataRows   = '';
        if( $data_type == 3 ){
            $labels     = array('zgz','jrgz','ztd','jrtd','jrtsrs','jrtszl','jrwxzc','jrwxtdrs','jrwxtdzl');
            $dataRows   = $this->getDataRows($data_type,$city_id,$dateStart,$dateEnd,$labels);
        }elseif( $data_type == 2 ){
            $labels     = array('ztl','zzxtl','htxz','zqxz','yhxz','zdsh','zgq','jrgq');
            $dataRows   = $this->getDataRows($data_type,$city_id,$dateStart,$dateEnd,$labels);
        }elseif( $data_type == 1 ){
            $labels     = array('zczl','jlzl','tdzl','tdrs','jrzczl','jrjlzl','jrtdzl','jrtdrs','jrxyhtd');
            $dataRows   = $this->getDataRows($data_type,$city_id,$dateStart,$dateEnd,$labels);
        }elseif( $data_type == 4 ){
            $labels     = array('bs','rs','dds','jrqs','zqs');
            $dataRows   = $this->getDataRows($data_type,$city_id,$dateStart,$dateEnd,$labels);
        }elseif( $data_type == 5 ){
            $labels     = array('bs','rs','jrqs','zqs');
            $dataRows   = $this->getDataRows($data_type,$city_id,$dateStart,$dateEnd,$labels);
        }

        // 渲染
        return $this->render('index',[
            'data_type' => $data_type,
            'dataRows'  => $dataRows,    
            'dateStart' => $dateStart,
            'dateEnd'   => $dateEnd,
            'ztUrl'     => $ztUrl,
            'qtUrl'     => $qtUrl,
            'sstUrl'    => $sstUrl,
            'data_type' => $data_type,
            'city_id'   => $city_id,
        ]);
    }

    /**
     * Displays a single DataDaily model.
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
     * Creates a new DataDaily model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DataDaily();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DataDaily model.
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

    // 清空缓存
    public function actionClearup(){
        DataDaily::deleteAll();
        $this->redirect('/data-user');
    }

    /**
     * Deletes an existing DataDaily model.
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
     * Finds the DataDaily model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DataDaily the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DataDaily::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
