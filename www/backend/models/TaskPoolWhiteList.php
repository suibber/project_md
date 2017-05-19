<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%task_pool_white_list}}".
 *
 * @property integer $id
 * @property string $origin
 * @property string $attr
 * @property string $value
 * @property string $examined_time
 * @property string $slug
 * @property integer $examined_by
 * @property integer $is_white
 */
class TaskPoolWhiteList extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_pool_white_list}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['origin', 'attr', 'value', 'examined_by'], 'required'],
            [['examined_time'], 'safe'],
            [['examined_by', 'is_white'], 'integer'],
            [['origin', 'attr', 'value'], 'string', 'max' => 200],
            [['slug'], 'string', 'max' => 100],
            [['origin', 'attr', 'value'], 'unique', 'targetAttribute' => ['origin', 'attr', 'value'], 'message' => 'The combination of Origin, Attr and Value has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'origin' => '来源',
            'attr' => '属性',
            'value' => '值',
            'examined_time' => '添加规则时间',
            'slug' => 'Slug',
            'examined_by' => '审核人',
            'is_white' => '是白名单(否黑)',
        ];
    }

    public function getType_label()
    {
        return $this->is_white?'白名单':'黑名单';
    }

    /**
     * @inheritdoc
     * @return TaskPoolWhiteListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskPoolWhiteListQuery(get_called_class());
    }

    public function examineTaskPool()
    {
        $conditions = [
                $this->attr=>$this->value,
                'origin'=>$this->origin,
                'status'=>TaskPool::STATUS_UNSETTLED
            ];
        if ($this->is_white){
            $ws = TaskPool::findAll($conditions);
            $tasks = [];
            foreach ($ws as $w){
                $task = $w->exportTask();
                $tasks[] = $task;
            }
            TaskPool::updateAll(['status'=>TaskPool::STATUS_EXPORTED], $conditions);
            return $tasks;
        } else {
            TaskPool::updateAll(['status'=>TaskPool::STATUS_DROPPED], $conditions);
        }
    }
}
