<?php

use yii\db\Migration;

/**
 * Class m200217_101846_block_globaltype_alter
 */
class m200217_101846_block_globaltype_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockGlobalType ADD VALUE '".\common\models\Block::GLOBAL_TYPE_GALLERY_TILE_3."'");
        $this->execute("ALTER TYPE blockGlobalType ADD VALUE '".\common\models\Block::GLOBAL_TYPE_GALLERY_TILE_6."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m191227_090041_block_alter cannot be reverted.\n";

        return false;
    }
}
