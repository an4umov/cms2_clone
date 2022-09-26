<?php

use yii\db\Migration;

/**
 * Class m220610_082722_cart_settings
 */
class m220610_082722_cart_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cart_settings', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(11)->null(),
            'level' => $this->integer(11)->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'image' => $this->string()->comment('Изображение для настройки'),
            'sort' => $this->integer(11),
            'is_active' => $this->boolean()->defaultValue(true)->notNull(),
            'is_collapse' => $this->boolean()->defaultValue(false)->notNull(),
            'data' => $this->text()->comment('JSON'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cart_settings');
    }
}
