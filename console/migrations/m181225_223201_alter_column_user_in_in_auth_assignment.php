<?php

use yii\db\Migration;

/**
 * Class m181225_223201_alter_column_user_in_in_auth_assignment
 */
class m181225_223201_alter_column_user_in_in_auth_assignment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('auth_assignment', 'user_id', "integer USING (user_id::integer)");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181225_223201_alter_column_user_in_in_auth_assignment cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181225_223201_alter_column_user_in_in_auth_assignment cannot be reverted.\n";

        return false;
    }
    */
}
