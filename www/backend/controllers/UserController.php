<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use common\models\UserSearch;
use backend\BBaseController;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BBaseController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['delete-myself'],
                        'allow' => true,
                        'roles' => ['developer'],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
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

    public function actionDeleteMyself()
    {
        $user_id = Yii::$app->user->id;
        $path = Yii::getAlias('@common/models/');
        $models = [];
        $user_id = Yii::$app->user->id;
        foreach (scandir($path) as $file) {
            if (substr($file, -4)=='.php' 
                    && substr($file, -9, -4)!='Query'
                    && substr($file, -10, -4)!='Search'){
                $model = "\\common\\models\\" . substr($file, 0, -4);
                if (is_subclass_of($model, '\yii\db\ActiveRecord')){
                    $models[] = $model;
                }
            }
        }
        foreach ($models as $model){
            if (isset($model::getTableSchema()->columns['user_id'])){
                Yii::info("delete Data in $model where user_id= $user_id\n");
                $model::deleteAll(['user_id'=>$user_id]);
            }
           if (isset($model::getTableSchema()->columns['userid'])){
                Yii::info("delete Data in $model where userid= $user_id\n");
                $model::deleteAll(['userid'=>$user_id]);
            }
        }
        User::deleteAll(['id'=>$user_id]);
        return $this->redirect('/');
    }

    public function actionSetRole()
    {
        $phonenum = Yii::$app->request->post('phonenum');
        $role_name = Yii::$app->request->post('role');
        $message = '';
        if ($phonenum && $role_name){
            $user = User::find()->where(
                ['username'=>$phonenum])->one();
            if ($user) {
                $auth = Yii::$app->authManager;
                $role = $auth->getRole($role_name);
                if ($role){
                    if (!$auth->checkAccess($user->getId(), $role_name)) {
                        $auth->assign($role, $user->getId());
                        return $this->redirectHtml(
                            Url::current(), "为 $phonenum 设置权限为 $role_name 成功!");
                    }
                    $message = "$phonenum 已经拥有 $role_name !";
                } else {
                    $message = "角色 $role_name 不存在";
                }
            } else {
                $message = "用户 $phonenum 不存在";
            }
        } elseif (!$phonenum && $role_name) {
            $message = "手机号不能为空";
        }
        return $this->render('set-role', [
            'message' => $message,
            'phonenum' => $phonenum,
            'role' => $role_name,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
