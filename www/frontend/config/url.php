<?php
    $seo_pinyin = array_shift(explode('.', $_SERVER['HTTP_HOST']));
    $city = \common\models\District::findOne(['seo_pinyin' => $seo_pinyin]);
    if( isset($city->seo_pinyin) 
        && stripos($_SERVER['HTTP_HOST'], $seo_pinyin.'.') !== false )
    {
        $_SERVER['REQUEST_URI'] = '/'.$city->seo_pinyin.$_SERVER['REQUEST_URI'];
    }
?>