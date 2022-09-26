<?php

use yii\db\Migration;

/**
 * Class m200929_084013_block_field_alter_type
 */
class m200929_084013_block_field_alter_type extends Migration
{
    public function up()
    {
        $this->execute("ALTER TYPE blockFieldType ADD VALUE '".\common\models\BlockField::TYPE_GRADIENT_COLOR."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m200929_084013_block_field_alter_type cannot be reverted.\n";

        return false;
    }
}
