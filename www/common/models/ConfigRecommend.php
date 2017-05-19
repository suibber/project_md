<?php

namespace common\models;

use Yii;
use common\models\District;

/**
 * This is the model class for table "{{%config_recommend}}".
 *
 * @property integer $id
 * @property string $task_id
 * @property integer $type
 * @property integer $city_id
 * @property integer $display_order
 */
class ConfigRecommend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%config_recommend}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'city_id', 'display_order'], 'integer'],
            [['task_id'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => '任务gid',
            'type' => '类型',
            'city_id' => '城市ID',
            'display_order' => '排序，越大越靠前',
        ];
    }

    public function getTask()
    {
        return $this->hasOne(Task::className(), ['gid' => 'task_id']);
    }

    public static function getCityList(){
        $citys_obj = District::find()
            ->where(['level'=>'city','is_alive'=>1])
            ->addOrderBy(['id'=>SORT_ASC])
            ->all();
        $citys = [];
        foreach( $citys_obj as $city ){
            $citys[$city->id] = $city->name;
        }
        return $citys; 
    }
}
