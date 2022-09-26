<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tile`.
 */
class m190504_142208_create_tile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tile', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('tile_content_items', [
            'id' => $this->primaryKey(),
            'tile_id' => $this->integer()->notNull()->defaultValue(0),
            'content_item_id' => $this->integer()->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey('fk__tile_content_items__tile', 'tile_content_items', 'tile_id', 'tile', 'id');
        $this->addForeignKey('fk__tile_content_items__content_item', 'tile_content_items', 'content_item_id', 'content_item', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk__tile_content_items__tile', 'tile_content_items');
        $this->dropForeignKey('fk__tile_content_items__content_item', 'tile_content_items');

        $this->dropTable('tile_content_items');
        $this->dropTable('tile');
    }
}
