<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\Utils;

/**
 * Login form
 */
class LoginWithDynamicCodeForm extends Model
{
    public $phonenum;
    public $code;
    public $invited_code;
    public $rememberMe = true;

    public $signup_only = false;
    public $origin;

    private $_user = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phonenum', 'code'], 'required', 'message'=>'不可为空'],
            ['rememberMe', 'boolean'],
            ['rememberMe', 'default', 'value'=>false],
            ['code', 'match', 'pattern'=>'/^\d{4,}$/', 'message'=>'验证码不正确.'],
            ['invited_code', 'integer'],
            ['code', function ($attribute, $params) {
                if (!$this->hasErrors()) {
                    if(!Utils::validateVerifyCode($this->phonenum, $this->code)){
                        $this->addError($attribute, '手机号或验证码不正确.');
                    }
                }
            }],
            ['phonenum', function($attr, $params){
                if ($this->signup_only && $this->getUser()){
                    $this->addError($attr, '手机号注册过，您可已直接登陆.');
                }
            }],
        ];
    }

    /**
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser($auto_create=true), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser($auto_create=false)
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->phonenum);
        }
        if (!$this->_user && $auto_create){
            $user = User::createUserWithPhonenum($this->phonenum,
                $invited_by=$this->invited_code);
            $this->_user = $user;
        }
        return $this->_user;
    }
}
