<?php

use yii\db\Migration;

/**
 * Class m200210_165442_form_content_block_type_alter
 */
class m200210_165442_form_content_block_type_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE contentBlockType ADD VALUE '".\common\models\ContentBlock::TYPE_FORM."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m200210_165442_form_content_block_type_alter cannot be reverted.\n";

        return false;
    }
}
