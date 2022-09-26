<?php

use yii\db\Migration;

/**
 * Class m200318_102507_blockFieldType_alter2
 */
class m200318_102507_blockFieldType_alter2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockGlobalType ADD VALUE '".\common\models\Block::GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_2."'");
        $this->execute("ALTER TYPE blockGlobalType ADD VALUE '".\common\models\Block::GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_3."'");
        $this->execute("ALTER TYPE blockGlobalType ADD VALUE '".\common\models\Block::GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_6."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m200318_102507_blockFieldType_alter2 cannot be reverted.\n";

        return false;
    }
}
