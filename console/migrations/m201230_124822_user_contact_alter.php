<?php

use yii\db\Migration;

/**
 * Class m201230_124822_user_contact_alter
 */
class m201230_124822_user_contact_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn(\common\models\UserContact::tableName(), 'is_main_contractor');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201230_124822_user_contact_alter cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201230_124822_user_contact_alter cannot be reverted.\n";

        return false;
    }
    */
}
