<?php

use yii\db\Migration;

/**
 * Class m191225_145913_blockGlobalType_alter
 */
class m191225_145913_blockGlobalType_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockGlobalType ADD VALUE '".\common\models\Block::GLOBAL_TYPE_BANNER_HOMEPAGE_2_4."'");
        $this->execute("ALTER TYPE blockGlobalType ADD VALUE '".\common\models\Block::GLOBAL_TYPE_BANNER_HOMEPAGE_6_6."'");
        $this->execute("ALTER TYPE blockGlobalType ADD VALUE '".\common\models\Block::GLOBAL_TYPE_BANNER_HOMEPAGE_8_8."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m191225_145913_blockGlobalType_alter cannot be reverted.\n";

        return false;
    }
}
