<?php

use yii\db\Migration;
use \common\models\CarModel;

/**
 * Class m200713_070948_car_model_alter
 */
class m200713_070948_car_model_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable(CarModel::tableName());

        $this->execute("CREATE TYPE carModelLevel AS ENUM ('brand','model','generation','configuration','complectation')");

        $this->createTable('car_model', [
            'id' => $this->integer(11)->notNull(),
            'parent_id' => $this->integer(11)->notNull(),
            'level' => "carModelLevel",
            'name' => $this->string(100)->notNull(),
            'cirillic_name' => $this->string(100)->notNull(),
            'alias' => $this->string(100)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TYPE carModelLevel CASCADE');

        $this->dropColumn(CarModel::tableName(), 'cirillic_name');
        $this->dropColumn(CarModel::tableName(), 'alias');
        $this->dropColumn(CarModel::tableName(), 'level');
        $this->dropColumn(CarModel::tableName(), 'parent_id');
    }
}
