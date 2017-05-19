<?php
 
namespace api\miduoduo\v1\controllers;
 

use api\common\BaseActiveController;
use yii;
 
/**
 * Controller API
 *
 * @author suibber
 */
class CompanyController extends BaseActiveController
{
    public $modelClass = 'api\miduoduo\v1\models\Company';

    public $id_column = 'id';
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

    public function actions()
    {
        $as = parent::actions();
        unset($as['delete']);
        return $as;
    }

    public function prepareDataProvider()
    {
        $model = $this->modelClass;
        $tc = $this->buildBaseQuery()
            ->andWhere([$this->user_identifier_column => Yii::$app->user->id])
            ->one();
        if( $tc ){
            return [
                'success' => true,
                'message' => '已经开通企业账号',
                'result' => $tc,
            ];
        }else{
            return [
                'success' => false,
                'message' => '未开通企业账号',
            ];
        }
        
    }

}
