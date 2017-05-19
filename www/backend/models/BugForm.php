<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class BugForm extends Model
{
    public $title;
    public $description;

    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'bug简述',
            'description' => '详细描述',
        ];
    }

    public function report()
    {
        return Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['supportEmail'])
            ->setTo(Yii::$app->params['bugEmail'])
            ->setSubject($this->title)
            ->setTextBody($this->description)
            ->send();
    }
}
