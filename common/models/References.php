<?php

namespace common\models;


use common\models\search\ReferenceDeliveryGroupSearch;
use common\models\search\ReferencePaymentGroupSearch;
use yii\behaviors\TimestampBehavior;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $icon
 * @property bool $is_active
 * @property int $created_at
 * @property int $updated_at
 */
class References extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['is_active'], 'boolean'],
            [['is_active',], 'default', 'value' => true,],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['icon'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'icon' => 'Иконка',
            'is_active' => 'Активен',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return string
     */
    public function getSpecialClass() : string
    {
        return !$this->is_active ? 'danger' : 'default';
    }

    /**
     * @return bool
     */
    public function delete() : bool
    {
        $this->is_active = false;

        return (bool) $this->save(false);
    }

    /**
     * @return string
     */
    public function getClassTitle() : string
    {
        $title = 'Базовый класс';

        if ($this instanceof ReferencePartner) {
            $title = 'Партнеры';
        } elseif ($this instanceof ReferenceBuyer) {
            $title = 'Покупатели';
        } elseif ($this instanceof ReferenceDelivery) {
            $title = 'Доставка';
        } elseif ($this instanceof ReferenceDeliveryGroupSearch) {
            $title = 'Группы доставки';
        } elseif ($this instanceof ReferencePayment) {
            $title = 'Оплата';
        } elseif ($this instanceof ReferencePaymentGroupSearch) {
            $title = 'Группы оплаты';
        }

        return $title;
    }
}
