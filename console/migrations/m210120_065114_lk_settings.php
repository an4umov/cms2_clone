<?php

use yii\db\Migration;

/**
 * Class m210120_065114_lk_settings
 */
class m210120_065114_lk_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('lk_settings', [
            'id' => $this->primaryKey(),
            'delivery_address' => $this->string(),
            'contractor_entity' => $this->string(),
            'contractor_person' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('lk_settings');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210120_065114_lk_settings cannot be reverted.\n";

        return false;
    }
    */
}
