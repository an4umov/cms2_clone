<?php

use yii\db\Migration;

/**
 * Handles the creation of table `info_block`.
 */
class m190514_063629_create_info_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('info_block', [
            'id' => $this->primaryKey(),
            'color' => $this->string(),
            'type' => $this->tinyInteger(),
            'sort' => $this->tinyInteger(),
        ]);

        $this->createTable('info_block_content_item', [
            'info_block_id' => $this->integer(),
            'content_item_id' => $this->integer(),
            'PRIMARY KEY(info_block_id, content_item_id)',
        ]);

        $this->addForeignKey(
            'fk__info_block_content_item__info_block',
            'info_block_content_item',
            'info_block_id',
            'info_block',
            'id'
            );

        $this->addForeignKey(
            'fk__info_block_content_item__content_item',
            'info_block_content_item',
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
        $this->dropForeignKey('fk__info_block_content_item__info_block', 'info_block');
        $this->dropForeignKey('fk__info_block_content_item__content_item', 'content_item');
        $this->dropTable('info_block_content_item');
        $this->dropTable('info_block');
    }
}
