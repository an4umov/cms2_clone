<?php

use yii\db\Migration;

/**
 * Class m200116_093320_settings_checkout_buyer
 */
class m200116_093320_settings_checkout_buyer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('settings_checkout_buyer', [
            'id' => $this->primaryKey(),
            'settings_checkout_id' => $this->integer(11)->notNull(),
            'reference_buyer_id' => $this->integer(11)->notNull(),
            'data' => $this->text()->comment('JSON'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('settings_checkout_buyer-settings_checkout_id-idx', 'settings_checkout_buyer', 'settings_checkout_id');
        $this->createIndex('settings_checkout_buyer-reference_buyer_id-idx', 'settings_checkout_buyer', 'reference_buyer_id');

        $this->dropColumn('settings_checkout', 'data');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('settings_checkout_buyer-settings_checkout_id-idx', 'settings_checkout_buyer');
        $this->dropIndex('settings_checkout_buyer-reference_buyer_id-idx', 'settings_checkout_buyer');
        $this->dropTable('settings_checkout_buyer');

        $this->addColumn('settings_checkout', 'data', $this->text()->comment('JSON'));
    }
}
