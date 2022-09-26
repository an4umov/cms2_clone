<?php

use yii\db\Migration;

/**
 * Class m181225_220910_create_roles
 */
class m181225_220910_create_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = \Yii::$app->authManager;

        // 1. Admin
        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';
        $auth->add($admin);

        // 1) Redactor
        $redactor = $auth->createRole('redactor');
        $redactor->description = 'Редактор';
        $auth->add($redactor);

        $auth->assign($admin, 1);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = \Yii::$app->authManager;

        $role = $auth->getRole('admin');
        $auth->remove($role);

        $role = $auth->getRole('redactor');
        $auth->remove($role);

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181225_220910_create_roles cannot be reverted.\n";

        return false;
    }
    */
}
