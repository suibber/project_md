<?php

use yii\db\Schema;
use console\BaseMigration;

class m150815_090041_seo extends BaseMigration
{
   public function up()
    {
        $sqls = "
ALTER TABLE `jz_service_type` ADD `pinyin` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL;
UPDATE jz_service_type SET pinyin='chuandan' WHERE id='1';
UPDATE jz_service_type SET pinyin='jiajiao' WHERE id='2';
UPDATE jz_service_type SET pinyin='mote' WHERE id='3';
UPDATE jz_service_type SET pinyin='shixisheng' WHERE id='4';
UPDATE jz_service_type SET pinyin='linshigong' WHERE id='5';
UPDATE jz_service_type SET pinyin='it' WHERE id='6';
UPDATE jz_service_type SET pinyin='zhanhui' WHERE id='7';
UPDATE jz_service_type SET pinyin='meigong' WHERE id='8';
UPDATE jz_service_type SET pinyin='fuwuyuan' WHERE id='9';
UPDATE jz_service_type SET pinyin='fanyi' WHERE id='10';
UPDATE jz_service_type SET pinyin='jiaolian' WHERE id='11';
UPDATE jz_service_type SET pinyin='cuxiao' WHERE id='12';
UPDATE jz_service_type SET pinyin='tuiguang' WHERE id='13';
UPDATE jz_service_type SET pinyin='kefu' WHERE id='14';
UPDATE jz_service_type SET pinyin='xiaoshigong' WHERE id='15';
UPDATE jz_service_type SET pinyin='zhiyuanzhe' WHERE id='16';
UPDATE jz_service_type SET pinyin='xiaonei' WHERE id='17';
UPDATE jz_service_type SET pinyin='qita' WHERE id='18';

UPDATE jz_district SET short_pinyin='bj2' WHERE id='2541' ;
        ";
        $this->execSqls($sqls);
    }
    public function down()
    {
        return true;
    }
}
