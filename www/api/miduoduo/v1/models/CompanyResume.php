<?php

namespace api\miduoduo\v1\models;

use Yii;
use common\Utils;


class CompanyResume extends \common\models\Resume
{
    public function fields()
    {
        return array_merge(parent::fields(), ['user', 'applicantDone', 'gender_label', 'age', 'degree_label', 'degree_options','exam_message']);
    }
}