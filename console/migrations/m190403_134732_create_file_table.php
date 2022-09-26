<?php

use yii\db\Migration;

/**
 * Handles the creation of table `file`.
 */
class m190403_134732_create_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('file', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->defaultValue(''),
            'name' => $this->string()->notNull()->defaultValue(''),
            'path' => $this->string(),
            'description' => $this->string(512),
            'img_alt' => $this->string(512),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('file');
    }
}
