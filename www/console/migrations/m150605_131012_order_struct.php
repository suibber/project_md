<?php

use yii\db\Schema;
use console\BaseMigration;

class m150605_131012_order_struct extends BaseMigration
{
    public function up()
    {
        $sqls = "
CREATE TABLE IF NOT EXISTS `jz_task` (
  `id` INT NOT NULL,
  `title` VARCHAR(500) NULL COMMENT '标题',
  `clearance_period` SMALLINT NULL COMMENT '结算方式',
  `salary` DECIMAL(10,2) NOT NULL COMMENT '薪资',
  `salary_unit` SMALLINT NOT NULL COMMENT '薪资单位',
  `salary_note` TEXT NULL COMMENT '薪资说明',
  `from_date` DATE NOT NULL COMMENT '开始日期',
  `to_date` DATE NOT NULL COMMENT '结束日期',
  `from_time` TIME NULL COMMENT '上班时间',
  `to_time` TIME NULL COMMENT '下班时间',
  `need_quantity` INT NOT NULL,
  `got_quantity` INT NOT NULL DEFAULT 0,
  `created_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_time` TIMESTAMP NULL COMMENT '修改时间',
  `detail` TEXT NOT NULL COMMENT '工作内容',
  `requirement` TEXT NULL COMMENT '其他要求',
  `address_id` INT NOT NULL COMMENT '地址',
  `user_id` INT NOT NULL COMMENT '发布人',
  `service_type_id` INT NOT NULL COMMENT '服务类型',
  `gender_requirement` SMALLINT NULL COMMENT '性别',
  `degree_requirement` SMALLINT NULL COMMENT '学历',
  `age_requirement` SMALLINT NULL COMMENT '年龄',
  `height_requirement` SMALLINT NULL COMMENT '身高',
  `status` SMALLINT NOT NULL DEFAULT 0 COMMENT '状态',
  `city_id` SMALLINT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_jz_order_jz_address1_idx` (`address_id` ASC),
  INDEX `fk_jz_order_jz_user1_idx` (`user_id` ASC),
  INDEX `fk_jz_order_jz_service_type1_idx` (`service_type_id` ASC),
  INDEX `fk_jz_order_jz_city1_idx` (`city_id` ASC)
) ENGINE = InnoDB ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        return $this->dropTable('jz_task');
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
