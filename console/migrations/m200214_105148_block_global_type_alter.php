<?php

use yii\db\Migration;

/**
 * Class m200214_105148_block_global_type_alter
 */
class m200214_105148_block_global_type_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockGlobalType ADD VALUE '".\common\models\Block::GLOBAL_TYPE_FORM_DIALOG_LINK."'");
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
