<?php
namespace m\widgets;
/**
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class Switch extends \yii\bootstrap\Widget
{

    /**
     * @var array the options for rendering the close button tag.
     */
    public $closeButton = [];

    public $left_name = '';
    public $right_name = '';
    public $left_value = true;
    public $right_value = false;

    public $template = '';

    public function init()
    {
        parent::init();
    }

    public function run(){
        return Html::encode($this->message);
    }

}
