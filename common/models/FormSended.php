<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "form_sended".
 *
 * @property int $id
 * @property int $form_id
 * @property int $user_id
 * @property string $page
 * @property string $emails
 * @property string $data JSON
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Form $form
 */
class FormSended extends \yii\db\ActiveRecord
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
    public static function tableName()
    {
        return 'form_sended';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['form_id', 'page', 'emails', 'data'], 'required'],
            [['form_id', 'user_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['form_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['data'], 'string'],
            [['page', 'emails'], 'string', 'max' => 256],
            [['form_id'], 'exist', 'skipOnError' => true, 'targetClass' => Form::class, 'targetAttribute' => ['form_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_id' => 'Форма',
            'user_id' => 'Пользователь',
            'page' => 'Страница отправки',
            'emails' => 'Почтовый ящик',
            'data' => 'Данные',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(Form::class, ['id' => 'form_id',]);
    }

    /**
     * @return array
     */
    public function getData() : array
    {
        return !empty($this->data) ? Json::decode($this->data) : [];
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = Json::encode($data);
    }
}
