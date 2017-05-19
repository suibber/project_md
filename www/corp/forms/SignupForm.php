<?php
namespace corp\forms;

use Yii;
use yii\base\Model;

use common\Utils;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $vcode;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '该手机号已经注册过'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['vcode', 'filter', 'filter' => 'trim'],
            ['vcode', 'required'],
            ['vcode', 'match', 'pattern'=>'/^\d{4}$/', 'message'=>'验证码不正确.'],
            ['vcode', function ($attribute, $params) {
                if (!$this->hasErrors()) {
                    if(!Utils::validateVerifyCode($this->username, $this->vcode)){
                        $this->addError($attribute, '手机号或验证码不正确.');
                    }
                }
            }],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }

    public function attributeLabels()
    {
        return [
            'username' => '手机号',
            'password' => '密码',
            'vcode' => '验证码',
        ];
    }
}
