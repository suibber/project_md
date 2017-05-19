<?php

use yii\db\Schema;
use console\BaseMigration;

class m150906_105230_wechat_push extends BaseMigration
{
    public function up()
    {
        $sqls = "
ALTER TABLE `jz_weichat_push_quality_task` ADD `work_time` VARCHAR(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '工作时间';
ALTER TABLE `jz_weichat_push_quality_task` ADD `work_detail` VARCHAR(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '工作内容';
            ";
        return $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150906_105230_wechat_push cannot be reverted.\n";

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
