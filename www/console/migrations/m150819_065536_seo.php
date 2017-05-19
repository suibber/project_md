<?php

use yii\db\Schema;
use console\BaseMigration;

class m150819_065536_seo extends BaseMigration
{
   public function up()
    {
        $sqls = "
ALTER TABLE `jz_district` ADD `seo_pinyin` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL;
UPDATE `jz_district` SET `seo_pinyin`=REPLACE(`pinyin`,' ','');
        ";
        $this->execSqls($sqls);
    }
    public function down()
    {
        return true;
    }
}
