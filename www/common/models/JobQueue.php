<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%job_queue}}".
 *
 * @property integer $id
 * @property string $task_name
 * @property resource $params
 * @property integer $retry_times
 * @property string $start_time
 * @property integer $priority
 * @property integer $status
 */
class JobQueue extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return '{{%job_queue}}';
    }

    static $STATUSES = [
        0 => "队列中",
        1 => "执行中",
        2 => "执行完毕",
        10 => "执行失败",
    ];

    const STATUS_IN_QUEUE = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_DONE = 2;
    const STATUS_FAILED = 10;

    static $PRIORITIES = [
        4 => "最高",
        3 => "高",
        2 => "普通",
        1 => "低",
        0 => "最低",
    ];

    const PRIORITY_HIGHEST = 4;
    const PRIORITY_HIGH = 3;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_LOW = 1;
    const PRIORITY_LOWEST = 0;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_name'], 'required'],
            [['params'], 'string'],
            [['retry_times', 'priority', 'status'], 'integer'],
            [['start_time'], 'safe'],
            [['task_name'], 'string', 'max' => 100],
            ['status', 'default', 'value'=>static::STATUS_IN_QUEUE],
            ['message', 'string'],
            ['priority', 'default', 'value'=>static::PRIORITY_MEDIUM],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_name' => '任务名(Console Router)',
            'params' => '参数',
            'retry_times' => '剩余重试机会',
            'start_time' => '开始时间',
            'priority' => '优先级',
            'status' => '状态',
            'message' => '消息',
        ];
    }

    /**
     * @inheritdoc
     * @return JobQueueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JobQueueQuery(get_called_class());
    }

    public function setParams($params)
    {
        $this->params = json_encode($params);
    }

    private $_params = false;

    public function getUnserializeParmas()
    {
        if (false===$this->_params){
            $this->_params = json_decode($this->params, true);
        }
        return $this->_params;
    }

    public function getStatus_label()
    {
        return $this::$STATUSES[$this->status];
    }

    public function getPriority_label()
    {
        return $this::$PRIORITIES[$this->priority];
    }

    public function retryIfCan()
    {
        if ($this->retry_times>0){
            $this->retry_times -= 1;
            $this->status = static::STATUS_IN_QUEUE;
            return true;
        }
        return false;
    }
}
