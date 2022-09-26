<?php

use yii\db\Migration;

/**
 * Class m200526_125132_price_list
 */
class m200526_125132_price_list extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('price_list', [
            'id' => $this->primaryKey(),
            'code' => $this->string(64)->notNull(),
            'cross_type' => $this->string(64)->null(),
            'article_number' => $this->string(64)->notNull(),
            'product_code' => $this->string(64)->null(),
            'manufacturer' => $this->string(64)->notNull(),
            'quality' => $this->string(32)->null(),
            'price' => $this->string(64)->null(),
            'availability' => $this->string(32)->null(),
            'commentary' => $this->text(),
            'multiplicity' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('price_list');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200526_125132_price_list cannot be reverted.\n";

        return false;
    }
    */
}
