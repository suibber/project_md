<?php

namespace m\controllers;

use Yii;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\TaskCollection;


class TaskCollectionController extends \m\MBaseController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                    'delete' => ['post'],
                ],
            ],

        ]);
    }

    public function actionCreate()
    {
        $task_id = Yii::$app->request->post('task_id');
        $user_id = Yii::$app->user->id;
        if (!$task_id){
            $this->render404();
        }

        $tc = TaskCollection::find(['task_id'=>$task_id,
            'user_id'=>$user_id
        ])->one();

        if (!$tc){
            $tc = new TaskCollection;
        }
        $tc->task_id = $task_id;
        $tc->user_id = $user_id;
        $tc->save();
        return $this->renderJson([
            'success'=> true,
            'message' => '已收藏',
        ]);
    }

    public function actionDelete()
    {
        TaskCollection::deleteAll('user_id = :user_id AND task_id = :task_id',
            [':user_id' => Yii::$app->user->id,
             ':task_id' => Yii::$app->request->post('task')]);
        return $this->renderJson([
            'success'=> true,
            'message' => '收藏已取消',
        ]);
    }
}



