<?php

namespace backend\controllers;

use Yii;
use common\models\WeichatErweimaLog;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\BBaseController;
use common\models\WeichatUserInfo;
use common\models\WeichatErweima;
use yii\helpers\ArrayHelper;

/**
 * WeichatErweimaLogController implements the CRUD actions for WeichatErweimaLog model.
 */
class WeichatErweimaLogController extends BBaseController
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
        return Yii::getAlias('@backend/views/wechat/weichat-erweima-log');
    }

    /**
     * Lists all WeichatErweimaLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $erweimaid  = Yii::$app->request->get('id');
        $dataProvider = new ActiveDataProvider([
            'query' => WeichatErweimaLog::find()->where(['erweima_id'=>$erweimaid]),
        ]);

        $scan_count = WeichatErweimaLog::find()->where(['erweima_id'=>$erweimaid])->count();
        WeichatErweima::updateAll(['scan_num'=>$scan_count],['id'=>$erweimaid]);

	$scanuser_count = WeichatErweimaLog::findBySql("
		SELECT COUNT(DISTINCT(openid)) scanuser_count
		FROM jz_weichat_erweima_log 
		WHERE erweima_id=".$erweimaid."
	")->asArray()->all();
	$scanuser_count = $scanuser_count[0]['scanuser_count'] ? $scanuser_count[0]['scanuser_count'] : 0;
        
	$user_count = WeichatUserInfo::findBySql("
            SELECT COUNT(distinct(l.openid)) user_count
            FROM jz_weichat_user_info w
            LEFT JOIN jz_weichat_erweima_log l ON w.openid=l.openid
            WHERE l.follow_by_scan=1
            AND l.erweima_id=".$erweimaid." 
        ")->asArray()->all();
        $user_count = count($user_count) ? $user_count[0]['user_count'] : 0;

        $resume_count = WeichatUserInfo::findBySql("
            SELECT COUNT(distinct(l.openid)) user_count
            FROM jz_resume r
            LEFT JOIN jz_weichat_user_info w ON r.user_id=w.userid
            LEFT JOIN jz_weichat_erweima_log l ON w.openid=l.openid
            WHERE l.follow_by_scan=1
            AND l.erweima_id=".$erweimaid." 
        ")->asArray()->all();
        $resume_count = count($resume_count) ? $resume_count[0]['user_count'] : 0;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'user_count'    => $user_count,
            'resume_count'    => $resume_count,
            'scan_count'    => $scan_count,
	    'scanuser_count' => $scanuser_count,
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
