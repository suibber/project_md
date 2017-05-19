<?php
 
namespace api\miduoduo\v1\controllers;
 

use api\common\BaseActiveController;
use common\models\Task;
use yii\data\Pagination;
use yii;
 
/**
 * Controller API
 *
 * @author suibber
 */
class CompanyApplicantController extends BaseActiveController
{
    public $modelClass = 'common\models\TaskApplicant';

    public $id_column = 'id';
    public $auto_filter_user = false;

    public function actions()
    {
        $as = parent::actions();
        unset($as['delete']);
        $as['update'] = [
            'class' => 'api\miduoduo\v1\models\CompanyEditApplicantAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->createScenario,
        ];
        return $as;
    }

    public function prepareDataProvider()
    {
        $tasks = Task::findAll([
            'user_id'=>Yii::$app->user->id
        ]);
        $task_ids = [];
        foreach($tasks as $task){
            $task_ids[] = $task->id;
        }
        $query = parent::buildFilterQuery();

        $query = $query
            ->andWhere(['in', 'task_id', $task_ids])
            ->orderBy(['id' => SORT_DESC]);

        $cloneQuery = clone $query;
        $count = $cloneQuery->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $query-> with('resume')->with('task');
        $task_apps = $query->offset($pagination->offset)
                         ->limit($pagination->limit)
                         ->all();

        $currentPage = is_numeric(YII::$app->request->get('page')) ? YII::$app->request->get('page') : 1;
        $perPage = $pagination->defaultPageSize;
        $pageCount = ceil($count/$perPage);
        return [
            "items" => $task_apps,
            "_meta" => [
                "totalCount" => $count,
                "pageCount" => $pageCount,
                "currentPage" => $currentPage,
                "perPage" => $perPage
            ],
        ];
    }
}
