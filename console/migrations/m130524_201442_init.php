<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            "`avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL",
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            "`gender` enum('0','1','2') COLLATE utf8_unicode_ci DEFAULT '0'",
            "`first_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL",
            "`last_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL",
            "`mobile` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL",
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->insert('{{%user}}',[
            'id' => 1,
            'username' => 'admin123',
            'avatar' => NULL,
            'auth_key' => '',
            'password_hash' => '$2y$13$yCCgyG0OnsrVy8dNJINl5.X/vBoinpZ4WXBVcjPS98jvWtK.RWC72',
            'password_reset_token' => NULL,
            'email' => 'gorgle@sina.com',
            'gender' => '0',
            'first_name' => NULL,
            'last_name' => NULL,
            'mobile' => NULL,
            'status' => 10,
            'created_at' => 1462425698,
            'updated_at' => 1489571053
        ]);

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
        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey(11),
            'title' => 'varchar(200) DEFAULT NULL',
            'desccription' => 'varchar(200) DEFAULT NULL',
            'created_at' => 'int(11) DEFAULT NULL',
            'updated_at' => 'int(11) DEFAULT NULL',
        ], $tableOptions);

        $this->createTable('{{%composition}}', [
            'id' => $this->primaryKey(11),
            'title' => 'varchar(200) DEFAULT NULL',
            'desc' => 'varchar(200) DEFAULT NULL',
            'created_at' => 'int(11) DEFAULT NULL',
            'updated_at' => 'int(11) DEFAULT NULL',
        ], $tableOptions);

        $this->createTable('{{%block}}', [
            'id' => $this->primaryKey(11),
            'page_id' => 'int(11) NOT NULL',
            'composition_id' => 'int(11) DEFAULT NULL',
            'title' => 'varchar(100) DEFAULT NULL',
            'overview' => 'varchar(255) DEFAULT NULL',
            'description' => 'text',
            'image_1' => 'varchar(200) DEFAULT NULL',
            'image_2' => 'varchar(200) DEFAULT NULL',
            'image_3' => 'varchar(200) DEFAULT NULL',
            'background' => 'varchar(200) DEFAULT NULL',
            'order' => 'smallint(4) DEFAULT NULL',
            'is_show' => ' tinyint(1) DEFAULT NULL',
            'created_at' => 'int(11) DEFAULT NULL',
            'updated_at' => 'int(11) DEFAULT NULL',
            'KEY `pindex` (`page_id`)',
            'KEY `cindex` (`composition_id`)',
            'CONSTRAINT `f_k_composition` FOREIGN KEY (`composition_id`) REFERENCES {{%composition}} (`id`) ON DELETE CASCADE',
            'CONSTRAINT `f_k_page` FOREIGN KEY (`page_id`) REFERENCES {{%page}} (`id`) ON DELETE CASCADE'
        ], $tableOptions);

        $this->createTable('{{%page_items}}',[
            'page_id' => $this->primaryKey(11),
            'composition_id' => 'int(11)',
            'block_id' => 'int(11)',
            'order' => 'smallint(4)',
            'is_show' => 'tinyint(1) NOT NULL default 1',
            'CONSTRAINT `f_k_page_d1` FOREIGN KEY (`page_id`) REFERENCES {{%page}} (`id`) ON DELETE CASCADE',
            'CONSTRAINT `f_k_composition_d1` FOREIGN KEY (`composition_id`) REFERENCES {{%composition}} (`id`) ON DELETE CASCADE'
        ],$tableOptions);

        $this->createTable('{{%backend_menu}}', [
            "`id` int(10) unsigned NOT NULL AUTO_INCREMENT",
            "`parent_id` int(10) unsigned DEFAULT '0'",
            "`name` varchar(255) COLLATE utf8_unicode_ci NOT NULL",
            "`route` varchar(255) COLLATE utf8_unicode_ci NOT NULL",
            "`icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL",
            "`sort_order` int(10) unsigned DEFAULT '0'",
            "`added_by_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL",
            "`rbac_check` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL",
            "`css_class` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL",
            "`translation_category` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'app'",
            "PRIMARY KEY(`id`)",
            "KEY `ix-backendmenu-parent_id` (`parent_id`)"
        ], $tableOptions);

        $this->batchInsert('{{%backend_menu}}',[
            'id','parent_id','name','route','icon','sort_order','added_by_ext','rbac_check','css_class','translation_category'
        ],[
            [1,0,'Root','/backend/',NULL,0,'core',NULL,NULL,'app'],
            [2,1,'Dashboard','dashboard/index','dashboard',0,'core','administrate',NULL,'app'],
            [3,1,'Products','shop/backend-product/index','list',0,'core','product manage',NULL,'app'],
            [4,1,'Pages','page/index','pages',0,'core','content manage',NULL,'app'],
            [5,1,'Users','user/default/index','person',0,'core','user manage',NULL,'app'],
            [6,1,'RBAC','user/rbac/index','lock',0,'core','user manage',NULL,'app']
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%page_items}}');
        $this->dropTable('{{%page}}');
        $this->dropTable('{{%composition}}');
        $this->dropTable('{{%block}}');
        $this->dropTable('{{%auth_rule}}');
        $this->dropTable('{{%auth_item}}');
        $this->dropTable('{{%auth_item_child}}');
        $this->dropTable('{{%auth_assignment}}');
        $this->dropTable('{{%user_service}}');
        $this->dropTable('{{%backend_menu}}');
    }
}
