<?php

use yii\db\Migration;

/**
 * Handles adding type to table `shop_banner`.
 */
class m190414_215912_add_type_column_to_shop_banner_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('shop_banner', 'type', $this->tinyInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('shop_banner', 'type');
    }
}
