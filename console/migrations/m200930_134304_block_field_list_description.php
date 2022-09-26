<?php

use yii\db\Migration;

/**
 * Class m200930_134304_block_field_list_description
 */
class m200930_134304_block_field_list_description extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\BlockFieldList::tableName(), 'description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\BlockFieldList::tableName(), 'description');
    }
}
