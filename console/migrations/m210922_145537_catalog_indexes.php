<?php

use yii\db\Migration;

/**
 * Class m210922_145537_catalog_indexes
 */
class m210922_145537_catalog_indexes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('catalog-tag_for_link-idx', \common\models\Catalog::tableName(), 'tag_for_link');
        $this->createIndex('catalog-code-idx', \common\models\Catalog::tableName(), 'code');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('catalog-tag_for_link-idx', \common\models\Catalog::tableName());
        $this->dropIndex('catalog-code-idx', \common\models\Catalog::tableName());
    }
}
