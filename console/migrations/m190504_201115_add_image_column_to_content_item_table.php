<?php

use yii\db\Migration;

/**
 * Handles adding image to table `content_item`.
 */
class m190504_201115_add_image_column_to_content_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('content_item', 'image', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('content_item', 'image');
    }
}
