<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reference_payment_group".
 */
class ReferencePaymentGroup extends References
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reference_payment_group';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['name'] = 'Название группы оплаты';

        return $labels;
    }
}
