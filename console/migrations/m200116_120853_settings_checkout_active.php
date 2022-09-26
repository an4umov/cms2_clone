<?php

use yii\db\Migration;

/**
 * Class m200116_120853_settings_checkout_active
 */
class m200116_120853_settings_checkout_active extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('settings_checkout', 'is_active', $this->boolean()->defaultValue(true));
        $this->addColumn('settings_checkout_buyer', 'is_active', $this->boolean()->defaultValue(true));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('settings_checkout', 'is_active');
        $this->dropColumn('settings_checkout_buyer', 'is_active');
    }
}
