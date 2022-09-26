<?php

use yii\db\Migration;

/**
 * Class m210429_084953_green_menu_update
 */
class m210429_084953_green_menu_update extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\GreenMenu::tableName(), 'is_department_menu', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\GreenMenu::tableName(), 'is_department_menu');
    }
}
