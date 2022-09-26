<?php

use yii\db\Migration;

/**
 * Class m200114_144543_settings_checkout
 */
class m200114_144543_settings_checkout extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('settings_checkout', [
            'id' => $this->primaryKey(),
            'reference_partner_id' => $this->integer(),
            'data' => $this->text()->comment('JSON'),
            'is_default' => $this->boolean()->notNull()->defaultValue(false)->comment('Может быть только один'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('settings_checkout-reference_partner_id-idx', 'settings_checkout', 'reference_partner_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('settings_checkout-reference_partner_id-idx', 'settings_checkout');
        $this->dropTable('settings_checkout');
    }
}
