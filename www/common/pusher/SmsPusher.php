<?php
namespace common\pusher;

use Yii;
use yii\base\Component;
use yii\base\ViewContextInterface;

class SmsPusher extends Component implements ViewContextInterface
{

    public $_view;

    public function getViewPath()
    {
        return Yii::getAlias("@common/pusher/sms_tpl");
    }

    public function getView()
    {
        if (!$this->_view)
        {
            $this->_view = Yii::$app->getView();
        }
        return $this->_view;
    }

    public function render($view, $params = [])
    {
        return $this->getView()->render($view, $params, $this);
    }

    public function send($phonenum, $message)
    {
        Yii::$app->sms_sender->send($phonenum, $message);
    }

    public function push($phonenum, $params, $tpl)
    {
        $message = $this->render($tpl, $params);
        $this->send($phonenum, $message);
    }
}
