<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "form".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $color
 * @property string $color_bg
 * @property string $emails
 * @property string $result
 * @property string $css_prefix
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 *
 * @property FormField[] $formFields
 */
class Form extends \yii\db\ActiveRecord
{
    public $sort_list;

    public $data;
    public $content_block_id;
    public $content_block_type;
    public $content_block_sort;

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
        return 'form';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description', 'color', 'color_bg', 'emails', 'result',], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['name', 'css_prefix',], 'string', 'max' => 128],
            [['sort_list',], 'safe',],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Заголовок',
            'description' => 'Описание',
            'color' => 'Цвет заголовка',
            'color_bg' => 'Цвет фона формы',
            'emails' => 'Список адресов эл. почты',
            'result' => 'Текст успешной отправки формы',
            'css_prefix' => 'Префикс CSS класса формы',
            'created_at' => 'Создана',
            'updated_at' => 'Обновлена',
            'deleted_at' => 'Удалена',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormFields()
    {
        return $this->hasMany(FormField::class, ['form_id' => 'id',]);
    }

    /**
     * @return int
     */
    public function getFormFieldsCount() : int
    {
        return $this->hasMany(FormField::class, ['form_id' => 'id',])->where([FormField::tableName().'.deleted_at' => null,])->count();
    }

    /**
     * @return bool|false|int
     * @throws \yii\db\Exception
     */
    public function delete()
    {
        $this->deleted_at = time();

        $deleted = $this->save(false);

        return $deleted;
    }

    /**
     * @return string
     */
    public function getSpecialClass() : string
    {
        return $this->deleted_at ? 'danger' : 'default';
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     *
     * @return bool
     * @throws \yii\db\Exception
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if (!empty($this->emails) && is_string($this->emails)) {
            $list = [];
            $emails = explode(',', $this->emails);
            foreach ($emails as $email) {
                $email = trim($email);

                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $list[] = $email;
                }
            }
            $this->setEmails($list);
        }

        $saved = parent::save($runValidation, $attributeNames);

        if ($saved && !empty($this->sort_list)) {
            $index = 1;
            $fields = [];
            foreach (explode(',', $this->sort_list) as $id) {
                $fields[$id] = $index++;
            }

            if ($fields) {
                $db = \Yii::$app->db;
                foreach ($fields as $id => $sortIndex) {
                    $db->createCommand()->update(
                        FormField::tableName(),
                        ['sort' => $sortIndex,],
                        ['id' => $id, 'form_id' => $this->id,]
                    )->execute();
                }
            }
        }

        return $saved;
    }

    /**
     * @return array
     */
    public function getEmails() : array
    {
        return !empty($this->emails) ? Json::decode($this->emails) : [];
    }

    /**
     * @return string
     */
    public function getEmailsAsString() : string
    {
        $list = !empty($this->emails) ? Json::decode($this->emails) : [];

        return implode(',', $list);
    }

    /**
     * @return string
     */
    public function getRawEmails() : string
    {
        return $this->emails;
    }

    /**
     * @param array $emails
     */
    public function setEmails(array $emails)
    {
        $this->emails = Json::encode($emails);
    }
}
