<?php
namespace m\widgets;
/**
 * @author dawei
 */
class Switch extends \yii\bootstrap\Widget
{

    public $label = '验证码';

    public $template = '';

    public function init()
    {
        parent::init();
    }

    public function run(){
        return Html::encode(
'<div class="form-group">
        <label>'.$this->label.'</label>
        <div class="yzm">
          <button type="button" class="btn btn-default form-yzm-c">重新获取60S</button>
          <input type="text" class="form-control" placeholder="">
        </div>
      </div>
');
    }

}
