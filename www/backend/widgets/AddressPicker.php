<?php
namespace backend\widgets;


class AddressPicker extends \yii\bootstrap\Widget
{

    public $lat;
    public $lng;

    public $closeButton = [];

    public function init()
    {
        parent::init();

        $session = \Yii::$app->getSession();
    }
}
