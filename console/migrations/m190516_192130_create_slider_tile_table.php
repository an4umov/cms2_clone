<?php

use yii\db\Migration;

/**
 * Handles the creation of table `slider_tile`.
 */
class m190516_192130_create_slider_tile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('slider_tile', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        $this->createTable('slider_tile_content_item', [
            'slider_tile_id' => $this->integer(),
            'content_item_id' => $this->integer(),
            'PRIMARY KEY(slider_tile_id, content_item_id)',
        ]);

        $this->addForeignKey(
            'fk__slider_tile_content_item__slider_tile',
            'slider_tile_content_item',
            'slider_tile_id',
            'slider_tile',
            'id'
        );

        $this->addForeignKey(
            'fk__slider_tile_content_item__content_item',
            'slider_tile_content_item',
            'content_item_id',
            'content_item',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk__slider_tile_content_item__content_item', 'slider_tile_content_item');
        $this->dropForeignKey('fk__slider_tile_content_item__slider_tile', 'slider_tile_content_item');
        $this->dropTable('slider_tile_content_item');
        $this->dropTable('slider_tile');
    }
}
