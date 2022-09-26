<?php

use yii\db\Migration;

/**
 * Class m190729_115441_full_price_update
 */
class m190729_115441_full_price_update extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('full_price', 'delivery', $this->string(20)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('full_price', 'delivery');
    }
}
