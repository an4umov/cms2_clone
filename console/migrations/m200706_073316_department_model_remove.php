<?php

use common\models\DepartmentMenu;
use common\models\DepartmentModel;
use yii\db\Migration;

/**
 * Class m200706_073316_department_model_remove
 */
class m200706_073316_department_model_remove extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(DepartmentMenu::tableName(), 'department_id', $this->integer());

        $this->dropIndex('department_model-department_id-url-uniq', DepartmentModel::tableName());
        $this->dropForeignKey('fk-department_model-department_id', DepartmentModel::tableName());
        $this->dropForeignKey('fk-department_menu-department_model_id', DepartmentMenu::tableName());

        $this->addForeignKey(
            'fk-department_menu-department_id',
            DepartmentMenu::tableName(),
            'department_id',
            \common\models\Department::tableName(),
            'id',
            'CASCADE'
        );

        $models = DepartmentModel::find()->all();
        $menus = DepartmentMenu::find()->all();

        $list = [];
        foreach ($models as $model) {
            $list[$model->id] = $model->department_id;
        }


        foreach ($menus as $menu) {
            if (!empty($menu->department_model_id)) {
                $menu->department_id = $list[$menu->department_model_id];
                $menu->save(false);
                echo 'Saved'.PHP_EOL;
            }
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\DepartmentMenu::tableName(), 'department_id');
        $this->dropIndex('department_menu-department_id-url-uniq', DepartmentMenu::tableName());
        $this->dropForeignKey('fk-department_menu-department_id', DepartmentMenu::tableName());
    }
}
