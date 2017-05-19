<?php

use yii\db\Schema;
use console\BaseMigration;

class m150909_131917_app_openid extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_weichat_user_info add `app_openid` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'app应用的 openid';
            alter table jz_weichat_user_info add `unionid` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'unionid';
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150909_131917_app_openid cannot be reverted.\n";

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
