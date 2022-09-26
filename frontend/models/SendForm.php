<?php

namespace frontend\models;

use common\components\helpers\AppHelper;
use common\components\helpers\FormHelper;
use common\models\Form;
use Yii;
use yii\base\Model;
use yii\helpers\Html;

/**
 * SendForm is the model behind the contact form.
 */
class SendForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    public function sendEmail(Form $form, array $fields, string $url) : bool
    {
        $isSended = false;
        $emails = $form->getEmails();
        if ($emails) {
            $params = ['form' => $form, 'fields' => $fields, 'url' => $url,];

            foreach ($emails as $email) {
                $isSended = AppHelper::sendMessage('form', $email, 'Отправка формы "'.Html::encode($form->name).'"', $params);

                if (!$isSended) {
                    return $isSended;
                } else {
                    FormHelper::addFormSended($form->id, $fields, $url, $email);
                }
            }
        }

        return $isSended;
    }
}
