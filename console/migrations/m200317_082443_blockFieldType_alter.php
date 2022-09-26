<?php

use yii\db\Migration;

/**
 * Class m200317_082443_blockFieldType_alter
 */
class m200317_082443_blockFieldType_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockFieldType ADD VALUE '".\common\models\BlockField::TYPE_DEPARTMENTS."'");
        $this->execute("ALTER TYPE blockGlobalType ADD VALUE '".\common\models\Block::GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_1."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m200317_082443_blockFieldType_alter cannot be reverted.\n";

        return false;
    }
}
