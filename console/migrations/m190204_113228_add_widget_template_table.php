<?php

use yii\db\Migration;

/**
 * Class m190204_113228_add_widget_template_table
 */
class m190204_113228_add_widget_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('widget_template', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'content' => $this->text(),
            'fields' => $this->json()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('widget_template');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190204_113228_add_widget_template_table cannot be reverted.\n";

        return false;
    }
    */
}
