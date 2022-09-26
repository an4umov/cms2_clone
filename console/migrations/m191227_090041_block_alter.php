<?php

use yii\db\Migration;

/**
 * Class m191227_090041_block_alter
 */
class m191227_090041_block_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockGlobalType ADD VALUE '".\common\models\Block::GLOBAL_TYPE_BANNER_AGREEMENT."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m191227_090041_block_alter cannot be reverted.\n";

        return false;
    }
}
