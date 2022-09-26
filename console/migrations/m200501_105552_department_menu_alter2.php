<?php

use yii\db\Migration;

/**
 * Class m200501_105552_department_menu_alter2
 */
class m200501_105552_department_menu_alter2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(\common\models\DepartmentMenuTag::tableName(), 'url', $this->string(25)->notNull());
        $this->alterColumn(\common\models\DepartmentMenuTag::tableName(), 'name', $this->string(255)->notNull());
        $this->alterColumn(\common\models\DepartmentMenuTag::tableName(), 'is_active', $this->boolean()->notNull()->defaultValue(true));
        $this->alterColumn(\common\models\DepartmentMenuTag::tableName(), 'sort', $this->integer()->notNull()->unsigned());

        $this->createIndex('department_menu_tag-department_menu_id-url-uniq', \common\models\DepartmentMenuTag::tableName(), ['department_menu_id', 'url',], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
