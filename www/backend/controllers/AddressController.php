<?php
namespace backend\controllers;

use Yii;
use common\models\Address;
use common\models\AddressSearch;
use backend\BBaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AddressController implements the CRUD actions for Address model.
 */
class AddressController extends BBaseController
{

    public function actionCreate()
    {
        $model = new Address();

        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->renderJson([
                'success'=> true,
                'msg'=> '创建成功',
                'result'=> $model->toArray()
            ]);
        } else {
            return $this->renderJson([
                'success'=> false,
                'msg'=> '创建失败',
                'errors'=> $model->getErrors(),
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Address::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
