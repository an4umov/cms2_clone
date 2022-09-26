<?php

use yii\db\Migration;

/**
 * Handles the creation of table `low_banner`.
 */
class m190411_104420_create_low_banner_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('low_banner', [
            'id' => $this->primaryKey(),
            'color' => $this->string(10),
            'image' => $this->integer(),
            'title' => $this->string(),
            'text' => $this->string(),
            'sort' => $this->tinyInteger()
        ]);

        $this->addForeignKey('fk__low_banner__files', 'low_banner', 'image', 'file', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk__low_banner__files', 'low_banner');
        $this->dropTable('low_banner');
    }
}
