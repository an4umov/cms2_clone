<?php

use yii\db\Migration;

/**
 * Class m200127_140904_block_youtube
 */
class m200127_140904_block_youtube extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockGlobalType ADD VALUE '".\common\models\Block::GLOBAL_TYPE_GALLERY_YOUTUBE."'");
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
