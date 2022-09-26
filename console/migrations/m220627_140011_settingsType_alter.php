<?php

use yii\db\Migration;

/**
 * Class m220627_140011_settingsType_alter
 */
class m220627_140011_settingsType_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE settingsType ADD VALUE '".\common\models\Settings::TYPE_CART."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m220627_140011_settingsType_alter cannot be reverted.\n";

        return false;
    }
}
