<?php

namespace m\controllers;

use Yii;
use common\models\WeichatErweimaLog;
use common\models\WeichatErweimaLogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\WeichatErweima;
use yii\web\HttpException;
use common\models\WeichatUserInfo;

/**
 * WeichatErweimaLogController implements the CRUD actions for WeichatErweimaLog model.
 */
class WeichatErweimaLogController extends Controller
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
     * Lists all WeichatErweimaLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        // 验证传入参数
        $erweima_id = Yii::$app->request->get('id') ? Yii::$app->request->get('id') : 0;
        $erweima_scene_id = Yii::$app->request->get('sc') ? Yii::$app->request->get('sc') : 0;
        $erweima_m  = WeichatErweima::find()
            ->where(['id'=>$erweima_id,'scene_id'=>$erweima_scene_id])
            ->one();
        if( !$erweima_m ){
            throw new HttpException(404, '没有找到对应的二维码');
        }

        $searchModel = new WeichatErweimaLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$erweima_id);

        $date   = isset(Yii::$app->request->get()['WeichatErweimaLogSearch']['create_time']) ? Yii::$app->request->get()['WeichatErweimaLogSearch']['create_time'] : 0;
        $where_date = $date ? " AND l.`create_time` LIKE '$date%' " : '';
        
        $scan_count = WeichatErweimaLog::find()->where(['erweima_id'=>$erweima_id])
            ->andWhere(['like', 'create_time', $date])->count();
        WeichatErweima::updateAll(['scan_num'=>$scan_count],['id'=>$erweima_id]);

        $scanuser_count = WeichatErweimaLog::findBySql("
            SELECT COUNT(DISTINCT(openid)) scanuser_count
            FROM jz_weichat_erweima_log l 
            WHERE l.erweima_id=".$erweima_id."
            ".$where_date."
        ")->asArray()->all();
        $scanuser_count = $scanuser_count[0]['scanuser_count'] ? $scanuser_count[0]['scanuser_count'] : 0;
        
	    $user_count = WeichatUserInfo::findBySql("
            SELECT COUNT(distinct(l.openid)) user_count
            FROM jz_weichat_user_info w
            LEFT JOIN jz_weichat_erweima_log l ON w.openid=l.openid
            WHERE l.follow_by_scan=1
            AND l.erweima_id=".$erweima_id." 
            ".$where_date."
        ")->asArray()->all();
        $user_count = count($user_count) ? $user_count[0]['user_count'] : 0;

        $resume_count = WeichatUserInfo::findBySql("
            SELECT COUNT(distinct(l.openid)) user_count
            FROM jz_resume r
            LEFT JOIN jz_weichat_user_info w ON r.user_id=w.userid
            LEFT JOIN jz_weichat_erweima_log l ON w.openid=l.openid
            WHERE l.follow_by_scan=1
            AND l.erweima_id=".$erweima_id." 
            ".$where_date."
        ")->asArray()->all();
        $resume_count = count($resume_count) ? $resume_count[0]['user_count'] : 0;

        $date_start = strtotime(substr($erweima_m->create_time, 0, 10));
        $date_end   = strtotime(date("Y-m-d"));
        $date_options = [];
	    for($i=$date_start;$i<=$date_end;$i+=(24*3600)){
	        $date_options[date("Y-m-d",$i)]=date("Y-m-d",$i);
	    }
        
        $this->layout = 'bootstrap';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user_count'    => $user_count,
            'resume_count'    => $resume_count,
            'scan_count'    => $scan_count,
	        'scanuser_count' => $scanuser_count,
            'date_options' => $date_options,
        ]);
    }

    /**
     * Displays a single WeichatErweimaLog model.
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
     * Creates a new WeichatErweimaLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WeichatErweimaLog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WeichatErweimaLog model.
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
     * Deletes an existing WeichatErweimaLog model.
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
     * Finds the WeichatErweimaLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WeichatErweimaLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WeichatErweimaLog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
