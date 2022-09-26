<?php

use yii\db\Migration;

/**
 * Class m200501_075117_department_models_alter2
 */
class m200501_075117_department_models_alter2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(\common\models\DepartmentModel::tableName(), 'url', $this->string(25)->notNull());
        $this->alterColumn(\common\models\DepartmentModel::tableName(), 'name', $this->string(255)->notNull());
        $this->alterColumn(\common\models\DepartmentModel::tableName(), 'is_active', $this->boolean()->notNull()->defaultValue(true));
        $this->alterColumn(\common\models\DepartmentModel::tableName(), 'sort', $this->integer()->notNull()->unsigned());

        $this->createIndex('department_model-department_id-url-uniq', \common\models\DepartmentModel::tableName(), ['department_id', 'url',], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
