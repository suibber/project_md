<?php

namespace backend\controllers;

use Yii;
use common\models\WeichatErweima;
use common\models\WeichatErweimaSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\WeichatBase;
use backend\BBaseController;

/**
 * WeichatErweimaController implements the CRUD actions for WeichatErweima model.
 */
class WeichatErweimaController extends BBaseController
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
        return Yii::getAlias('@backend/views/wechat/weichat-erweima');
    }

    /**
     * Lists all WeichatErweima models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WeichatErweimaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WeichatErweima model.
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
     * Creates a new WeichatErweima model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WeichatErweima();

        $timedate               = date("Y-m-d H:i:s",time());
        $model->create_time     = $timedate;
        $model->update_time     = $timedate;
        $model->scene_id        = rand(1,100000);

        if ($model->load(Yii::$app->request->post()) ) {
            $model->ticket    = $this->getErweimaTicket($model->scene_id,$model->type);
            
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    // 根据标识ID，二维码类型，请求微信接口，得到生成二维码的票据
    public function getErweimaTicket($scene_id,$type){
        $weichat        = new WeichatBase();
        $access_token   = $weichat->getWeichatAccessToken();

        $targetUrl      = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
        $postData       = "";

        if( $type == 1 ){
            // 7天的二维码
            $postData       = '{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": '.$scene_id.'}}}';
        }else{
            // 永久的二维码
            $postData       = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$scene_id.'}}}';
        }

        $ticketJson = $weichat->postWeichatAPIdata($targetUrl,$postData);
        $ticketArr  = json_decode($ticketJson);

        return $ticketArr->ticket;
    }

    /**
     * Updates an existing WeichatErweima model.
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
     * Deletes an existing WeichatErweima model.
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
     * Finds the WeichatErweima model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WeichatErweima the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WeichatErweima::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
