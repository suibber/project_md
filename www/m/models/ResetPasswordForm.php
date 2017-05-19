<?php
namespace m\models;

use common\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $password2;

    /**
     * @var \common\models\User
     */
    private $_user;

    public function __construct($user, $config=[]){
        parent::__construct($config);
        $this->_user = $user;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'password2'], 'required'],
            [['password'], 'string', 'min' => 6],
            ['password2', function($attr, $params){
                if ($this->password!=$this->password2){
                    $this->addError($attr, '两次密码输入不一致');
                }
            }],
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);

        return $user->save(false);
    }


    public function attributeLabels()
    {
        return ['password'=>'密码',
            'password2'=>'重新输入'
        ];
    }
}
