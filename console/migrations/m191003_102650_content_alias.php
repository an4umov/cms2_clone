<?php

use yii\db\Migration;

/**
 * Class m191003_102650_content_alias
 */
class m191003_102650_content_alias extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Content::tableName(), 'alias', $this->string());
        $this->createIndex('content-type-alias-idx', \common\models\Content::tableName(), ['type', 'alias',], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('content-type-alias-idx', \common\models\Content::tableName());
        $this->dropColumn(\common\models\Content::tableName(), 'alias');
    }
}
