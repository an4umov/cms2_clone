<?php

use yii\db\Migration;

/**
 * Class m211129_073444_department_url_alter
 */
class m211129_073444_department_url_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(\common\models\Department::tableName(), 'url', $this->string(150)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn(\common\models\Department::tableName(), 'url', $this->string(25)->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211129_073444_department_url_alter cannot be reverted.\n";

        return false;
    }
    */
}
