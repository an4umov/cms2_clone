<?php

use yii\db\Migration;

/**
 * Class m201002_143602_form_field_type_message
 */
class m201002_143602_form_field_type_message extends Migration
{
    public function up()
    {
        $this->execute("ALTER TYPE formFieldType ADD VALUE '".\common\models\FormField::TYPE_MESSAGE."'");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m201002_143602_form_field_type_message cannot be reverted.\n";

        return false;
    }
}
