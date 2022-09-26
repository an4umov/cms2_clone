<?php

use yii\db\Migration;

/**
 * Class m200115_122521_reference_groups
 */
class m200115_122521_reference_groups extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('reference_delivery_group', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'description' => $this->text(),
            'icon' => $this->string(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('reference_payment_group', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'description' => $this->text(),
            'icon' => $this->string(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('reference_delivery_group');
        $this->dropTable('reference_payment_group');
    }
}
