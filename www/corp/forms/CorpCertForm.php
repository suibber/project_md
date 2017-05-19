<?php
namespace corp\forms;

use Yii;
use yii\base\Model;

use common\models\Company;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $phone;
    public $email;
    public $name; //公司名
    public $contact; //联系人

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','phone', 'email', 'contact'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
        ];
    }

    public function saveContactInfo()
    {
        return Company::updateContactInfo($this->name, $this->phone, $this->email, $this->contact);
    }
}
