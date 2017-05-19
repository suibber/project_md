<?php
namespace corp\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use corp\CBaseController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Company;


/**
 * Site controller
 */
class SiteController extends CBaseController
{

    public function behaviors()
    {
        return [];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest) {
            return $this -> render('index');
        }
        return $this->redirect('/task/');
    }


}
