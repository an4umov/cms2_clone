<?php

use yii\db\Migration;

/**
 * Class m191009_133515_content_index_page
 */
class m191009_133515_content_index_page extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Content::tableName(), 'is_index_page', $this->boolean()->notNull()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\Content::tableName(), 'is_index_page');
    }
}
