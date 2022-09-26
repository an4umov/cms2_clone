<?php

use yii\db\Migration;

/**
 * Class m191011_152917_block_type_setting
 */
class m191011_152917_block_type_setting extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockType ADD VALUE '".\common\models\Block::TYPE_SETTING."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m191011_152917_block_type_setting cannot be reverted.\n";

        return false;
    }
}
