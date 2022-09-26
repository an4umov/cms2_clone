<?php

use yii\db\Migration;

/**
 * Class m191008_113135_content_block_field_data
 */
class m191008_113135_content_block_field_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $rows = \common\models\ContentBlockField::find()->all();
        echo 'Rows: '.count($rows).PHP_EOL;
        foreach ($rows as $row) {
            $data = \yii\helpers\Json::decode($row->data);

            foreach ($data as $id => $value) {
                if (is_array($value)) {
                    $data[$id] = [$value,];
                }
            }

            $row->data = \yii\helpers\Json::encode($data);
            if ($row->save()) {
                echo 'Saved'.PHP_EOL;
            } else {
                echo 'Not saved'.PHP_EOL;

                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
