<?php

namespace backend\controllers;

use Yii;
use backend\models\BugForm;
use backend\BBaseController;
use yii\filters\VerbFilter;

/**
 * AddressController implements the CRUD actions for Address model.
 */
class SupportController extends BBaseController
{

    public $defaultAction = 'report-bug';
    /**
     * Lists all Address models.
     * @return mixed
     */
    public function actionReportBug()
    {
        $model = new BugForm;
        if ($model->load(Yii::$app->request->post()) && $model->report()) {
            return $this->redirectHtml('/', $msg="bug已经提交成功，技术支持会加紧处理。");
        } else {
            return $this->render('report-bug', [
                'model' => $model,
            ]);
        }
    }
}
