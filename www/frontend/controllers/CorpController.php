<?php
namespace frontend\controllers;

use Yii;
use frontend\FBaseController;

/**
 */
class CorpController extends FBaseController
{
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
}
