<?php
 
namespace api\miduoduo\v1\controllers;
 
use api\common\BaseActiveController;
 
/**
 * Sys Message Controller API
 *
 * @author dawei
 */
class UserHistoricalLocationController extends BaseActiveController
{
    public $modelClass = 'common\models\UserHistoricalLocation';

    public $id_column = 'id';
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';


    public function getQueryShortcuts()
    {
        return [
            'last_only' => [
                '*' => function($query, $name, $value){
                        $query->orderBy(['id'=>SORT_DESC])->limit(1);
                }
            ],
        ];
    }

}
