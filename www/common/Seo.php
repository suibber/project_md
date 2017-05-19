<?php
namespace common;

use Yii;
use common\models\District;
use common\models\ServiceType;

class Seo
{
    public static function makeSeoCode($city,$block,$type,$clearance_type,$company,$task_title,$page_type,$need_quantity='',$address='',$salary='',$detail='')
    {
        $company    = $company ? $company : '米多多兼职';
        
        $title      = Yii::$app->params['seo']['title'][$page_type];
        $title      = str_ireplace('[task_title]',$task_title,$title);
        $title      = str_ireplace('[city]',$city,$title);
        $title      = str_ireplace('[block]',$block,$title);
        $title      = str_ireplace('[type]',$type,$title);
        $title      = str_ireplace('[clearance_type]',$clearance_type,$title);
        $title      = str_ireplace('[company]',$company,$title);
        $title      = str_ireplace('[clearance_type]',$clearance_type,$title);

        $keywords      = Yii::$app->params['seo']['keywords'][$page_type];
        $keywords      = str_ireplace('[task_title]',$task_title,$keywords);
        $keywords      = str_ireplace('[city]',$city,$keywords);
        $keywords      = str_ireplace('[block]',$block,$keywords);
        $keywords      = str_ireplace('[type]',$type,$keywords);
        $keywords      = str_ireplace('[clearance_type]',$clearance_type,$keywords);
        $keywords      = str_ireplace('[company]',$company,$keywords);
        $keywords      = str_ireplace('[clearance_type]',$clearance_type,$keywords);

        $description      = Yii::$app->params['seo']['description'][$page_type];
        $description      = str_ireplace('[task_title]',$task_title,$description);
        $description      = str_ireplace('[city]',$city,$description);
        $description      = str_ireplace('[block]',$block,$description);
        $description      = str_ireplace('[type]',$type,$description);
        $description      = str_ireplace('[clearance_type]',$clearance_type,$description);
        $description      = str_ireplace('[company]',$company,$description);
        $description      = str_ireplace('[need_quantity]',$need_quantity,$description);
        $description      = str_ireplace('[address]',$address,$description);
        $description      = str_ireplace('[salary]',$salary,$description);
        $description      = str_ireplace('[detail]',$detail,$description);
        $description      = preg_replace('/\s/is','',$description);

        $seo_code   = ['title'=>$title,'keywords'=>$keywords,'description'=>$description];
        //print_r($seo_code);exit;
        return $seo_code;
    }

    public static function mParseTaskListParam(){
        $city_id        = Yii::$app->request->get('city_id');
        $districts_id   = Yii::$app->request->get('districts_id');
        $type_id        = Yii::$app->request->get('type_id');
        $city_pinyin        = Yii::$app->request->get('city_pinyin');
        $districts_pinyin   = Yii::$app->request->get('districts_pinyin');
        $type_pinyin        = Yii::$app->request->get('type_pinyin');        
        
        $seo_params = [
            'city_id'   => $city_id,
            'block_id'  => $districts_id,
            'type_id'   => $type_id,
            'city_pinyin'   => $city_pinyin,
            'block_pinyin'  => $districts_pinyin,
            'type_pinyin'   => $type_pinyin,
        ];
        //print_r($seo_params);exit;
        return $seo_params;
    }

    public static function formatFrontendUrl($url, $type = ''){
        if( $type == '' ){
            $url = preg_replace('/^\/\w+?\//is','/',$url);
            $url = str_ireplace('p1/', '', $url);
        }elseif( $type == 'pager' ){
            $url = preg_replace('/href\=\"\/\w+?\//is','href="/',$url);
        }
        return $url;
    }
}