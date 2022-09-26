<?php

use yii\db\Migration;

/**
 * Class m210401_111158_price_alter
 */
class m210401_111158_price_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropIndex('price-supplier_id-article-uniq-idx', 'price');

        $this->createIndex('price-supplier_id-article-idx', 'price', ['supplier_id', 'article',]);
        $this->createIndex('price-supplier_id-name-idx', 'price', ['supplier_id', 'name',]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210401_111158_price_alter cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210401_111158_price_alter cannot be reverted.\n";

        return false;
    }
    */
}
