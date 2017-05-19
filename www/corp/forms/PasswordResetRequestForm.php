<?php
namespace corp\forms;

use yii\base\Model;

use common\Utils;
use common\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $username;
    public $vcode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_OK],
                'message' => 'There is no user with such phone.'
            ],

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
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '手机号',
            'vcode' => '验证码',
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function verifyPhone()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_OK,
            'username' => $this->username,
        ]);

        if ($user) {
            $token = false;
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $token = $user->generatePasswordResetToken();
            }

            if ($user->save()) {
                return $token;
            }
        }

        return false;
    }
}
