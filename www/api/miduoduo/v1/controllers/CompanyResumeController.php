<?php

namespace api\miduoduo\v1\controllers;

use api\common\BaseActiveController;
use yii;
use common\models\TaskApplicant;
 
/**
 * Controller API
 *
 * @author suibber
 */
class CompanyResumeController extends BaseActiveController
{
    public $modelClass = 'api\miduoduo\v1\models\CompanyResume';
    public $auto_filter_user = true;
    public $id_column = 'user_id';

    public function actions(){
        $as = parent::actions();
        unset($as['delete']);
        unset($as['update']);
        unset($as['index']);
        return $as;
    }

    public function findModel($id){
        $model = $this->modelClass;
        $task_id = YII::$app->request->get('task_id');
        if( $this->checkAppTask($id, $task_id) ){
            $tc = $this->buildBaseQuery()
                ->andWhere([$this->id_column=>$id])
                ->one();
            //var_dump($tc);exit;
            if (!$tc){
                if (Yii::$app->response->format == \yii\web\Response::FORMAT_JSON) {
                    echo "false";
                }
                if (Yii::$app->response->format == \yii\web\Response::FORMAT_XML) {
                    echo "<root />";
                }
                Yii::$app->end();
            }
            return $tc;
        }else{
            return false;
        }
    }

    public function checkAppTask($user_id, $task_id){
        $applicant = TaskApplicant::findOne(['user_id' => $user_id, 'task_id' => $task_id]);
        if( $applicant ){
            return true;
        }else{
            return false;
        }
    }
}
?>