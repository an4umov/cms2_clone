<?php

use yii\db\Migration;

/**
 * Handles the creation of table `shop_banner`.
 */
class m190414_215221_create_shop_banner_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('shop_banner', [
            'id' => $this->primaryKey(),
            'color' => $this->string(10),
            'image' => $this->integer(),
            'title' => $this->string(),
            'description' => $this->string(),
            'sort' => $this->tinyInteger()
        ]);

        $this->addForeignKey('fk__shop_banner__files', 'shop_banner', 'image', 'file', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk__shop_banner__files', 'shop_banner');
        $this->dropTable('shop_banner');
    }
}
