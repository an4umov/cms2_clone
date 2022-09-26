<?php
namespace common\components\helpers;


use common\models\Articles;
use common\models\Form;
use common\models\FormField;
use common\models\FormSended;
use common\models\PriceList;
use common\models\QuestionSended;
use common\models\Reference;
use common\models\ReferenceValue;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\web\View;
use zxbodya\yii2\tinymce\TinyMce;

class FormHelper
{
    const FIELD_TEXT_BEFORE_INPUT = 'text_before_input';
    const FIELD_INPUT_WIDTH = 'input_width';
    const FIELD_INPUT_PLACEHOLDER = 'input_placeholder';
    const FIELD_IS_REQUIRED = 'is_required';
    const FIELD_TEXT_AFTER_INPUT = 'text_after_input';
    const FIELD_REQUIRED_MESSAGE = 'required_message';
    const FIELD_VARIABLE = 'variable';
    const FIELD_REFERENCE_ID = 'reference_id';
    const FIELD_IS_CHECKED = 'is_checked';
    const FIELD_BUTTON_TEXT = 'button_text';
    const FIELD_BUTTON_COLOR = 'button_color';
    const FIELD_BUTTON_TEXT_COLOR = 'button_text_color';
    const FIELD_WISIWIG = 'wisiwig';

    const COUNTRY_RU = 'ru';
    const COUNTRY_UA = 'ua';
    const COUNTRY_BY = 'by';

    /**
     * @return array
     */
    public static function getCountryOptions(): array
    {
        return [
            self::COUNTRY_RU => 'Россия +7',
            self::COUNTRY_UA => 'Украина +380',
            self::COUNTRY_BY => 'Белоруссия +375',
        ];
    }

    /**
     * @param string $type
     * @param array  $data
     * @param View   $view
     *
     * @return string
     * @throws \Exception
     */
    public static function getFormFieldTypeFields(string $type, array $data, yii\web\View $view): string
    {
        $html = Html::beginTag('div', ['class' => 'panel panel-default',]);
        $html .= Html::beginTag('div', ['class' => 'panel-body',]);

        switch ($type) {
            case FormField::TYPE_TEXT:
            case FormField::TYPE_TEXTAREA:
            case FormField::TYPE_EMAIL:
            case FormField::TYPE_PHONE:
                $html .= self::generateField(self::FIELD_TEXT_BEFORE_INPUT, $data);
                $html .= self::generateField(self::FIELD_INPUT_WIDTH, $data);
                $html .= self::generateField(self::FIELD_INPUT_PLACEHOLDER, $data);
                $html .= self::generateField(self::FIELD_TEXT_AFTER_INPUT, $data);
                $html .= self::generateField(self::FIELD_IS_REQUIRED, $data);
                $html .= self::generateField(self::FIELD_REQUIRED_MESSAGE, $data);
                break;
            case FormField::TYPE_REFERENCE_ID:
                $html .= self::generateField(self::FIELD_TEXT_BEFORE_INPUT, $data);
                $html .= self::generateField(self::FIELD_INPUT_WIDTH, $data);
                $html .= self::generateField(self::FIELD_INPUT_PLACEHOLDER, $data);
                $html .= self::generateField(self::FIELD_REFERENCE_ID, $data);
                $html .= self::generateField(self::FIELD_TEXT_AFTER_INPUT, $data);
                $html .= self::generateField(self::FIELD_IS_REQUIRED, $data);
                $html .= self::generateField(self::FIELD_REQUIRED_MESSAGE, $data);
                break;
            case FormField::TYPE_CHECKBOX:
                $html .= self::generateField(self::FIELD_TEXT_BEFORE_INPUT, $data);
                $html .= self::generateField(self::FIELD_TEXT_AFTER_INPUT, $data);
                $html .= self::generateField(self::FIELD_IS_CHECKED, $data);
                $html .= self::generateField(self::FIELD_IS_REQUIRED, $data);
                $html .= self::generateField(self::FIELD_REQUIRED_MESSAGE, $data);
                break;
            case FormField::TYPE_BUTTON:
                $html .= self::generateField(self::FIELD_INPUT_WIDTH, $data);
                $html .= self::generateField(self::FIELD_BUTTON_TEXT, $data);
                $html .= self::generateField(self::FIELD_BUTTON_COLOR, $data);
                $html .= self::generateField(self::FIELD_BUTTON_TEXT_COLOR, $data);
                break;
            case FormField::TYPE_MESSAGE:
                $html .= self::generateField(self::FIELD_WISIWIG, $data, $view);
                break;
        }

        $html .= Html::endTag('div');
        $html .= Html::endTag('div');

        return preg_replace("/\r|\n/", '', $html);
    }

