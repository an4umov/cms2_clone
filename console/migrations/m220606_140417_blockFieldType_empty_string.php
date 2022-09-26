<?php

use yii\db\Migration;

/**
 * Class m220606_140417_blockFieldType_empty_string
 */
class m220606_140417_blockFieldType_empty_string extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockGlobalType ADD VALUE '".\common\models\Block::GLOBAL_TYPE_TEXT_EMPTY_STRING."'");
    }


    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m220606_140417_blockFieldType_empty_string cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220606_140417_blockFieldType_empty_string cannot be reverted.\n";

        return false;
    }
    */
}
