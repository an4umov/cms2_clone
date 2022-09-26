<?php

use yii\db\Migration;

/**
 * Class m190413_062624_set_tags_to_tree
 */
class m190413_062624_set_tags_to_tree extends Migration
{

     const TABLE_NAME = 'tag';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE_NAME, 'root', $this->integer());
        $this->addColumn(self::TABLE_NAME, 'lft', $this->integer()->notNull()->defaultValue(0));
        $this->addColumn(self::TABLE_NAME, 'rgt', $this->integer()->notNull()->defaultValue(0));
        $this->addColumn(self::TABLE_NAME, 'lvl', $this->smallInteger(5)->notNull()->defaultValue(0));
        $this->addColumn(self::TABLE_NAME, 'icon', $this->string(255));
        $this->addColumn(self::TABLE_NAME, 'icon_type', $this->smallInteger(1)->notNull()->defaultValue(0));

        $this->addColumn(self::TABLE_NAME, 'active', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn(self::TABLE_NAME, 'selected', $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn(self::TABLE_NAME, 'disabled', $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn(self::TABLE_NAME, 'readonly', $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn(self::TABLE_NAME, 'visible', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn(self::TABLE_NAME, 'collapsed', $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn(self::TABLE_NAME, 'movable_u', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn(self::TABLE_NAME, 'movable_d', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn(self::TABLE_NAME, 'movable_l', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn(self::TABLE_NAME, 'movable_r', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn(self::TABLE_NAME, 'removable', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn(self::TABLE_NAME, 'removable_all', $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn(self::TABLE_NAME, 'child_allowed', $this->boolean()->notNull()->defaultValue(true));

        $this->createIndex('tag_NK1', self::TABLE_NAME, 'root');
        $this->createIndex('tag_NK2', self::TABLE_NAME, 'lft');
        $this->createIndex('tag_NK3', self::TABLE_NAME, 'rgt');
        $this->createIndex('tag_NK4', self::TABLE_NAME, 'lvl');
        $this->createIndex('tag_NK5', self::TABLE_NAME, 'active');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('tag_NK1', self::TABLE_NAME);
        $this->dropIndex('tag_NK2', self::TABLE_NAME);
        $this->dropIndex('tag_NK3', self::TABLE_NAME);
        $this->dropIndex('tag_NK4', self::TABLE_NAME);
        $this->dropIndex('tag_NK5', self::TABLE_NAME);


        $this->dropColumn(self::TABLE_NAME, 'root');
        $this->dropColumn(self::TABLE_NAME, 'lft');
        $this->dropColumn(self::TABLE_NAME, 'rgt');
        $this->dropColumn(self::TABLE_NAME, 'lvl');
        $this->dropColumn(self::TABLE_NAME, 'icon');
        $this->dropColumn(self::TABLE_NAME, 'icon_type');

        $this->dropColumn(self::TABLE_NAME, 'active');
        $this->dropColumn(self::TABLE_NAME, 'selected');
        $this->dropColumn(self::TABLE_NAME, 'disabled');
        $this->dropColumn(self::TABLE_NAME, 'readonly');
        $this->dropColumn(self::TABLE_NAME, 'visible');
        $this->dropColumn(self::TABLE_NAME, 'collapsed');
        $this->dropColumn(self::TABLE_NAME, 'movable_u');
        $this->dropColumn(self::TABLE_NAME, 'movable_d');
        $this->dropColumn(self::TABLE_NAME, 'movable_l');
        $this->dropColumn(self::TABLE_NAME, 'movable_r');
        $this->dropColumn(self::TABLE_NAME, 'removable');
        $this->dropColumn(self::TABLE_NAME, 'removable_all');
        $this->dropColumn(self::TABLE_NAME, 'child_allowed');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190413_062624_set_tags_to_tree cannot be reverted.\n";

        return false;
    }
    */
}
