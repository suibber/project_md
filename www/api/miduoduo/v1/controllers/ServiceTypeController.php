<?php
 
namespace api\miduoduo\v1\controllers;
 
use api\common\BaseActiveController;
 
/**
 * Address Controller API
 *
 * @author dawei
 */
class ServiceTypeController extends BaseActiveController
{
    public $modelClass = 'common\models\ServiceType';

    public $id_column = 'id';

    public function actions()
    {
        $actions = parent::actions();
        return ['index'=> $actions['index'], 'view'=> $actions['view']];
    }

    public function buildBaseQuery()
    {
        $model = $this->modelClass;
        $query = parent::buildBaseQuery();
        $query->andWhere(['status'=>$model::STATUS_OK]);
        return $query;
    }
}
