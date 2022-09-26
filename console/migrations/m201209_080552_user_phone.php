<?php

use yii\db\Migration;

/**
 * Class m201209_080552_user_phone
 */
class m201209_080552_user_phone extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\User::tableName(), 'phone', $this->string(25)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\User::tableName(), 'phone');
    }
}
