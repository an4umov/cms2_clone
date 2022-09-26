<?php

use yii\db\Migration;

/**
 * Class m220422_114438_settings_footer
 */
class m220422_114438_settings_footer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('settings_footer', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'url' => $this->string(),
            'is_active' => $this->boolean()->defaultValue(true)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('settings_footer_item', [
            'id' => $this->primaryKey(),
            'footer_id' => $this->integer(11)->notNull(),
            'name' => $this->string()->notNull(),
            'url' => $this->string()->notNull(),
            'is_active' => $this->boolean()->defaultValue(true)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-settings_footer_item-footer_id',
            'settings_footer_item',
            'footer_id',
            'settings_footer',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TABLE settings_footer_item CASCADE');
        $this->execute('DROP TABLE settings_footer CASCADE');
    }
}
