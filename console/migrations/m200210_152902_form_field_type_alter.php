<?php

use yii\db\Migration;

/**
 * Class m200210_152902_form_field_type_alter
 */
class m200210_152902_form_field_type_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE formFieldType ADD VALUE '".\common\models\FormField::TYPE_BUTTON."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m200210_152902_form_field_type_alter cannot be reverted.\n";

        return false;
    }
}
