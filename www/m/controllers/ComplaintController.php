<?php
namespace m\controllers;

use Yii;
use yii\filters\AccessControl;
use m\MBaseController;

use common\models\Complaint;
use common\models\Task;

class ComplaintController extends MBaseController
{

    public $layout = 'main';

     /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'edit', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' =>['view'],
                        'allow' => true,
                        'roles' => ['*'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new Complaint();
        $tid = Yii::$app->request->get('id');
        $task = $tid?Task::findOne($tid):null;
        if (!$task){
            return $this->render404();
        }
        $default_phonenum = '';
        if (!Yii::$app->user->isGuest){
            $model->user_id = Yii::$app->user->id;
            $default_phonenum = Yii::$app->user->identity->username;
        }
        $model->task_id = $tid;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $to = '/task/view?gid=' . $task->gid;
            return $this->redirectWithSucceedMsg($to, '您的投诉我们已经收到，感谢你让我们成长');
        } else {
            return $this->render('create', [
                'model' => $model,
                'default_phonenum' => $default_phonenum,
            ]);
        }
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
