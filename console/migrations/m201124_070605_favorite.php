<?php

use yii\db\Migration;

/**
 * Class m201124_070605_favorite
 */
class m201124_070605_favorite extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('favorite', [
            'id'                => $this->primaryKey(),
            'user_id'           => $this->integer()->notNull(),
            'price_list_id'     => $this->integer()->notNull(),
            'price_list_key'    => $this->string(10)->notNull(),
            'created_at'        => $this->integer(),
        ]);

        $this->addForeignKey("fk-favorite-user_id", "favorite", 'user_id', 'user', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('favorite');
    }
}
