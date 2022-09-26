<?php

use yii\db\Migration;

/**
 * Handles the creation of table `galleries_files`.
 */
class m190403_135138_create_galleries_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('galleries_files', [
            'id' => $this->primaryKey(),
            'gallery_id' => $this->integer()->notNull()->defaultValue(0),
            'file_id' => $this->integer()->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('galleries_files');
    }
}
