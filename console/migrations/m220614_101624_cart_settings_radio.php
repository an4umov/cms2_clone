<?php

use yii\db\Migration;

/**
 * Class m220614_101624_cart_settings_radio
 */
class m220614_101624_cart_settings_radio extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\CartSettings::tableName(), 'radio_text', $this->string()->comment('Описание радио кнопки в 4 уровне'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\CartSettings::tableName(), 'radio_text');
    }
}
