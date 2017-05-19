<?php
namespace corp;

use Yii;
use yii\filters\AccessControl;
use common\BaseController;
use corp\models\TaskApplicant;

class CBaseController extends BaseController
{

    public function beforeAction($action){
        $user_id    = Yii::$app->user->id;
        if( $user_id ){
            $overtime   = date("Y-m-d H:i:s",time()-60*60*24*TaskApplicant::STATUS_APPLY_OVERDAYS);
            $resume_app = TaskApplicant::findBySql("
                SELECT COUNT(a.id) untreated_resume FROM jz_user u
                LEFT JOIN jz_task t ON t.user_id=u.id
                LEFT JOIN jz_task_applicant a ON a.task_id=t.id
                WHERE u.id=".$user_id."
                AND a.`status`=0
                AND a.created_time>'".$overtime."'
            ")->asArray()->one();
            Yii::$app->session->set('untreated_resume',$resume_app['untreated_resume']);
        }
        return parent::beforeAction($action);
    }
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['corp'],
                    ],
                ],
                'denyCallback' => function($rule, $action){
                    if (!Yii::$app->user->isGuest){
                        return $this->redirect('/user/add-contact-info');
                    }else{
		        return $this->redirect('/');
		    }
                },
            ],
       ];
    }
}
