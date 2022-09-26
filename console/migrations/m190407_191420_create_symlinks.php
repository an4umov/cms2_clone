<?php

use yii\db\Migration;

/**
 * Class m190407_191420_create_symlinks
 */
class m190407_191420_create_symlinks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //  > /dev/null 2>&1 & echo $!'

        $ba = Yii::getAlias('@backend') . '/web/files';
        if (!is_dir($ba)) {
            mkdir($ba);
        }
        $fr = Yii::getAlias('@frontend') . '/web/files';
        if (!is_dir($fr)) {
            mkdir($fr);
        }
        $fi = Yii::getAlias('@files') . '/*';

        exec("ln -s {$fi} $ba");
        exec("ln -s {$fi} $fr");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190407_191420_create_symlinks cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190407_191420_create_symlinks cannot be reverted.\n";

        return false;
    }
    */
}
