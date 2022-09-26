<?php

use yii\db\Migration;

/**
 * Handles adding additional to table `content_item`.
 */
class m190504_201517_add_additional_column_to_content_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('content_item', 'additional', $this->string(64));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('content_item', 'additional');
    }
}