    /**
     * @param string    $field
     * @param array     $data
     * @param View|null $view
     *
     * @return string
     * @throws \Exception
     */
    public static function generateField(string $field, array $data, yii\web\View $view = null): string
    {
        $label = $id = $input = '';
        $name = 'FormField[data][' . $field . ']';
        $options = ['id' => $id, 'class' => 'form-control',];
        $html = Html::beginTag('div', ['class' => 'form-group row',]);
        $value = $data[$field] ?? '';

        switch ($field) {
            case self::FIELD_TEXT_BEFORE_INPUT:
                $label = 'Текст перед полем ввода';
                $input = Html::textInput($name, $value, $options);
                break;
            case self::FIELD_BUTTON_TEXT:
                $label = 'Текст кнопки';
                $input = Html::textInput($name, $value, $options);
                break;
            case self::FIELD_INPUT_WIDTH:
                $label = 'Ширина поля ввода, пиксели';
                $input = Html::textInput($name, $value, $options);
                break;
            case self::FIELD_INPUT_PLACEHOLDER:
                $label = 'Тест подсказки';
                $input = Html::textInput($name, $value, $options);
                break;
            case self::FIELD_IS_REQUIRED:
                $label = 'Обязательный';
                $options['class'] = 'form-check-input';
                $options['style'] = 'height:16px;';
                $input = Html::checkbox($name, !empty($value), $options);
                break;
            case self::FIELD_TEXT_AFTER_INPUT:
                $label = 'Текст после поля ввода';
                $input = Html::textInput($name, $value, $options);
                break;
            case self::FIELD_REQUIRED_MESSAGE:
                $label = 'Текст про обязательное условие';
                $input = Html::textInput($name, $value, $options);
                break;
            case self::FIELD_VARIABLE:
                $label = 'Название переменной';
                $input = Html::textInput($name, $value, $options);
                break;
            case self::FIELD_BUTTON_COLOR:
                $options['type'] = 'color';
                $label = 'Цвет кнопки';
                $input = Html::textInput($name, $value, $options);
                break;
            case self::FIELD_BUTTON_TEXT_COLOR:
                $options['type'] = 'color';
                $label = 'Цвет текста кнопки';
                $input = Html::textInput($name, $value, $options);
                break;
            case self::FIELD_REFERENCE_ID:
                $label = 'Справочник';
                $input = Html::dropDownList($name, $value, self::getReferencesList(),
                    $options + ['prompt' => 'Выберите справочник...',]);
                break;
            case self::FIELD_IS_CHECKED:
                $label = 'Состояние галочки по умолчанию';
                $options['class'] = 'form-check-input';
                $options['style'] = 'height:16px;';
                $input = Html::checkbox($name, !empty($value), $options);
                break;
            case self::FIELD_WISIWIG:
                $label = 'Произвольный текст';
                $settings = [
                    'settings' => [
                        'height' => 250,
                        'plugins' => [
                            "advlist lists hr pagebreak preview",
                            "searchreplace visualblocks visualchars code fullscreen",
                            "insertdatetime nonbreaking save table contextmenu directionality",
                            "template paste textcolor code link wordcount",
                        ],
                        'content_css' => '/css/tinymce.css',
                        "toolbar" => "undo redo | bold italic | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent link | forecolor backcolor | removeformat | preview code",
                        'selector' => "textarea#editable",
                        'menubar' => false,
                        'formats' => [
                            'removeformat' => [
                                [
                                    'selector' => 'b,strong,em,i,font,u,strike,h1,h2,h3,h4,h5,h6,a',
                                    'remove' => 'all',
                                    'split' => true,
                                    'expand' => false,
                                    'block_expand' => true,
                                    'deep' => true,
                                ],
                                [
                                    'selector' => 'span',
                                    'attributes' => ['style', 'class',],
                                    'remove' => 'empty',
                                    'split' => true,
                                    'expand' => false,
                                    'deep' => true,
                                ],
                                [
                                    'selector' => '*',
                                    'attributes' => ['style', 'class',],
                                    'split' => false,
                                    'expand' => false,
                                    'deep' => true,
                                ]
                            ],
                        ],
                    ],
                    'name' => $name,
                    'value' => $value,
                    'id' => 'tinymce-widget-' . md5(time() . rand(1, 1000)),
                    'class' => 'form-control',
                    'language' => 'ru',
                ];
                $input = TinyMce::widget($settings);

                if ($view) {
                    $view->registerJsVar('fieldWisiwigSettings', $settings, $view::POS_END);
                }
                break;
        }

        if ($field === self::FIELD_WISIWIG) {
            $html .= Html::tag('div', $input);
        } else {
            $html .= Html::tag('label', $label, ['class' => 'col-sm-6 col-form-label', 'for' => $id,]);
            $html .= Html::tag('div', $input, ['class' => 'col-sm-6',]);
        }

        $html .= Html::endTag('div');

        return $html;
    }

