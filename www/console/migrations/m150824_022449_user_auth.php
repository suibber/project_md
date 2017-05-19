<?php

use yii\db\Schema;
use console\BaseMigration;

class m150824_022449_user_auth extends BaseMigration
{
    public function up()
    {
        $sqls = "
ALTER TABLE `jz_resume` ADD `gov_id_pic_front` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `jz_resume` ADD `gov_id_pic_back` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `jz_resume` ADD `gov_id_pic_take` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `jz_resume` ADD `exam_status` smallint(6) NOT NULL DEFAULT '0';
ALTER TABLE `jz_resume` ADD `exam_note` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL;
            ";
        return $this->execSqls($sqls);

    }

    public function down()
    {
        return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
