<?php

use yii\db\Migration;

/**
 * Class m190411_203151_add_columns_to_menu_table
 */
class m190411_203151_add_columns_to_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('menu', 'h1', $this->string());
        $this->addColumn('menu', 'meta_keywords', $this->string());
        $this->addColumn('menu', 'meta_description', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('menu', 'h1');
        $this->dropColumn('menu', 'meta_keywords');
        $this->dropColumn('menu', 'meta_description');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190411_203151_add_columns_to_menu_table cannot be reverted.\n";

        return false;
    }
    */
}
