<?php

use yii\db\Migration;

/**
 * Class m210604_132003_blockGlobalType_alter
 */
class m210604_132003_blockGlobalType_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE blockGlobalType ADD VALUE '".\common\models\Block::GLOBAL_TYPE_GALLERY_IMAGE_SLIDER_1140."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m210604_132003_blockGlobalType_alter cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210604_132003_blockGlobalType_alter cannot be reverted.\n";

        return false;
    }
    */
}
