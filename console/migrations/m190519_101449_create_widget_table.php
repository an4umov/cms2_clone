<?php

use yii\db\Migration;

/**
 * Handles the creation of table `widget`.
 */
class m190519_101449_create_widget_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('widget', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->string(),
            'text' => $this->text(),
            'type' => $this->tinyInteger(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('widget_content_item', [
            'widget_id' => $this->integer(),
            'content_item_id' => $this->integer(),
            'PRIMARY KEY(widget_id, content_item_id)',
        ]);

        $this->addForeignKey(
            'fk__widget_content_item__widget',
            'widget_content_item',
            'widget_id',
            'widget',
            'id'
        );

        $this->addForeignKey(
            'fk__widget_content_item__content_item',
            'widget_content_item',
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
        $this->dropForeignKey('fk__widget_content_item__widget','widget_content_item');
        $this->dropForeignKey('fk__widget_content_item__content_item','widget_content_item');

        $this->dropTable('widget_content_item');
        $this->dropTable('widget');
    }
}
