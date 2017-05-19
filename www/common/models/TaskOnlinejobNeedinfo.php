<?php

namespace common\models;

use Yii;
use common\Utils;

/**
 * This is the model class for table "{{%task_onlinejob_needinfo}}".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $task_id
 * @property integer $group_id
 * @property integer $display_order
 * @property string $intro
 * @property string $intro_pic
 * @property integer $is_required
 * @property integer $is_must
 */
class TaskOnlinejobNeedinfo extends \yii\db\ActiveRecord
{
    public static $GROUPS = [
        1 => '图片步骤',
        2 => '文本步骤',
    ];

    public static $TYPES = [
        1 => '图片',
        2 => '文本',
    ];

    const TYPES_PIC = 1;
    const TYPES_TEXT = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_onlinejob_needinfo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'task_id', 'group_id', 'display_order', 'is_required', 'is_must', 'type'], 'integer'],
            [['intro'], 'string', 'max' => 200],
            [['intro_pic'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '附加信息ID',
            'status' => '状态',
            'task_id' => '任务id',
            'group_id' => '分组id',
            'type' => '类型（图片，文本）',
            'display_order' => '排序',
            'intro' => '名称',
            'intro_pic' => '图片',
            'is_required' => '是否需要填写',
            'is_must' => '是否必填',
        ];
    }

    public function getIntro_pic_url()
    {
        return Utils::urlOfFile($this->intro_pic);
    }

    public function fields()
    {
        return array_merge(parent::fields(), ['intro_pic_url']);
    }
}
