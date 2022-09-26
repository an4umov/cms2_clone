<?php

use yii\db\Migration;

/**
 * Class m200627_092614_order
 */
class m200627_092614_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->null(),
            'comment' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('order_item', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'article_number' => $this->string(64)->notNull(),
            'price' => $this->decimal(10, 2)->null(),
            'quantity' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-order_item-order_id',
            'order_item',
            'order_id',
            'order',
            'id',
            'CASCADE'
        );

        $this->addColumn(\common\models\PriceList::tableName(), 'key', $this->string(\common\models\PriceList::KEY_LENGTH));
        $this->createIndex('price_list-key-uniq', \common\models\PriceList::tableName(), 'key', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-order_item-order_id',
            'order_item'
        );

        $this->dropTable('order');
        $this->dropTable('order_item');

        $this->dropIndex('price_list-key-uniq', \common\models\PriceList::tableName());
        $this->dropColumn(\common\models\PriceList::tableName(), 'key');
    }
}
