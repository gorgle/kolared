<?php

use yii\db\Migration;

class m170307_112323_auth_rules extends Migration
{
    public function up()
    {
        $tableOptions = $this->db->driverName === 'mysql'
            ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'
            : null;

        $this->createTable(
            '{{%auth_rule}}',
            [
                'name' => 'VARCHAR(64) NOT NULL PRIMARY KEY',
                'data' => 'TEXT',
                'created_at' => 'INT DEFAULT NULL',
                'updated_at' => 'INT DEFAULT NULL',
            ],
            $tableOptions
        );

        $this->createTable(
            '{{%auth_item}}',
            [
                'name' => 'VARCHAR(64) NOT NULL PRIMARY KEY',
                'type' => 'INT NOT NULL',
                'description' => 'TEXT',
                'rule_name' => 'VARCHAR(64)',
                'data' => 'TEXT',
                'created_at' => 'INT DEFAULT NULL',
                'updated_at' => 'INT DEFAULT NULL',
                'KEY `rule_name` (`rule_name`)',
                'KEY `type` (`type`)',
                'CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`)
                    REFERENCES {{%auth_rule}} (`name`) ON DELETE SET NULL ON UPDATE CASCADE'
            ],
            $tableOptions
        );

        $this->createTable(
            '{{%auth_item_child}}',
            [
                'parent' => 'VARCHAR(64) NOT NULL',
                'child' => 'VARCHAR(64) NOT NULL',
                'PRIMARY KEY (`parent`, `child`)',
                'KEY `child` (`child`)',
                'CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`)
            REFERENCES {{%auth_item}} (`name`) ON DELETE CASCADE ON UPDATE CASCADE',
                'CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`)
            REFERENCES {{%auth_item}} (`name`) ON DELETE CASCADE ON UPDATE CASCADE',
            ],
            $tableOptions
        );

        $this->createTable(
            '{{%auth_assignment}}',
            [
                'item_name' => 'VARCHAR(64) NOT NULL',
                'user_id' => 'VARCHAR(64) NOT NULL',
                'created_at' => 'INT DEFAULT NULL',
                'updated_at' => 'INT DEFAULT NULL',
                'rule_name' => 'VARCHAR(64) DEFAULT NULL',
                'data' => 'TEXT',
                'PRIMARY KEY (`item_name`, `user_id`)',
                'KEY `rule_name` (`rule_name`)',
                'CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`)
            REFERENCES {{%auth_item}} (`name`) ON DELETE CASCADE ON UPDATE CASCADE',
                'CONSTRAINT `auth_assignment_ibfk_2` FOREIGN KEY (`rule_name`)
            REFERENCES {{%auth_rule}} (`name`) ON DELETE SET NULL ON UPDATE CASCADE',
            ],
            $tableOptions
        );

        $this->createTable(
            '{{%user_service}}',
            [
                'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
                'user_id' => 'INT UNSIGNED NOT NULL',
                'service_type' => 'VARCHAR(255) NOT NULL',
                'service_id' => 'VARCHAR(255) NOT NULL',
                'KEY `ix-user_service-user_id` (`user_id`)',
                'UNIQUE KEY `uq-user-service-service_type-service_id` (`service_type`, `service_id`)',
            ],
            $tableOptions
        );
    }

    public function down()
    {
         $this->dropTable('{{%auth_rule}}');
         $this->dropTable('{{%auth_item}}');
         $this->dropTable('{{%auth_item_child}}');
         $this->dropTable('{{%auth_assignment}}');
         $this->dropTable('user_service');
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
