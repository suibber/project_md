<?php
 
namespace api\miduoduo\v1\controllers;
 
use api\common\BaseActiveController;
use yii\web\ForbiddenHttpException;
use yii\data\ActiveDataProvider;
 
/**
 * District Controller API
 *
 * @author dawei
 */
class DistrictController extends BaseActiveController
{
    public $modelClass = 'common\models\District';

    public $id_column = 'id';

    public $defaultOrder = ['pinyin'=>SORT_ASC];

    public function actions()
    {
        $actions = parent::actions();
        return ['index' => $actions['index']];
    }

    public function getQueryShortcuts()
    {
        return [
            'level' => [
                 'city' => function($query, $name, $value){
                     $query->andWhere([$this->getColumn($name)=>$value]);
                 },
                 'province' => function($query, $name, $value){
                     $query->andWhere([$this->getColumn($name)=>$value]);
                 },
                 'district' => function($query, $name, $value){
                     $query->andWhere([$this->getColumn($name)=>$value]);
                 },
            ],
        ];
    }

    public $page_size = 10000;

    public function buildBaseQuery()
    {
        $model = $this->modelClass;
        $query = parent::buildBaseQuery();
        $query->andWhere(['is_alive'=>1]);
        return $query;
    }
}
