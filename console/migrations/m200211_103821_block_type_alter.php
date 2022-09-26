<?php

use yii\db\Migration;

/**
 * Class m200211_103821_block_type_alter
 */
class m200211_103821_block_type_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockType ADD VALUE '".\common\models\Block::TYPE_FORM."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m200211_103821_block_type_alter cannot be reverted.\n";

        return false;
    }
}
