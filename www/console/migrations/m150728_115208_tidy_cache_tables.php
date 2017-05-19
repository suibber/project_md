<?php

use yii\db\Schema;
use yii\db\Migration;

class m150728_115208_tidy_cache_tables extends Migration
{
    public function up()
    {
        $this->dropTable('jz_cache_for_api');
        $this->dropTable('jz_cache_for_backend');
        $this->dropTable('jz_cache_for_frontend');
        $this->dropTable('jz_cache_for_m');
        $this->dropTable('jz_cache_for_corp');
    }

    public function down()
    {
        echo "m150728_115208_tidy_cache_tables cannot be reverted.\n";

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
