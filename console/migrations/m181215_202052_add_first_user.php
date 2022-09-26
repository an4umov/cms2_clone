<?php

use yii\db\Migration;
use yii\db\Transaction;
use common\models\User;

/**
 * Class m181215_202052_add_first_user
 */
class m181215_202052_add_first_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $transaction = $this->getDb()->beginTransaction();

        $user = new User();
        $user->username = 'user';
        $user->email = 'user@lrnew.lr';
        $user->setPassword('ggffhh00kkmm');
        $user->generateAuthKey();

        if (!$user->save(false)) {
            $transaction->rollBack();
            return false;
        }
        $transaction->commit();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181215_202052_add_first_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181215_202052_add_first_user cannot be reverted.\n";

        return false;
    }
    */
}
