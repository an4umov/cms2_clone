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
 * SendQuestion is the model behind the contact form.
 */
class SendQuestionForm extends Model
{
    public $id;
    public $type;
    public $name;
    public $email;
    public $comment;
    public $verifyCode;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'name', 'email', 'comment',], 'required'],
            [['id',], 'integer'],
            ['type', 'in', 'range' => Content::TYPES,],
            [['name',], 'string', 'max' => 100,],
            [['email',], 'string', 'max' => 100,],
            ['email', 'email'],
            [['comment'], 'string',],
//            ['verifyCode', 'captcha'],
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

    /**
     * @return bool
     * @throws NotFoundHttpException
     */
    public function sendEmail() : bool
    {
        $email = Yii::$app->params['adminEmail'];
        $content = Content::findOne(['id' => $this->id, 'type' => $this->type, 'deleted_at' => null,]);

        if ($content) {
            $params = ['id' => $this->id, 'type' => $this->type, 'name' => $this->name, 'email' => $this->email, 'comment' => $this->comment, 'url' => $content->getContentUrl(null),];
            $isSended = AppHelper::sendMessage('question', $email, 'Отправка вопроса от "'.Html::encode($this->name).'"', $params);

            if ($isSended) {
                FormHelper::addQuestionSended($params);
            }

            return $isSended;
        }

        throw new NotFoundHttpException('Вопрос не отправлен. Контент #'.$this->id.' не найден');
    }
}
