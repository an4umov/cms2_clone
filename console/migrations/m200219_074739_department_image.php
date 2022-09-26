<?php

use yii\db\Migration;

/**
 * Class m200219_074739_department_image
 */
class m200219_074739_department_image extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Department::tableName(), 'image', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\Department::tableName(), 'image');
    }
}
