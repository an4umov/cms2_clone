<?php

use yii\db\Migration;

/**
 * Class m200325_115600_BlockFieldType_alter
 */
class m200325_115600_BlockFieldType_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockFieldType ADD VALUE '".\common\models\BlockField::TYPE_MANUFACTURERS."'");
        $this->execute("ALTER TYPE blockFieldType ADD VALUE '".\common\models\BlockField::TYPE_FULL_PRICE_TAGS."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m200325_115600_BlockFieldType_alter cannot be reverted.\n";

        return false;
    }
}
