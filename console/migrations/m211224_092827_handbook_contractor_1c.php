<?php

use yii\db\Migration;

/**
 * Class m211224_092827_handbook_contractor_1c
 */
class m211224_092827_handbook_contractor_1c extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db = Yii::$app->db2;

        $this->createTable('shop.handbook_contractor_1c', [
            'id' => $this->primaryKey(),
            'code' => $this->string(15)->notNull(),
            'name' => $this->string()->notNull(),
            'name_official' => $this->string(),
            'address' => $this->text(),
            'buyer' => $this->boolean()->notNull()->defaultValue(false),
            'supplier' => $this->boolean()->notNull()->defaultValue(false),
            'type' => $this->string(20)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('handbook_contractor_1c-code-idx', 'shop.handbook_contractor_1c', 'code', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->db = Yii::$app->db2;

        $this->dropTable('shop.handbook_contractor_1c');
    }
}
