<?php

namespace common\models;


use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "reference_partner".
 */
class ReferencePartner extends References
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reference_partner';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['name'] = 'Партнер';

        return $labels;
    }
}
