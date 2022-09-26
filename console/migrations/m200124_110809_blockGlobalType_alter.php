<?php

use yii\db\Migration;

/**
 * Class m200124_110809_blockGlobalType_alter
 */
class m200124_110809_blockGlobalType_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockGlobalType ADD VALUE '".\common\models\Block::GLOBAL_TYPE_GALLERY_TV."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m200124_110809_blockGlobalType_alter cannot be reverted.\n";

        return false;
    }
}
