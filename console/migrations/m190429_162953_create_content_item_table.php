<?php

use yii\db\Migration;

/**
 * Handles the creation of table `content_item`.
 */
class m190429_162953_create_content_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('content_item', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'content' => $this->text(),
            'type' => $this->tinyInteger(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        $this->createTable('composite', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'type' => $this->tinyInteger(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('composite_content_items', [
            'id' => $this->primaryKey(),
            'composite_id' => $this->integer()->notNull()->defaultValue(0),
            'content_item_id' => $this->integer()->notNull()->defaultValue(0),
        ]);

        $this->createTable('composite_file', [
            'id' => $this->primaryKey(),
            'composite_id' => $this->integer()->notNull()->defaultValue(0),
            'file_id' => $this->integer()->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey('fk__composite_content_items__composite', 'composite_content_items', 'composite_id', 'composite', 'id');
        $this->addForeignKey('fk__composite_content_items__content_item', 'composite_content_items', 'content_item_id', 'content_item', 'id');

        $this->addForeignKey('fk__composite_file__composite', 'composite_file', 'composite_id', 'composite', 'id');
        $this->addForeignKey('fk__composite_file__file', 'composite_file', 'file_id', 'file', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk__composite_content_items__composite', 'composite_content_items');
        $this->dropForeignKey('fk__composite_content_items__content_item', 'composite_content_items');

        $this->dropForeignKey('fk__composite_file__composite', 'composite_file');
        $this->dropForeignKey('fk__composite_file__file', 'composite_file');

        $this->dropTable('content_item');
        $this->dropTable('composite');
        $this->dropTable('composite_files');
    }
}
