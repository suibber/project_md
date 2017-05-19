<?php
namespace frontend\controllers;

use Yii;
use yii\web\HttpException;
use yii\filters\AccessControl;

use common\models\Resume;
use common\models\User;

use frontend\FBaseController;

class ResumeController extends FBaseController
{

    public function actionDetail($user_id, $name){
        $resume   = Resume::find()->where(['user_id'=>$user_id])
            ->with('applicantDone')
            ->one();
        if (!$resume || $resume->name != $name){
            throw new HttpException(404, 'Resume not found');
        }
        $this->layout   = false;

        return $this->render(
            'detail',['resume'=> $resume]  
        );
    }
}
