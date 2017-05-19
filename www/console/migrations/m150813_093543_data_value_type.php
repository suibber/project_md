<?php

use yii\db\Schema;
use console\BaseMigration;

class m150813_093543_data_value_type extends BaseMigration
{
   public function up()
    {
        $sqls = "
ALTER TABLE `jz_data_daily` MODIFY COLUMN `value` VARCHAR(100);
        ";
        $this->execSqls($sqls);
    }
    public function down()
    {
        return true;
    }
}
