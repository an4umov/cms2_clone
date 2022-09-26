<?php

use yii\db\Migration;

/**
 * Class m190925_153802_department_unique
 */
class m190925_153802_department_unique extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('department-url-uniq', \common\models\Department::tableName(), 'url', true);
        $this->createIndex('department_menu-department_id-url-uniq', \common\models\DepartmentMenu::tableName(), ['department_id', 'url',], true);
        $this->createIndex('department_model_list-department_model_id-url-uniq', \common\models\DepartmentModelList::tableName(), ['department_model_id', 'url',], true);
        $this->createIndex('department_menu_tag_list-department_menu_tag_id-url-uniq', \common\models\DepartmentMenuTagList::tableName(), ['department_menu_tag_id', 'url',], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('department-url-uniq', \common\models\Department::tableName());
        $this->dropIndex('department_menu-department_id-url-uniq', \common\models\DepartmentMenu::tableName());
        $this->dropIndex('department_model_list-department_model_id-url-uniq', \common\models\DepartmentModelList::tableName());
        $this->dropIndex('department_menu_tag_list-department_menu_tag_id-url-uniq', \common\models\DepartmentMenuTagList::tableName());
    }
}
