<?php
 
namespace api\miduoduo\v1\controllers;
 
use api\common\BaseActiveController;
use common\models\ConfigBanner;
use common\Utils;
 
/**
 * Address Controller API
 *
 * @author dawei
 */
class CityBannerController extends BaseActiveController
{
    public $modelClass = 'common\models\ConfigBanner';

    public $id_column = 'id';

    public $defaultOrder = ['display_order'=>SORT_DESC];

    public function actions()
    {
        $actions = parent::actions();
        return ['index'=> $actions['index']];
    }

    public function buildBaseQuery()
    {
        $model = $this->modelClass;
        $query = parent::buildBaseQuery();
        $query->andWhere(['status'=>ConfigBanner::STATUS_OK]);
        $query->andWhere("`offline_date` >= '".date("Y-m-d")."'");
        return $query;
    }

}
