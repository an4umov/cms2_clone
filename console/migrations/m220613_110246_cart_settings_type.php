<?php

use yii\db\Migration;

/**
 * Class m220613_110246_cart_settings_type
 */
class m220613_110246_cart_settings_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE cartSettingsType AS ENUM ('cart', 'customer', 'delivery', 'payment', 'confirmation')");
        $this->addColumn(\common\models\CartSettings::tableName(), 'type', "cartSettingsType");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TYPE cartSettingsType CASCADE');

        $this->dropColumn(\common\models\CartSettings::tableName(), 'type');
    }
}
