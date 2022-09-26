<?php

use yii\db\Migration;

/**
 * Class m200324_125139_blockglobaltype_alter
 */
class m200324_125139_blockglobaltype_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockGlobalType ADD VALUE '".\common\models\Block::GLOBAL_TYPE_AGGREGATOR_SPECIAL_OFFER."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m200318_102507_blockFieldType_alter2 cannot be reverted.\n";

        return false;
    }
}
