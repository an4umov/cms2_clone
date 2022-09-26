<?php

use yii\db\Migration;

/**
 * Class m200214_111125_blockFieldType_alter
 */
class m200214_111125_blockFieldType_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockFieldType ADD VALUE '".\common\models\BlockField::TYPE_FORMS."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m200214_111125_blockFieldType_alter cannot be reverted.\n";

        return false;
    }
}
