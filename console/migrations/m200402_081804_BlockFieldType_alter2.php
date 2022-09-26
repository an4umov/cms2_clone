<?php

use yii\db\Migration;

/**
 * Class m200402_081804_BlockFieldType_alter2
 */
class m200402_081804_BlockFieldType_alter2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockFieldType ADD VALUE '".\common\models\BlockField::TYPE_SPECIAL_GROUP."'");
        $this->execute("ALTER TYPE blockFieldType ADD VALUE '".\common\models\BlockField::TYPE_SPECIAL_FLAG."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m200402_081804_BlockFieldType_alter2 cannot be reverted.\n";

        return false;
    }
}