    /**
     * @return array
     */
    public static function getReferencesList(): array
    {
        $query = Reference::find()->where(['is_active' => true,])->orderBy(['name' => SORT_ASC,])->select([
            'id',
            'name',
        ])->asArray();

        return ArrayHelper::map($query->all(), 'id', 'name');
    }

    /**
     * @param int $referenceID
     *
     * @return array
     */
    public static function getReferenceValueList(int $referenceID): array
    {
        $query = ReferenceValue::find()->where([
            'reference_id' => $referenceID,
            'deleted_at' => null,
        ])->orderBy(['sort' => SORT_ASC,])->select(['id', 'name',])->asArray();

        return ArrayHelper::map($query->all(), 'id', 'name');
    }

    /**
     * @param int    $formID
     * @param array  $fields
     * @param string $url
     * @param string $email
     *
     * @return bool
     */
    public static function addFormSended(int $formID, array $fields, string $url, string $email): bool
    {
        $model = new FormSended();
        $model->form_id = $formID;
        $model->user_id = Yii::$app->user->isGuest ? null : Yii::$app->user->id;
        $model->page = $url;
        $model->emails = $email;

        $data = [];
        foreach ($fields as $field) {
            $data[$field->name] = $field->value;
        }

        $model->setData($data);

        return $model->save(false);
    }

    /**
     * @param array $params
     *
     * @return bool
     */
    public static function addQuestionSended(array $params): bool
    {
        $model = new QuestionSended();
        $model->user_id = Yii::$app->user->isGuest ? null : Yii::$app->user->id;
        $model->name = $params['name'];
        $model->email = $params['email'];
        $model->comment = $params['comment'];
        $model->content_id = $params['id'];
        $model->content_type = $params['type'];

        return $model->save(false);
    }

    /**
     * @return array
     */
    public static function getFormOptions(): array
    {
        $rows = Form::find()->where(['deleted_at' => null,])->orderBy(['name' => SORT_ASC,])->asArray()->all();

        return ArrayHelper::map($rows, 'id', 'name');
    }

    /**
     * @param int $id
     *
     * @return Form
     * @throws NotFoundHttpException
     */
    public static function getFormModel(int $id) : Form
    {
        $model = Form::find()->where(['deleted_at' => null, 'id' => $id,])->one();

        if (!$model) {
            throw new NotFoundHttpException('Форма не найдена');
        }

        return $model;
    }

