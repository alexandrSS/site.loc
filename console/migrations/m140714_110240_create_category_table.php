<?php

use yii\db\Schema;
use yii\db\Migration;

class m140714_110240_create_category_table extends Migration
{
    public function safeUp()
    {
        // Настройка MySql таблицы
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        // Таблица категорий
        $this->createTable('{{%category%}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'parent_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'alias' => Schema::TYPE_STRING . '(255) NOT NULL',
            'view' => 'tinyint(4) NOT NULL',
            'position' => 'tinyint(4) NOT NULL',
            'status' => 'tinyint(4) NOT NULL',
            'created' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated' => Schema::TYPE_INTEGER . ' NOT NULL',
            'meta_title' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
            'meta_keywords' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
            'meta_description' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
        ], $tableOptions);

        // Индексы
        $this->createIndex('parent_id', '{{%category%}}', 'parent_id');


    }

    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }
}
