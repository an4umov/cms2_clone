<?php

use yii\db\Migration;

/**
 * Class m200901_075559_settings_main_shop_level
 */
class m200901_075559_settings_main_shop_level extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE settingsMainShopLevelType AS ENUM ('one', 'two', 'three')");

        $this->createTable('settings_main_shop_level', [
            'id' => $this->primaryKey(),
            'code' => $this->string()->notNull(),
            'type' => "settingsMainShopLevelType",
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TYPE settingsMainShopLevelType CASCADE');

        $this->dropTable('settings_main_shop_level');
    }
}
