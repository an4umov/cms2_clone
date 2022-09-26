<?php

use yii\db\Migration;

/**
 * Handles adding url to table `content_item`.
 */
class m190519_103634_add_url_column_to_content_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('content_item', 'url', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('content_item', 'url');
    }
}
