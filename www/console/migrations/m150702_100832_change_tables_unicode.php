<?php

use yii\db\Schema;
use console\BaseMigration;

class m150702_100832_change_tables_unicode extends BaseMigration
{
    public function up()
    {
        $sqls = "
       alter table jz_address                      convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_app_release_version       convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_auth_assignment           convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_auth_item                 convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_auth_item_child           convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_auth_rule                 convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_cache_for_api             convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_cache_for_backend         convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_cache_for_frontend        convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_cache_for_m               convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_company                   convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_device                    convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_district                  convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_freetime                  convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_message                   convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_migration                 convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_resume                    convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_service_type              convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_service_types_of_orders   convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_session                   convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_sys_message               convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_task                      convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_task_address              convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_task_applicant            convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_task_collection           convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_user                      convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_user_has_service_type     convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_user_readed_sys_message   convert to character set utf8 collate utf8_unicode_ci;
       alter table jz_weichat_user_info         convert to character set utf8 collate utf8_unicode_ci;
            ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150704_103032_change_tables_unicode cannot be reverted.\n";

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
