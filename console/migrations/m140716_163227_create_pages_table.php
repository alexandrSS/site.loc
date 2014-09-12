<?php

use yii\db\Schema;
use yii\db\Migration;

class m140716_163227_create_pages_table extends Migration
{
    public function safeUp()
    {
        // Настройка MySql таблицы
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        // Таблица страниц
        $this->createTable('{{%pages%}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'alias' => Schema::TYPE_STRING . '(255) NOT NULL',
            'author_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'snippet' => Schema::TYPE_TEXT . ' DEFAULT NULL',
            'content' => 'longtext NOT NULL',
            'status' => 'tinyint(4) NOT NULL',
            'created' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated' => Schema::TYPE_INTEGER . ' NOT NULL',
            'meta_title' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
            'meta_keywords' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
            'meta_description' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
        ], $tableOptions);

        // Индексы
        $this->createIndex('author_id', '{{%pages%}}', 'author_id');

        // Связи
        $this->addForeignKey('FK_pages_author', '{{%pages%}}', 'author_id', '{{%user%}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%pages%}}');
    }
}