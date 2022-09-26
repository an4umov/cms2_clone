<?php

use yii\db\Migration;

/**
 * Class m190403_135311_add_file_fk
 */
class m190403_135311_add_file_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk__galleries_files__gallery', 'galleries_files', 'gallery_id', 'gallery', 'id');
        $this->addForeignKey('fk__galleries_files__file', 'galleries_files', 'file_id', 'file', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk__galleries_files__gallery', 'galleries_files');
        $this->dropForeignKey('fk__galleries_files__file', 'galleries_files');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190403_135311_add_file_fk cannot be reverted.\n";

        return false;
    }
    */
}
