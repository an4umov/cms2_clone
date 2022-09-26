<?php

use yii\db\Migration;

/**
 * Class m200501_135209_department_model_name_remove
 */
class m200501_135209_department_model_name_remove extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn(\common\models\DepartmentModel::tableName(), 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200501_135209_department_model_name_remove cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200501_135209_department_model_name_remove cannot be reverted.\n";

        return false;
    }
    */
}
