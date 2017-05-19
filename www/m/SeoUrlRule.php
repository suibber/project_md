<?php

namespace m;

use Yii;
use yii\web\UrlRule;
use yii\base\Object;
use yii\web\UrlRuleInterface;
use common\models\District;
use common\models\ServiceType;


class SeoUrlRule extends UrlRule
{

    public function createUrl($manager, $route, $params)
    {
        if ($route=='task/index') {
            if (!isset($params['city_pinyin'])){
                return '';
            }
            $url = $params['city_pinyin'] . "/";
            if (!empty($params['district_pinyin'])){
                $url .= $params['district_pinyin'] . "/";
            }
            if (!empty($params['type_pinyin'])){
                $url .= $params['type_pinyin'] . "/";
            }
            return $url . 'p' . $params['page'] . '/';
        }
        if ($route=='site/index') {
            $city_pinyin = Yii::$app->session->get('city_pinyin');
            if (empty($city_pinyin)){
                return 'change-city';
            }
            return $city_pinyin . '/';
        }
        return false;
    }


    public function parseRequest($manager, $request)
    {
        $path = $request->pathInfo;
        $this->redirectIfCitySet($path);

        $r = $this->parseIndexRequest($manager, $request);
        if (!$r) {
            $r = $this->parseListRequest($manager, $request);
        }
        return $r;
    }


    public function parseIndexRequest($manager, $request)
    {
        $path = $request->pathInfo;

        $key = 'cities_index_url_re';
        $re = Yii::$app->cache->get($key);
        if (!$re){
            $cities = District::findAll(['level'=>'city', 'is_alive'=>1]);
            $cs_pinyins= [];
            $cids = [];
            foreach($cities as $city){
                $cs_pinyins[] = $city->seo_pinyin;
                $cids[] = $city->id;
            }
            $city_re = implode('|', $cs_pinyins);
            $re = '/^(' . $city_re . ')\/$/i';
            Yii::$app->cache->set($key, $re, 60*60*3);
        }
        if (preg_match($re, $path, $matches)){
            return [
                0=> 'site/index',
                1=> [
                    'city_pinyin'=> array_pop($matches),
                ],
            ];
        }
        return false;
    }

    public function parseListRequest($manager, $request)
    {
        $path = $request->pathInfo;

        $key = 'task_list_url_match_rules';
        $re = Yii::$app->cache->get($key);
        if (!$re){
            $cities = District::findAll(['level'=>'city', 'is_alive'=>1]);
            $cs_pinyins= [];
            $cids = [];
            foreach($cities as $city){
                $cs_pinyins[] = $city->seo_pinyin;
                $cids[] = $city->id;
            }
            $city_re = implode('|', $cs_pinyins);
            $districts  = District::findAll(
                ['level'=>'district', 'parent_id'=> $cids]);
            $districts_pinyins = [];
            foreach($districts as $district){
                $districts_pinyins[] = $district->seo_pinyin;
            }
            $district_re = implode('|', array_unique($districts_pinyins));
            $stypes     = ServiceType::findAll(['status'=>0]);
            $ts_pinyin  = [];
            foreach( $stypes as $type ){
                $ts_pinyin[] = $type->pinyin;
            }
            $s_re = implode('|', $ts_pinyin);
            $re = '/^(task|('.$city_re.'))\/(('.$district_re.')\/)?(('.$s_re.')\/)?(p(\d+)\/)?$/i';

            Yii::$app->cache->set($key, $re, 60*60*3);
        }
        if (preg_match($re, $path, $matches)){
            $city_pinyin = 'beijing';
            $district_pinyin = '';
            $type_pinyin = '';
            $page = '1';
            if (isset($matches[2]) && $matches[2]!='task'){
                $city_pinyin = $matches[2];
            }
            if (count($matches)>4){
                $district_pinyin = $matches[4];
            }
            if (count($matches)>6){
                $type_pinyin = $matches[6];
            }
            if (count($matches)>8){
                $page = $matches[8];
            }
            return [
                0   => 'task/index',
                1   => [
                    'city_pinyin' => $city_pinyin,
                    'district_pinyin'=> $district_pinyin,
                    'type_pinyin' => $type_pinyin,
                    'page' => $page,
                ],
            ];
        }
        return false;
    }

    public function redirectIfCitySet($path)
    {
        $city_pinyin = Yii::$app->session->get('city_pinyin');
        if( $path == '' || $path == '/' || $path == $city_pinyin ){
            if( $city_pinyin ){
                header("Location:/$city_pinyin/");
                exit;
            }else{
                return [
                    0   => 'site/citys',
                    1   => [],
                ];
            }
        }
    }
}
