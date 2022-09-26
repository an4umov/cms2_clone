<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reference_delivery_group".
 */
class ReferenceDeliveryGroup extends References
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reference_delivery_group';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['name'] = 'Название группы доставки';

        return $labels;
    }
}
