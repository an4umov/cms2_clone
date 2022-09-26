<?php

use yii\db\Migration;

/**
 * Class m190925_134324_department
 */
class m190925_134324_department extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('department', [
            'id' => $this->primaryKey(),
            'url' => $this->string(25)->notNull(),
            'name' => $this->string(255)->notNull(),
            'icon' => $this->string(50)->null(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'sort' => $this->integer()->notNull()->unsigned(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('department_menu', [
            'id' => $this->primaryKey(),
            'department_id' => $this->integer()->notNull(),
            'url' => $this->string(25)->notNull(),
            'name' => $this->string(255)->notNull(),
            'icon' => $this->string(50)->null(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'sort' => $this->integer()->notNull()->unsigned(),
            'is_special' => $this->boolean()->notNull()->defaultValue(false),
            'is_show_news' => $this->boolean()->notNull()->defaultValue(true),
            'is_show_articles' => $this->boolean()->notNull()->defaultValue(true),
            'is_show_pages' => $this->boolean()->notNull()->defaultValue(true),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk-department_menu-department_id',
            'department_menu',
            'department_id',
            'department',
            'id',
            'CASCADE'
        );

        $this->createTable('department_model', [
            'id' => $this->primaryKey(),
            'department_id' => $this->integer()->notNull(),
            'word_1' => $this->string(50)->notNull(),
            'word_2' => $this->string(50)->null(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk-department_model-department_id',
            'department_model',
            'department_id',
            'department',
            'id',
            'CASCADE'
        );

        $this->createTable('department_model_list', [
            'id' => $this->primaryKey(),
            'department_model_id' => $this->integer()->notNull(),
            'url' => $this->string(25)->notNull(),
            'name' => $this->string(255)->notNull(),
            'icon' => $this->string(50)->null(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'sort' => $this->integer()->notNull()->unsigned(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addForeignKey(
        'fk-department_model_list-department_model_id',
        'department_model_list',
        'department_model_id',
        'department_model',
        'id',
        'CASCADE'
        );

        $this->createTable('department_menu_tag', [
            'id' => $this->primaryKey(),
            'department_menu_id' => $this->integer()->notNull(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk-department_menu_tag-department_id',
            'department_menu_tag',
            'department_menu_id',
            'department_menu',
            'id',
            'CASCADE'
        );

        $this->createTable('department_menu_tag_list', [
            'id' => $this->primaryKey(),
            'department_menu_tag_id' => $this->integer()->notNull(),
            'url' => $this->string(25)->notNull(),
            'name' => $this->string(50)->notNull(),
            'icon' => $this->string(50)->null(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'sort' => $this->integer()->notNull()->unsigned(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk-department_menu_tag_list-department_model_id',
            'department_menu_tag_list',
            'department_menu_tag_id',
            'department_menu_tag',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TABLE department CASCADE');
        $this->execute('DROP TABLE department_menu CASCADE');
        $this->execute('DROP TABLE department_model CASCADE');
        $this->execute('DROP TABLE department_model_list CASCADE');
        $this->execute('DROP TABLE department_menu_tag CASCADE');
        $this->execute('DROP TABLE department_menu_tag_list CASCADE');
    }
}
