<?php

use yii\db\Migration;

/**
 * Class m210118_113654_favorite2
 */
class m210118_113654_favorite2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('favorite', 'price_list_id');
        $this->dropColumn('favorite', 'price_list_key');

        $this->addColumn('favorite', 'articles_id', $this->integer()->notNull());
        $this->addColumn('favorite', 'articles_number', $this->string(10)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210118_113654_favorite2 cannot be reverted.\n";

        return false;
    }
}