    public static function renderForm(Form $form, string $key): string
    {
        $html = '';
        $formID = 'form-send-'.$form->id.'-'.rand(1, 1000);
        $cssPrefix = $form->css_prefix ? $form->css_prefix : 'form-send';

        $formOptions = ['id' => $formID, 'enableAjaxValidation' => false, 'enableClientValidation' => false, 'style' => [], 'class' => $cssPrefix,];
        if ($form->color_bg) {
            Html::addCssStyle($formOptions, ['background-color' => $form->color_bg,]);
        }

        $html .= Html::beginForm('/form/send', 'post', $formOptions);
        $html .= Html::hiddenInput('SendForm[form_id]', $form->id);
        //        $html .= print_r($form->attributes, true);

        $html .= Html::tag('div', '', ['class' => $cssPrefix.'__close',]);

        $headerOptions = ['style' => [], 'class' => $cssPrefix.'__title',];
        if ($form->color) {
            Html::addCssStyle($headerOptions, ['color' => $form->color,]);
        }
        $html .= Html::tag('div', $form->name, $headerOptions);

        $fields = ContentHelper::getFormFields($form->id);
        $rules = $messages = [];
        $tabIndex = 1;

        /** @var FormField $field */
        foreach ($fields as $field) {
            $json = ContentHelper::getBlockJson($field);
            //            $html .= print_r($json, true);
            $fieldInputName = 'SendForm['.$form->id.']['.$field->id.']';
            $fieldInputID = 'send-form-'.$form->id.'-'.$field->type.'-'.$field->id;

            $textBeforeInput = (string) !empty($json[FormHelper::FIELD_TEXT_BEFORE_INPUT]) ? $json[FormHelper::FIELD_TEXT_BEFORE_INPUT] : '';
            $inputWidth = (int) !empty($json[FormHelper::FIELD_INPUT_WIDTH]) ? $json[FormHelper::FIELD_INPUT_WIDTH] : 0;
            $placeholder = (string) !empty($json[FormHelper::FIELD_INPUT_PLACEHOLDER]) ? $json[FormHelper::FIELD_INPUT_PLACEHOLDER] : '';
            $textAfterInput = (string) !empty($json[FormHelper::FIELD_TEXT_AFTER_INPUT]) ? $json[FormHelper::FIELD_TEXT_AFTER_INPUT] : '';
            $isRequired = !empty($json[FormHelper::FIELD_IS_REQUIRED]);
            $isChecked = !empty($json[FormHelper::FIELD_IS_CHECKED]);
            $requiredMessage = (string) !empty($json[FormHelper::FIELD_REQUIRED_MESSAGE]) ? $json[FormHelper::FIELD_REQUIRED_MESSAGE] : '';
            $referenceID = (int) !empty($json[FormHelper::FIELD_REFERENCE_ID]) ? $json[FormHelper::FIELD_REFERENCE_ID] : 0;
            $buttonText = (string) !empty($json[FormHelper::FIELD_BUTTON_TEXT]) ? $json[FormHelper::FIELD_BUTTON_TEXT] : '';
            $buttonColor = (string) !empty($json[FormHelper::FIELD_BUTTON_COLOR]) ? $json[FormHelper::FIELD_BUTTON_COLOR] : '';
            $buttonTextColor = (string) !empty($json[FormHelper::FIELD_BUTTON_TEXT_COLOR]) ? $json[FormHelper::FIELD_BUTTON_TEXT_COLOR] : '';
            $messageText = (string) !empty($json[FormHelper::FIELD_WISIWIG]) ? $json[FormHelper::FIELD_WISIWIG] : '';

            if ($isRequired) {
                $rules[$fieldInputName] = ['required' => true,];

                if ($requiredMessage) {
                    $messages[$fieldInputName] = ['required' => $requiredMessage,];
                }
            }

            switch ($field->type) {
                case FormField::TYPE_MESSAGE:
                    $html .= Html::beginTag('div', ['class' => $cssPrefix.'__info',]);
                    $html .= $messageText;
                    $html .= Html::endTag('div');
                    break;
                case FormField::TYPE_TEXT:
                case FormField::TYPE_TEXTAREA:
                case FormField::TYPE_EMAIL:
                case FormField::TYPE_PHONE:
                    $html .= Html::beginTag('div', ['class' => $cssPrefix.'__input',]);
                    $html .= Html::tag('p', $field->name . ($isRequired ? ' '.Html::tag('span', '*') : ''));

                    if ($textBeforeInput) {
                        $html .= Html::tag('div', $textBeforeInput, ['for' => $fieldInputID, 'class' => $cssPrefix.'__optional-info',]);
                    }

                    $inputOptions = ['style' => [], 'id' => $fieldInputID, 'tabindex' => $tabIndex,];
                    if ($inputWidth) {
                        Html::addCssStyle($inputOptions, ['width' => $inputWidth.'px',]);
                    } else {
                        Html::addCssStyle($inputOptions, ['width' => '100%',]);
                    }
                    if ($placeholder) {
                        $inputOptions['placeholder'] = $placeholder;
                    }
                    if ($isRequired) {
                        $inputOptions['required'] = 'true';
                    }

                    if ($field->type === FormField::TYPE_TEXTAREA) {
                        $html .= Html::textarea($fieldInputName, '', $inputOptions + ['rows' => 4,]);
                    } elseif ($field->type === FormField::TYPE_TEXT) {
                        $value = '';
                        if ($field->name === 'ВЫБРАННЫЙ ТОВАР' && !empty($key)) {
                            $query = PriceList::find();
                            $query->select([
                                PriceList::tableName().'.article_number',
                                Articles::tableName().'.name',
                            ]);
                            $query->innerJoin(Articles::tableName(), Articles::tableName().'.number = '.PriceList::tableName().'.article_number');
                            $query->where([PriceList::tableName().'.key' => $key,]);
                            $query->asArray();

                            $keyValue = '';
                            if ($priceList = $query->one()) {
                                $inputOptions['disabled'] = 'true';
                                $value = $priceList['name'].', Артикул '.$priceList['article_number'];
                                $keyValue = $key;
                            }

                            $html .= Html::hiddenInput('SendForm['.$form->id.']['.PriceList::PRODUCT_KEY.']', $keyValue);
                        }

                        $html .= Html::input('text', $fieldInputName, $value, $inputOptions);
                    } elseif ($field->type === FormField::TYPE_EMAIL) {
                        $html .= Html::input('email', $fieldInputName, '', $inputOptions);
                        if ($isRequired) {
                            $rules[$fieldInputName] = ['email' => true,];

                            if ($requiredMessage) {
                                $messages[$fieldInputName] = ['email' => 'Укажите адрес эл. почты',];
                            }
                        }
                    } elseif ($field->type === FormField::TYPE_PHONE) {
                        $fieldInputCountryID = $fieldInputID.'-country';
                        $fieldInputCountryName = $fieldInputName.'[country]';

                        $inputCountryOptions = ['class' => 'form-control', 'id' => $fieldInputCountryID, 'style' => ['height' => 'calc(2.25rem + 9px)',],];
                        if ($inputWidth) {
                            Html::addCssStyle($inputCountryOptions, ['width' => $inputWidth.'px',]);
                        } else {
                            Html::addCssStyle($inputCountryOptions, ['width' => '100%',]);
                        }

//                        $html .= Html::dropDownList($fieldInputCountryName, FormHelper::COUNTRY_RU, FormHelper::getCountryOptions(), $inputCountryOptions);

                        $html .= Html::input('tel', $fieldInputName, '', $inputOptions);
                    }

                    if ($textAfterInput) {
                        $html .= Html::tag('div', $textAfterInput, ['class' => $cssPrefix.'__optional-info',]);
                    }

                    $html .= Html::endTag('div');
                    break;
                case FormField::TYPE_REFERENCE_ID:
                    $html .= Html::beginTag('div', ['class' => $cssPrefix.'__input',]);
                    $html .= Html::tag('p', $field->name . ($isRequired ? ' '.Html::tag('span', '*') : ''));

                    if ($textBeforeInput) {
                        $html .= Html::tag('div', $textBeforeInput, ['class' => $cssPrefix.'__optional-info',]);
                    }

                    $inputOptions = ['id' => $fieldInputID, 'tabindex' => $tabIndex,];
                    if ($inputWidth) {
                        Html::addCssStyle($inputOptions, ['width' => $inputWidth.'px',]);
                    } else {
                        Html::addCssStyle($inputOptions, ['width' => '100%',]);
                    }
                    if ($placeholder) {
                        $inputOptions['prompt'] = $placeholder;
                    }

                    if ($referenceID) {
                        $html .= Html::beginTag('div', ['class' => '',]);
                        $html .= Html::dropDownList($fieldInputName, null, FormHelper::getReferenceValueList($referenceID), $inputOptions);
                        $html .= Html::endTag('div');
                    }

                    if ($textAfterInput) {
                        $html .= Html::tag('div', $textAfterInput, ['class' => $cssPrefix.'__optional-info',]);
                    }

                    $html .= Html::endTag('div');
                    break;
                case FormField::TYPE_CHECKBOX:
                    $html .= Html::beginTag('div', ['class' => $cssPrefix.'__agreement-checkbox',]);
                    $inputOptions = ['id' => $fieldInputID, 'tabindex' => $tabIndex,];

                    if ($isRequired) {
                        $inputOptions['required'] = 'true';
                    }

                    $html .= Html::checkbox($fieldInputName, $isChecked, $inputOptions);
                    $html .= Html::tag('label', $field->name, ['for' => $fieldInputID,]);

                    if ($textBeforeInput || $textAfterInput) {
                        if ($textBeforeInput) {
                            $html .= Html::tag('p', $textBeforeInput);
                        }
                        if ($textAfterInput) {
                            $html .= Html::tag('p', $textAfterInput);
                        }
                    }

                    $html .= Html::endTag('div');
                    break;
                case FormField::TYPE_BUTTON:
                    $html .= Html::beginTag('div', ['class' => $cssPrefix.'__button',]);

                    $inputOptions = ['style' => [], 'id' => $fieldInputID, 'name' => $fieldInputName, 'type' => 'submit', 'tabindex' => $tabIndex,];
                    if ($inputWidth) {
                        Html::addCssStyle($inputOptions, ['width' => $inputWidth.'px',]);
                    } else {
                        Html::addCssStyle($inputOptions, ['width' => '100%',]);
                    }
                    if ($buttonColor) {
                        Html::addCssStyle($inputOptions, ['background-color' => $buttonColor,]);
                    }
                    if ($buttonTextColor) {
                        Html::addCssStyle($inputOptions, ['color' => $buttonTextColor,]);
                    }
                    $html .= Html::button($buttonText, $inputOptions);

                    $html .= Html::endTag('div');
                    break;
            }

            $tabIndex++;
        }

        $html .= Html::endForm();

        return $html;
    }


