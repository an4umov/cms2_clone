<?php

use yii\db\Migration;

/**
 * Class m191007_080151_content_block_field_fk
 */
class m191007_080151_content_block_field_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-content_block_field-block_id', \common\models\ContentBlockField::tableName());

        $this->addForeignKey(
            'fk-content_block_field-block_id',
            'content_block_field',
            'content_block_id',
            'content_block',
            'id',
            'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191007_080151_content_block_field_fk cannot be reverted.\n";

        return false;
    }
}
