<?php

use yii\db\Migration;

/**
 * Class m190516_190416_add_fa_icon_colunm_to_content_item_table
 */
class m190516_190416_add_fa_icon_colunm_to_content_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('content_item', 'fa_icon', $this->string(32));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('content_item', 'fa_icon');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190516_190416_add_fa_icon_colunm_to_content_item_table cannot be reverted.\n";

        return false;
    }
    */
}
