<?php

use yii\db\Migration;

/**
 * Class m201009_080039_BlockFieldType_alter4
 */
class m201009_080039_BlockFieldType_alter4 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockFieldType ADD VALUE '".\common\models\BlockField::TYPE_STRUCTURE_ID."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m201009_080039_BlockFieldType_alter4 cannot be reverted.\n";

        return false;
    }
}
