<?php

use yii\db\Migration;

/**
 * Class m190917_133811_cbf_alter
 */
class m190917_133811_cbf_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn(\common\models\ContentBlockField::tableName(), 'block_id', 'content_block_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn(\common\models\ContentBlockField::tableName(), 'content_block_id', 'block_id');
    }
}
