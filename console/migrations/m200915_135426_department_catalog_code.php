<?php

use yii\db\Migration;

/**
 * Class m200915_135426_department_catalog_code
 */
class m200915_135426_department_catalog_code extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Department::tableName(), 'catalog_code', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\Department::tableName(), 'catalog_code');
    }
}
