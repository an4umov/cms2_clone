<?php

use yii\db\Migration;

/**
 * Class m210503_113354_catalog_alter
 */
class m210503_113354_catalog_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Catalog::tableName(), 'is_department', $this->boolean()->defaultValue(false));
        $this->addColumn(\common\models\Catalog::tableName(), 'copy_of', $this->string(100));
        $this->addColumn(\common\models\Catalog::tableName(), 'link_anchor', $this->string(100));
        $this->addColumn(\common\models\Catalog::tableName(), 'link_tag', $this->string(100));
        $this->addColumn(\common\models\Catalog::tableName(), 'tag_for_link', $this->string(100));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\Catalog::tableName(), 'is_department');
        $this->dropColumn(\common\models\Catalog::tableName(), 'copy_of');
        $this->dropColumn(\common\models\Catalog::tableName(), 'link_anchor');
        $this->dropColumn(\common\models\Catalog::tableName(), 'link_tag');
        $this->dropColumn(\common\models\Catalog::tableName(), 'tag_for_link');
    }
}
