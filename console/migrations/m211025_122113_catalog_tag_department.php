<?php

use yii\db\Migration;

/**
 * Class m211025_122113_catalog_tag_department
 */
class m211025_122113_catalog_tag_department extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('catalog_linktag_department', [
            'id' => $this->primaryKey(),
            'link_tag' => $this->string(100)->notNull(),
            'code' => $this->string(15)->notNull(),
            'department_code' => $this->string(15)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('catalog_linktag_department-link_tag-idx', 'catalog_linktag_department', 'link_tag');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TABLE catalog_linktag_department');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211025_122113_catalog_tag_department cannot be reverted.\n";

        return false;
    }
    */
}
