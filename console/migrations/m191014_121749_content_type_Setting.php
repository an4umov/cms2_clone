<?php

use \common\models\Content;
use yii\db\Migration;

/**
 * Class m191014_121749_content_type_Setting
 */
class m191014_121749_content_type_Setting extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("ALTER TYPE contentType ADD VALUE '".Content::TYPE_SETTING."'");

        $model = new Content();
        $model->type = Content::TYPE_SETTING;
        $model->name = 'Header';
        $model->alias = 'header';
        $model->is_index_page = false;
        if ($model->save()) {
            echo 'Header saved, ID = '.$model->id.PHP_EOL;
        } else {
            echo 'Header NOT saved'.PHP_EOL;
        }

        $model = new Content();
        $model->type = Content::TYPE_SETTING;
        $model->name = 'Footer';
        $model->alias = 'footer';
        $model->is_index_page = false;
        if ($model->save()) {
            echo 'Footer saved, ID = '.$model->id.PHP_EOL;
        } else {
            echo 'Footer NOT saved'.PHP_EOL;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m191014_121749_content_type_Setting cannot be reverted.\n";

        return false;
    }
}
