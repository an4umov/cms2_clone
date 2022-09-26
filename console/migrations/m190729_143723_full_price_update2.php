<?php

use yii\db\Migration;

/**
 * Class m190729_143723_full_price_update2
 */
class m190729_143723_full_price_update2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('full_price', 'type_price_list', $this->string(9)->null());
        $this->addColumn('full_price', 'color', $this->string(7)->null());
        $this->addColumn('full_price', 'group_price_list', $this->string(150)->null());
        $this->addColumn('full_price', 'group_price_list_color', $this->string(7)->null());
        $this->addColumn('full_price', 'sale_color', $this->string(7)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('full_price', 'type_price_list');
        $this->dropColumn('full_price', 'color');
        $this->dropColumn('full_price', 'group_price_list');
        $this->dropColumn('full_price', 'group_price_list_color');
        $this->dropColumn('full_price', 'sale_color');
    }
}
