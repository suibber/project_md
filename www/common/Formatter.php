<?php

namespace common;



class Formatter extends \yii\i18n\Formatter
{

    public function asDistance($meters){
        if ($meters>1000){
            return number_format(($meters/1000.0), 1, '.', '') . 'km';
        }
        return intval($meters) . 'm';
    }

}
