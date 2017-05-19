<?php

namespace m\controllers;

use Yii;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use common\models\Task;
use common\models\Resume;
use common\models\District;
use common\models\ServiceType;
use common\models\TaskApplicant;
use yii\data\Pagination;


class AccountController extends \m\MBaseController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
            ],
        ]);
    }

    public function actionIndex()
    {
        
    }
}
