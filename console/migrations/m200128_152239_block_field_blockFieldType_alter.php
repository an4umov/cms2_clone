<?php

use yii\db\Migration;

/**
 * Class m200128_152239_block_field_blockFieldType_alter
 */
class m200128_152239_block_field_blockFieldType_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockFieldType ADD VALUE '".\common\models\BlockField::TYPE_TAGS."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m200128_152239_block_field_blockFieldType_alter cannot be reverted.\n";

        return false;
    }
}
