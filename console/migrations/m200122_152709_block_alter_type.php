<?php

use yii\db\Migration;

/**
 * Class m200122_152709_block_alter_type
 */
class m200122_152709_block_alter_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockType ADD VALUE '".\common\models\Block::TYPE_AGGREGATOR."'");
        $this->execute("ALTER TYPE blockGlobalType ADD VALUE '".\common\models\Block::GLOBAL_TYPE_AGGREGATOR_NEWS_TILE."'");
        $this->execute("ALTER TYPE blockGlobalType ADD VALUE '".\common\models\Block::GLOBAL_TYPE_AGGREGATOR_NEWS_TAPE."'");
        $this->execute("ALTER TYPE blockGlobalType ADD VALUE '".\common\models\Block::GLOBAL_TYPE_AGGREGATOR_ARTICLES."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m200122_152709_block_alter_type cannot be reverted.\n";

        return false;
    }
}
