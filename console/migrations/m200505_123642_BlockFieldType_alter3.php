<?php

use yii\db\Migration;

/**
 * Class m200505_123642_BlockFieldType_alter3
 */
class m200505_123642_BlockFieldType_alter3 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockFieldType ADD VALUE '".\common\models\BlockField::TYPE_CONTENT_ID."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m200505_123642_BlockFieldType_alter3 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200505_123642_BlockFieldType_alter3 cannot be reverted.\n";

        return false;
    }
    */
}
