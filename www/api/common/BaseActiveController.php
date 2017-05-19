<?php
namespace api\common;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\db\Query;
use yii\web\Response;
use yii\web\HttpException;

use common\BaseActiveRecord;
use common\Utils;


class BaseActiveController extends ActiveController
{

    public $serializer = [
        'class'=>'yii\rest\Serializer',
        'collectionEnvelope'=>'items',
    ];

    // 设置url中id所对应的字段
    public $id_column = 'id';

    //设置是否自动限定只访问自己的数据
    public $auto_filter_user = false;

    //标识用户的字段, 用此字段对应user_id
    public $user_identifier_column = null;

    // null = 使用默认
    public $page_size = 20;


    /*
     *  getQueryShortcuts() 是对query 的快捷处理
     *  在POST 或GET参数中 如果有 name=value的情况下，对query进行处理, 则对应的shortcuts可以写为：
     *  ```
     *      [name => [value => function($query, name, value){}] ]
     *  ```
     */
    public function getQueryShortcuts()
    {
        return [];
    }

    public function shortcutQuery($query)
    {
        foreach ($this->getQueryShortcuts() as $name=> $map){
            foreach ($map as $value=>$function){
                if (isset($_REQUEST[$name]) ) {
                    if ($value=='*' || $_REQUEST[$name]==$value) {
                        $function($query, $name, $_REQUEST[$name]);
                    }
                }
            }
        }
        return $query;
    }

    public function init()
    {
        parent::init();
    }

    // 默认排序
    public $defaultOrder = ['id'=>SORT_DESC];

    public function beforeAction($action)
    {
        $this->page_size   = Yii::$app->request->get('per-page') ? Yii::$app->request->get('per-page') : $this->page_size;
        if ($action->id == 'create'){
            if ($this->auto_filter_user && $this->user_identifier_column){
                $params = Yii::$app->getRequest()->getBodyParams();
                $params[$this->user_identifier_column] = strval(Yii::$app->user->id);
                Yii::$app->getRequest()->setBodyParams($params);
            }
        }
        return parent::beforeAction($action);
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        $actions['view']['findModel'] = [$this, 'findModel'];
        $actions['update']['findModel'] = [$this, 'findModel'];
        $actions['delete']['findModel'] = [$this, 'findModel'];

        return $actions;
    }

    public function findModel($id)
    {
        $model = $this->modelClass;
        $tc = $this->buildBaseQuery()->andWhere([$this->id_column=>$id])->one();
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
    }

    public function buildBaseQuery()
    {
        $model = $this->modelClass;
        $query = $model::find();
        if ($this->auto_filter_user && $this->user_identifier_column){
            if (\Yii::$app->user->isGuest){
                throw new HttpException(403, "Unknown user");
            }
            $query->where([$this->getTableName() . '.' . $this->user_identifier_column=>\Yii::$app->user->id]);
        }
        return $query;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if ($model && !$model->isNewRecord){
            if ($this->auto_filter_user && $this->user_identifier_column){
                if (\Yii::$app->user->isGuest){
                    throw new HttpException(403, "Unknown user");
                }
                if ($action=='view' && $model->user_id!=\Yii::$app->user->id){
                    throw new HttpException(403, "No access");
                }
            }
        }
        return parent::checkAccess($action, $model, $params);
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'], 
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [],
                ],
            ],
        ]); 
    }

    static $QUERY_OPERATIONS = [
        "=",
        "!=",
        "<>",
        ">=",
        ">",
        "<",
        "<=",
        "LIKE",
        "ILIKE",
        "IN",
        "NOT IN",
    ];

    protected function verbs()
    {
        $verbs = parent::verbs();
        $verbs['search'] = ['GET'];
        return $verbs;
    }

    public function prepareDataProvider()
    {
        return new ActiveDataProvider([
            'query' => $this->buildFilterQuery(),
            'sort' => ['defaultOrder'=>$this->defaultOrder],
            'pagination' => ['pageSize' => $this->page_size],
        ]);
    }

    public function buildFilterQuery(){
        $query = $this->buildBaseQuery();

        $p_str = Yii::$app->request->get('filters');

        if ($p_str && strlen($p_str)>0){
            $conditions = json_decode($p_str);
            if (null===$conditions){
                throw new HttpException(406, 'filters is not json format, please doublecheck it.');
            }
            $p_dict = [];
            $where = '1 ';
            foreach ($conditions as $filter){
                $operate = strtoupper($filter[0]);
                if (!in_array($operate, static::$QUERY_OPERATIONS)){
                    continue;
                }

                if(preg_match('/^[\w\d\_\.]+$/i', $filter[1])===0){
                    continue;
                }
                $fs = explode('.', $filter[1]);
                if (2==count($fs)){
                    $query->joinWith($fs[0]);
                    $filter[1] = $this->getColumn($fs[1], $fs[0]);
                } else {
                    $filter[1] = $this->getColumn($filter[1]);
                }
                if (isset($filter[2])){
                    $query->andWhere($filter);
                }
            }
        }
        $query = $this->_buildOrderQuery($query);
        $query = $this->shortcutQuery($query);
        return $query;
    }

    public function _buildOrderQuery($query)
    {
        $o_str = Yii::$app->request->get('orders');
        $o_arr = $o_str?json_decode($o_str):[];
        $orders = [];
        foreach ($o_arr as $o){
            if (substr($o, 0, 1)=='-'){
                $sort = SORT_DESC;
                $key = substr($o, 1);
            } else {
                $sort = SORT_ASC;
                $key = $o;
            }
            $fs = explode('.', $key);
            if (2==count($fs)){
                $column = $this->getColumn($fs[1], $fs[0]);
            } else {
                $column = $this->getColumn($filter[1]);
            }
            $orders[$column] = $sort;
        }
        $query->orderBy($orders);
        return $query;
    }

    public function getColumn($column, $slug=null)
    {
        return $this->getTableName($slug).'.'.$column;
    }

    public function getTableName($slug=null)
    {
        $model = $this->modelClass;
        return $slug?('jz_'.$slug):$model::tableName();
    }

    public function renderJson($data)
    {
        header('Content-type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        Yii::$app->end();
    }
}
