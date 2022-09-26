<?php

use yii\db\Migration;

/**
 * Class m191004_073541_block_field_type_alues
 */
class m191004_073541_block_field_type_alues extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockFieldType ADD VALUE '".\common\models\BlockField::TYPE_VALUES_LIST."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m191004_073541_block_field_type_alues cannot be reverted.\n";

        return false;
    }
}
