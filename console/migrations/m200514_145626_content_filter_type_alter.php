<?php

use yii\db\Migration;

/**
 * Class m200514_145626_content_filter_type_alter
 */
class m200514_145626_content_filter_type_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE contentFilterType ADD VALUE '".\common\models\ContentFilter::TYPE_DEPARTMENT."'");
        $this->execute("ALTER TYPE contentFilterType ADD VALUE '".\common\models\ContentFilter::TYPE_MENU."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m200514_145626_content_filter_type_alter cannot be reverted.\n";

        return false;
    }
}
