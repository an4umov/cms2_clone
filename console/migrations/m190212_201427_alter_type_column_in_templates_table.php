<?php

use yii\db\Migration;

/**
 * Class m190212_201427_alter_type_column_in_templates_table
 */
class m190212_201427_alter_type_column_in_templates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('templates', 'type', $this->string(64));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190212_201427_alter_type_column_in_templates_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190212_201427_alter_type_column_in_templates_table cannot be reverted.\n";

        return false;
    }
    */
}
