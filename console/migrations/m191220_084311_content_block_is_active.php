<?php

use yii\db\Migration;

/**
 * Class m191220_084311_content_block_is_active
 */
class m191220_084311_content_block_is_active extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\ContentBlock::tableName(), 'is_active', $this->boolean()->notNull()->defaultValue(true));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\ContentBlock::tableName(), 'is_active');
    }
}
