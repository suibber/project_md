<?php
namespace corp\forms;

use Yii;
use yii\base\Model;

use common\models\Company;

/**
 * ContactForm is the model behind the contact form.
 */
class PersonalCertForm extends Model
{
    public $person_name;
    public $person_idcard;
    public $person_idcard_pic; 

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['person_name','person_idcard', 'person_idcard_pic'], 'required'],
            ['person_idcard_pic', 'file'],
        ];
    }
}
