<?php

namespace backend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Company;
use common\models\CompanySearch;
use backend\BBaseController;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends BBaseController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
           'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'change-status' => ['post'],
                    'delete' => ['post'],
                    'examine' => ['post'],
                ],
            ],
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


    /**
     * Lists all Company models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Company model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionSearch($keyword)
    {
        $cs_arr = [];
        if ($keyword){
            $query = Company::find()->where(['like', 'name', $keyword]);
            $cs = $query->all();
            foreach($cs as $c){
                $cs_arr[] = $c->toArray();
            }
        }
        return $this->renderJson($cs_arr);
    }

    /**
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Company();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Company model.
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

    public function actionChangeStatus($id, $status)
    {
        Company::updateAll(['status'=> $status], 'id=:id',
            $params=[':id'=>$id]);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDelete($id)
    {
        return $this->actionChangeStatus($id, $status=Company::STATUS_DELETED);
    }

    public function actionBlacklist($id)
    {
        return $this->changeStatus($id, $status=Company::STATUS_BLACKLISTED);
    }

    public function actionExamine($id, $passed)
    {
        $company = $this->findModel($id);
        $note = Yii::$app->request->post('note');
        if ($note){
            $company->exam_note = $note;
        }
        if ($passed){
            $company->exam_status = Company::EXAM_DONE;
            $company->exam_result = Company::EXAM_GOVID_PASSED;
            $company->status      = Company::STATUS_WHITEISTED; 
            $company->updateNeedcheckToPass($id);
            if ($company->corp_idcard_pic){
                $company->exam_result = $company->exam_result | Company::EXAM_LICENSE_PASSED;
            }
        } else {
            $company->exam_result = 0;
            $company->exam_status = Company::EXAM_NOT_PASSED;
        }
        $company->save();
        return $this->redirect('view?id=' . $id);
    }

    protected function findModel($id)
    {
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
