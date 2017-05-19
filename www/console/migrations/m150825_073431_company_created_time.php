<?php

use yii\db\Schema;
use console\BaseMigration;

class m150825_073431_company_created_time extends BaseMigration
{
    public function up()
    {
        $sqls = "
ALTER table `jz_company` ADD `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间';
            ";
        return $this->execSqls($sqls);

    }

    public function down()
    {
        return true;
    }
}