    public static function renderField(string $field, array $data, yii\web\View $view = null): string
    {
        $label = $id = $input = '';
        $name = 'FormField[data][' . $field . ']';
        $options = ['id' => $id, 'class' => 'form-control',];
        $html = Html::beginTag('div', ['class' => 'form-group row',]);
        $value = $data[$field] ?? '';

        switch ($field) {
            case self::FIELD_TEXT_BEFORE_INPUT:
                $label = 'Текст перед полем ввода';
                $input = Html::textInput($name, $value, $options);
                break;
            case self::FIELD_BUTTON_TEXT:
                $label = 'Текст кнопки';
                $input = Html::textInput($name, $value, $options);
                break;
            case self::FIELD_INPUT_WIDTH:
                $label = 'Ширина поля ввода, пиксели';
                $input = Html::textInput($name, $value, $options);
                break;
            case self::FIELD_INPUT_PLACEHOLDER:
                $label = 'Тест подсказки';
                $input = Html::textInput($name, $value, $options);
                break;
            case self::FIELD_IS_REQUIRED:
                $label = 'Обязательный';
                $options['class'] = 'form-check-input';
                $options['style'] = 'height:16px;';
                $input = Html::checkbox($name, !empty($value), $options);
                break;
            case self::FIELD_TEXT_AFTER_INPUT:
                $label = 'Текст после поля ввода';
                $input = Html::textInput($name, $value, $options);
                break;
            case self::FIELD_REQUIRED_MESSAGE:
                $label = 'Текст про обязательное условие';
                $input = Html::textInput($name, $value, $options);
                break;
            case self::FIELD_VARIABLE:
                $label = 'Название переменной';
                $input = Html::textInput($name, $value, $options);
                break;
            case self::FIELD_BUTTON_COLOR:
                $options['type'] = 'color';
                $label = 'Цвет кнопки';
                $input = Html::textInput($name, $value, $options);
                break;
            case self::FIELD_BUTTON_TEXT_COLOR:
                $options['type'] = 'color';
                $label = 'Цвет текста кнопки';
                $input = Html::textInput($name, $value, $options);
                break;
            case self::FIELD_REFERENCE_ID:
                $label = 'Справочник';
                $input = Html::dropDownList($name, $value, self::getReferencesList(),
                    $options + ['prompt' => 'Выберите справочник...',]);
                break;
            case self::FIELD_IS_CHECKED:
                $label = 'Состояние галочки по умолчанию';
                $options['class'] = 'form-check-input';
                $options['style'] = 'height:16px;';
                $input = Html::checkbox($name, !empty($value), $options);
                break;
            case self::FIELD_WISIWIG:

                break;
        }

        if ($field === self::FIELD_WISIWIG) {
            $html .= Html::tag('div', $input);
        } else {
            $html .= Html::tag('label', $label, ['class' => 'col-sm-6 col-form-label', 'for' => $id,]);
            $html .= Html::tag('div', $input, ['class' => 'col-sm-6',]);
        }

        $html .= Html::endTag('div');

        return $html;
    }
}