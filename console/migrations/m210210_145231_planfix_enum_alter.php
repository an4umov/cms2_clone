<?php

use yii\db\Migration;

/**
 * Class m210210_145231_planfix_enum_alter
 */
class m210210_145231_planfix_enum_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE planfixPartnerExtType ADD VALUE '".\common\models\PlanfixPartnerExt::TYPE_VK."'");
        $this->execute("ALTER TYPE planfixPartnerExtType ADD VALUE '".\common\models\PlanfixPartnerExt::TYPE_ICQ."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m191011_152917_block_type_setting cannot be reverted.\n";

        return false;
    }
}
