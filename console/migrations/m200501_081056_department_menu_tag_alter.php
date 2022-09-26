<?php

use yii\db\Migration;

/**
 * Class m200501_081056_department_menu_tag_alter
 */
class m200501_081056_department_menu_tag_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $data = [];
        $tags = \common\models\DepartmentMenuTag::find()->all();

        $this->addColumn(\common\models\DepartmentMenuTag::tableName(), 'url', $this->string(25)->null());//
        $this->addColumn(\common\models\DepartmentMenuTag::tableName(), 'name', $this->string(255)->null());//
        $this->addColumn(\common\models\DepartmentMenuTag::tableName(), 'image', $this->string(255)->null());
        $this->addColumn(\common\models\DepartmentMenuTag::tableName(), 'sort', $this->integer()->null()->unsigned());//

        $count = 1;
        foreach ($tags as $tag) {
            $list = \common\models\DepartmentMenuTagList::findAll(['department_menu_tag_id' => $tag->id,]);

            foreach ($list as $item) {
                $newModel = new \common\models\DepartmentMenuTag();
                $newModel->department_menu_id = $tag->department_menu_id;
                $newModel->url = $item->url;
                $newModel->name = $item->name;
                $newModel->image = '';
                $newModel->sort = $count++;
                $newModel->is_active = true;

                $data[] = $newModel;
            }
        }

        if ($data) {
            $this->dropForeignKey('fk-department_menu_tag_list-department_model_id', \common\models\DepartmentMenuTagList::tableName());
            $this->dropForeignKey('fk-department_menu_tag-department_id', \common\models\DepartmentMenuTag::tableName());
            $this->truncateTable(\common\models\DepartmentMenuTagList::tableName());
            $this->truncateTable(\common\models\DepartmentMenuTag::tableName());

            foreach ($data as $datum) {
                $datum->save();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200501_081056_department_menu_tag_alter cannot be reverted.\n";

        return false;
    }
}
