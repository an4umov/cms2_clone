<?php

namespace frontend\models;

use common\components\helpers\AppHelper;
use common\components\helpers\ContentHelper;
use common\components\helpers\FormHelper;
use common\models\Content;
use common\models\Form;
use Yii;
use yii\base\Model;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

/**
 * Send404Form is the model behind the contact form.
 */
class SendNotFoundForm extends Model
{
    public $brand;
    public $part;
    public $name;
    public $email;
    public $phone;
    public $type;

    const TYPE_SITE = 'site';
    const TYPE_LRPARTS = 'lrparts';
    const TYPES = [self::TYPE_SITE, self::TYPE_LRPARTS,];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brand', 'part', 'name', 'email',], 'required'],
            [['part', 'brand',], 'string', 'max' => 255,],
            [['email', 'name',], 'string', 'max' => 100,],
            [['phone',], 'string', 'max' => 15,],
            ['email', 'email'],
            ['type', 'in', 'range' => self::TYPES,],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'brand' => 'Укажите информацию о Вашем автомобиле, чем подробнее - тем лучше',
            'part' => 'Укажите интересующие Вас запчасти',
            'name' => 'Как к Вам обращаться?',
            'email' => 'Укажите Вашу почту для обратной связи',
            'phone' => 'Укажите Ваш телефон, если хотите получить консультацию по телефону',
            'type' => 'Источник формы',
        ];
    }

    /**
     * @return bool
     * @throws NotFoundHttpException
     */
    public function sendEmail() : bool
    {
        $email = Yii::$app->params['adminEmail'];

        $params = [
            'brand' => $this->brand,
            'part' => $this->part,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'url' => Yii::$app->request->absoluteUrl,
            'type' => $this->getTypeTitle($this->type),
        ];
        $isSended = AppHelper::sendMessage('notfound', $email, 'Отправка запроса со страницы 404', $params);

        return $isSended;
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getTypeTitle(string $type) : string
    {
        $types = [
            self::TYPE_SITE => 'Основной сайт',
            self::TYPE_LRPARTS => 'Каталог запчастей LrParts',
        ];

        return $types[$type] ?? '';
    }
}
