<?php

use yii\db\Migration;

/**
 * Handles the creation of table `gallery_content_item`.
 * Has foreign keys to the tables:
 *
 * - `gallery`
 * - `content_item`
 */
class m190610_214151_create_junction_table_for_gallery_and_content_item_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('gallery_content_item', [
            'gallery_id' => $this->integer(),
            'content_item_id' => $this->integer(),
            'PRIMARY KEY(gallery_id, content_item_id)',
        ]);

        // creates index for column `gallery_id`
        $this->createIndex(
            'idx-gallery_content_item-gallery_id',
            'gallery_content_item',
            'gallery_id'
        );

        // add foreign key for table `gallery`
        $this->addForeignKey(
            'fk-gallery_content_item-gallery_id',
            'gallery_content_item',
            'gallery_id',
            'gallery',
            'id',
            'CASCADE'
        );

        // creates index for column `content_item_id`
        $this->createIndex(
            'idx-gallery_content_item-content_item_id',
            'gallery_content_item',
            'content_item_id'
        );

        // add foreign key for table `content_item`
        $this->addForeignKey(
            'fk-gallery_content_item-content_item_id',
            'gallery_content_item',
            'content_item_id',
            'content_item',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `gallery`
        $this->dropForeignKey(
            'fk-gallery_content_item-gallery_id',
            'gallery_content_item'
        );

        // drops index for column `gallery_id`
        $this->dropIndex(
            'idx-gallery_content_item-gallery_id',
            'gallery_content_item'
        );

        // drops foreign key for table `content_item`
        $this->dropForeignKey(
            'fk-gallery_content_item-content_item_id',
            'gallery_content_item'
        );

        // drops index for column `content_item_id`
        $this->dropIndex(
            'idx-gallery_content_item-content_item_id',
            'gallery_content_item'
        );

        $this->dropTable('gallery_content_item');
    }
}
