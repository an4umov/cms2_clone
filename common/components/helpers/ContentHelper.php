<?php
namespace common\components\helpers;

use backend\components\helpers\MenuHelper;
use common\models\Articles;
use common\models\CatRecomend;
use common\models\ContentFilter;
use common\models\ContentTree;
use common\models\ContentTreeContent;
use common\models\Cross;
use common\models\FullPrice;
use common\models\PriceList;
use common\models\ReclamaStatus;
use common\models\SpecialOffers;
use frontend\components\widgets\SpecialOfferWidget;
use yii\db\Expression;
use yii\db\Query;
use \yii\helpers\Json;
use common\models\Block;
use common\models\BlockCommon;
use common\models\BlockField;
use common\models\BlockFieldList;
use common\models\BlockFieldValuesList;
use common\models\BlockReady;
use common\models\BlockReadyField;
use common\models\BlockReadyFieldValuesList;
use common\models\Catalog;
use common\models\Content;
use common\models\ContentBlock;
use common\models\Department;
use common\models\Form;
use common\models\FormField;
use frontend\components\widgets\LastNewsWidget;
use frontend\components\widgets\NewsTapeWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

class ContentHelper
{
    const MACRO_START = '{{{';
    const MACRO_END = '}}}';
    const MACRO_LINK = 'link';
    const MACRO_TARGET = 'target';
    const MACRO_DIALOG_ID = 'dialogID';
    const MACRO_BTN_BG_COLOR = 'btnBgColor';
    const MACRO_BTN_BORDER_COLOR = 'btnBorderColor';
    const MACRO_BTN_TEXT_COLOR = 'btnTextColor';
    const MACRO_BTN_FA_CLASS = 'btnFaClass';
    const MACRO_TEXT = 'text';
    const MODAL_FORM_PART = 'modal-form-';

    const BLOCK_PARAM_DATE = '_block_param_date_';
    const BLOCK_PARAM_IS_ANSWER = '_block_param_is_answer_';
    const BLOCK_PARAM_IS_LAST = '_block_param_is_last_';

    const GREEN_MENU_PRODUCTS_PAGE_ID = 40;
    const GREEN_MENU_MODELS_PAGE_ID = 41;

    /**
     * @param Content $content
     *
     * @return array
     */
    public static function getUsedDepartments(Content $content) : array
    {
        $rows = $content->getBlocksData();

        return $rows;
    }

    public static function getCurrentPage($content = '') : string
    {
        $currentPage = '';
        $routeName = \Yii::$app->controller->getRoute();
        if ($routeName == 'site/index') {
            $currentPage = 'home';
        }

        return $currentPage;
    }

    /**
     * @param Content         $content
     * @param bool            $isPage
     * @param Department|null $department
     * @param int             $custom_tag_id
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public static function renderContent(Content $content, bool $isPage = false, Department $department = null, int $custom_tag_id = 0) : string
    {
        $contentType = $content->type;
        $html = '';
        $currentPage = '';
        $blocks = [];
        $rows = $content->getBlocksData();
        foreach ($rows as $row) {
            if (empty($row['content_block_is_active'])) {
                continue;
            }

            $model = null;

            switch ($row['content_block_type']) {
                case ContentBlock::TYPE_BLOCK:
                    $model = new Block();
                    break;
                case ContentBlock::TYPE_BLOCK_READY:
                    $model = new BlockReady();
                    break;
                case ContentBlock::TYPE_FORM:
                    $model = new Form();
                    break;
            }

            if (!$model) {
                $html = 'Неизвестный тип блока: '.$row['content_block_type'];

                return $html;
            }

            $model->setAttributes($row, false);
            $model->data = $row['data'];
            $model->content_block_id = $row['content_block_id'];
            $model->content_block_type = $row['content_block_type'];
            $model->content_block_sort = $row['content_block_sort'];

            $blocks[] = $model;
            $currentPage = 'page';
            if ($model->global_type == 'aggregator_news_tape') {
                $contentType = 'newsList';
            }
        }

        $mainBlock = null;
        $secondaryBlocks = $otherBlocks = [];

        foreach ($blocks as $block) {
            switch ($block->global_type) {
                case Block::GLOBAL_TYPE_TEXT_NEWS_ANONS:
                    $mainBlock = $block;
                    break;
                case Block::GLOBAL_TYPE_TEXT_TWO_SQUARES:
                    // marked to remove
                    $secondaryBlocks[] = $block;
                    break;
                default:
                    // marked to remove
                    $otherBlocks[] = $block;
                    break;
            }
        }

        if ($contentType == 'news') {
            $mainBlockImage = $mainBlockHeader = $mainBlockText = $mainBlockDate = '';
            $mainBlockIsAnswer = $mainBlockIsImageUnderText = false;
            $fields = self::getBlockFields($mainBlock->id);
            $json = self::getBlockJson($mainBlock);
            foreach ($fields as $field) {
                $value = $json[$field['id']] ?? '';
                switch ($field['type']) {
                    case BlockField::TYPE_IMAGE:
                        $mainBlockImage = (string)$value;
                        break;
                    case BlockField::TYPE_TEXTAREA:
                        $mainBlockHeader = (string)$value;
                        break;
                    case BlockField::TYPE_TEXTAREA_EXT:
                        $mainBlockText = (string)$value;
                        break;
                    case BlockField::TYPE_DATE:
                        $date = time();
                        if ($value) {
                            $dates = explode('-', $value);
                            $date = mktime(0, 0, 0, $dates[1], $dates[2], $dates[0]);
                        }

                        $mainBlockDate = \Yii::$app->formatter->asDate($date);
                        break;
                    case BlockField::TYPE_BOOL:
                        $pos = mb_stripos($field['name'], 'Выводить', 0, 'utf-8');
                        if ($pos !== false) {
                            $mainBlockIsAnswer = (bool)$value;
                        }
                        if ($field['name'] === 'Картинка под текстом') {
                            $mainBlockIsImageUnderText = (bool)$value;
                        }
                        break;
                }

            }

            if ($isPage) {
                $html .= Html::beginTag('section', ['class' => 'single-news-post',]);
            }
            $html .= Html::beginTag('article', ['class' => 'news-post',]);

            $html .= Html::beginTag('div', ['class' => 'news-post__short',]);
            if ($mainBlockImage) {
                $html .= Html::tag('div', Html::img(self::prepareImage($mainBlockImage)), ['class' => 'news-post__short-picture',]);
            }
            $html .= Html::beginTag('div', ['class' => 'news-post__short-container',]);
            $html .= Html::beginTag('div', ['class' => 'news-post__short-info',]);
            $newsUrl = self::getNewsUrl($content['id'], $content['alias']);
            if ($mainBlockHeader) {
                $html .= Html::beginTag('div', ['class' => 'news-post__short-title',]);
                if ($newsUrl) {
                    $html .= Html::a($mainBlockHeader, self::getNewsUrl($content['id'], $content['alias']));
                } else {
                    $html .= Html::a($mainBlockHeader);
                }
                $html .= Html::endTag('div');
            }
            if ($mainBlockText) {
                $html .= Html::tag('div', self::parseMacroses($mainBlockText), ['class' => 'news-post__short-text',]);
            }
            $html .= Html::endTag('div'); //news-post__short-info

            $html .= Html::beginTag('div', ['class' => 'news-post__short-panel', 'style' => $isPage ? 'display: none;' : '',]);
            $html .= Html::beginTag('div', ['class' => 'news-post__short-bar',]);
            $html .= Html::tag('div', $mainBlockDate, ['class' => 'news-post__short-date',]);
            $html .= Html::tag('div',
                ($mainBlockIsAnswer ? Html::a(Html::tag('div', 'Задать вопрос', ['class' => 'news-post__short-btn--ask-tip',]), '#', ['class' => 'news-post__short-btn news-post__short-btn--ask',]) . ' ' : '')
                . Html::a(Html::tag('div', 'Поделиться', ['class' => 'news-post__short-btn--share-tip',]), '#', ['class' => 'news-post__short-btn news-post__short-btn--share',]),
                ['class' => 'news-post__short-btns',]
            );
            $html .= Html::endTag('div'); //news-post__short-bar

            if ($secondaryBlocks) {
                $html .= Html::a('Pазвернуть', '#', ['class' => 'news-post__short-open',]);
            }

            $html .= Html::endTag('div'); //news-post__short-panel
            $html .= Html::endTag('div'); //news-post__short-container
            $html .= Html::endTag('div'); //news-post__short

            $html .= Html::beginTag('div', ['class' => 'news-post__full', 'style' => $isPage ? 'display: block;' : 'display: none;',]);

            if ($blocks) {
                foreach ($blocks as $key => $block) {
                    if ($block->global_type == Block::GLOBAL_TYPE_GALLERY_IMAGE_SLIDER_1140) {
                        $html .= Html::beginTag('div', ['class' => 'news-post__full-block',]);
                    } else {
                        if ($key != 0 and $block->global_type != Block::GLOBAL_TYPE_TEXT_EMPTY_STRING) {
                            $html .= Html::beginTag('div', ['class' => 'news-post__full-block-minimized-wrapper',]);
                        }
                    }
                    if ($block instanceof Form) {
                        $text = self::renderForm($block);
                    } else {
                        $text = self::renderBlockByGlobalType($block, self::getBlockJson($block), $isPage);
                    }
                    $html .= self::parseMacroses($text);
                    if ($block->global_type == Block::GLOBAL_TYPE_GALLERY_IMAGE_SLIDER_1140) {
                        $html .= Html::endTag('div');
                    } else {
                        if ($key != 0 and $block->global_type != Block::GLOBAL_TYPE_TEXT_EMPTY_STRING) {
                            $html .= Html::endTag('div');
                        }
                    }
                }
            }

            if (!$isPage) {
                $html .= '
                <div class="news-post__full-panel">
                    <div class="news-post__full-bar">
                        <div class="news-post__full-date">' . $mainBlockDate . '</div>
                        <div class="news-post__full-btns">
                            '.($mainBlockIsAnswer ? '<a href="#" class="news-post__full-btn news-post__full-btn--ask"><div class="news-post__full-btn--ask-tip">Задать вопрос</div></a>' : '').'                                
                            <a href="#" class="news-post__full-btn news-post__full-btn--share">
                                <div class="news-post__full-btn--share-tip">Поделиться</div>
                            </a>
                        </div>
                    </div>
                    <a href="#" class="news-post__full-close">Свернуть</a>
                </div>';
            }
            $html .= Html::endTag('div');
            $html .= Html::endTag('article').PHP_EOL;
            if ($isPage) {
                $html .= Html::endTag('section') . PHP_EOL;
            }
        } else {
            if (!$isPage) {
                $block = array_shift($blocks);
                $blocks = [$block,];
            }
            $textOptions = ['class' => '', 'style' => [],];
    
            $contentText = '';
            
            foreach ($blocks as $block) {
                if ($block->global_type == Block::GLOBAL_TYPE_GALLERY_IMAGE_SLIDER_1140) {
                    $html .= Html::beginTag('section', ['class' => 'single-universal-slider', 'style' => 'max-width: 1140px; margin: 0 auto 0;']);

                }
                if ($block->global_type == Block::GLOBAL_TYPE_TEXT_TWO_SQUARES) {
                    $html .= Html::beginTag('div', ['class' => 'news-post__full', 'style' => $isPage ? 'display: block;' : 'display: none;',]);
                    $html .= Html::beginTag('div', ['class' => 'news-post__full-block-minimized-wrapper',]);
                }

                if ($block instanceof Form) {
                    $text = self::renderForm($block);
                } else {
                    $text = self::renderBlockByGlobalType($block, self::getBlockJson($block), $isPage);
                }
    
                if (!$isPage) {
                    $text = self::parseMacroses($text, true);
                    $text = strip_tags($text);
                    $text = AppHelper::truncateWords($text, 35);
                    $text = Html::tag('div', Html::tag('p', $text), $textOptions);
                } else {
                    $text = self::parseMacroses($text, false);
                }
                $html .= $text;
                if ($block->global_type == Block::GLOBAL_TYPE_TEXT_TWO_SQUARES) {
                    $html .= Html::endTag('div');
                    $html .= Html::endTag('div');
                }
                if ($block->global_type == Block::GLOBAL_TYPE_GALLERY_IMAGE_SLIDER_1140) {
                    
                    $html .= Html::endTag('section').PHP_EOL;
                }
            }
        }
        return $html;
    }

    /**
     * @param int    $id
     * @param string $type
     *
     * @return string
     */
    public static function renderModalAsk(int $id, string $type) : string
    {
        $html = '<div class="modal-ask">';
        $html .= Html::beginForm('/question-send', 'post', ['enableAjaxValidation' => false, 'enableClientValidation' => false, 'class' => 'modal-ask__form ask-form',]);
        $html .= Html::hiddenInput('SendQuestionForm[id]', $id);
        $html .= Html::hiddenInput('SendQuestionForm[type]', $type);

        $html .= '
            <div class="modal-ask__form-close"></div>
            <div class="ask-form__title">Задать вопрос</div>
            <div class="ask-form__info ask-info">
                <div class="ask-info__input">
                    <input type="text" required name="SendQuestionForm[name]" placeholder="Ваше имя" class="ask-info__input--name">
                </div>
                <div class="ask-info__input">
                    <input type="email" required name="SendQuestionForm[email]" placeholder="Ваш email" class="ask-info__input--mail">
                </div>
            </div>
            <div class="ask-form__id-news">Вопрос</div>
            <div class="ask-form__field ask-field">
                <textarea name="SendQuestionForm[comment]" required class="ask-field__text" placeholder="Задайте нам ваш вопрос"></textarea>
            </div>
            <button type="submit" class="ask-form__btn">Отправить</button>
        ';
        $html .= Html::endForm();
        $html .= '
            </div>        
        ';

        return $html;
    }

    /**
     * @param int    $id
     * @param string $type
     * @param string $url
     *
     * @return string
     */
    public static function renderModalShare(int $id, string $type, string $url) : string
    {
        return '
           <div class="modal-share">
               <div class="modal-share__form social-form">
                    <div class="modal-share__form-close"></div>
                    <div class="social-form__title">Поделиться</div>
                    <ul class="social-form__networks networks-inner">
                        <li class="networks-inner__item"><a href="#" class="networks-inner__item--vk"></a></li>
                        <li class="networks-inner__item"><a href="#" class="networks-inner__item--fb"></a></li>
                        <li class="networks-inner__item"><a href="#" class="networks-inner__item--tw"></a></li>
                        <li class="networks-inner__item"><a href="#" class="networks-inner__item--ok"></a></li>
                        <li class="networks-inner__item"><a href="#" class="networks-inner__item--wp"></a></li>
                        <li class="networks-inner__item"><a href="#" class="networks-inner__item--tg"></a></li>
                    </ul>
                    <div class="social-form__link link-field">
                        <div class="link-field__output">'.$url.'</div>
                        <div class="link-field__btn">Копировать</div>
                    </div>
               </div>
           </div>
        ';
    }

    /**
     * @param Form $form
     * @param bool $isModal
     *
     * @return string
     */
    public static function renderForm(Form $form, bool $isModal = false) : string
    {
        $formID = 'form-send-'.$form->id.'-'.rand(1, 1000);
        $modalID = self::MODAL_FORM_PART.$form->id;

        $html = Html::beginTag('div');
        if ($isModal) {
            $html .= Html::beginTag('div', ['id' => $modalID, 'class' => 'modal-form', 'style' => ['display' => 'none',],]);
        }

        $html .= Html::beginForm('/form-send', 'post', ['id' => $formID, 'enableAjaxValidation' => false, 'enableClientValidation' => false,]);
        $html .= Html::hiddenInput('SendForm[form_id]', $form->id);
//        $html .= print_r($form->attributes, true);

        $formOptions = ['style' => [], 'class' => 'col-sm-12 col-md-12 col-lg-12 col-xl-12 right_pay1 pt-3 pb-3',];
        if ($form->color_bg) {
            Html::addCssStyle($formOptions, ['background-color' => $form->color_bg,]);
        }
        if (!$isModal) {
            Html::addCssStyle($formOptions, ['width' => '50%', 'margin' => '0 auto',]);
        }
        $html .= Html::beginTag('div', $formOptions);

        if ($isModal) {
            $html .= Html::button('X', ['class' => 'btn btn-close',]);
        }

        $headerOptions = ['style' => [],];
        if ($form->color) {
            Html::addCssStyle($headerOptions, ['color' => $form->color,]);
        }
        $html .= Html::tag('h3', $form->name, $headerOptions);
        $fields = self::getFormFields($form->id);
        $rules = $messages = [];
        $maskPhoneJS = '';

        /** @var FormField $field */
        foreach ($fields as $field) {
            $json = self::getBlockJson($field);
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
                    $html .= Html::beginTag('div', ['class' => 'form-message',]);
                    $html .= $messageText;
                    $html .= Html::endTag('div');
                    break;
                case FormField::TYPE_TEXT:
                case FormField::TYPE_TEXTAREA:
                case FormField::TYPE_EMAIL:
                case FormField::TYPE_PHONE:
                    $html .= Html::beginTag('div', ['class' => 'form-group',]);
                    if ($textBeforeInput) {
                        $html .= Html::tag('label', $textBeforeInput . ($isRequired ? ' '.Html::tag('span', '(*)') : ''), ['for' => $fieldInputID,]);
                    }
                    $inputOptions = ['class' => 'form-control', 'style' => [], 'id' => $fieldInputID,];
                    if ($inputWidth) {
                        Html::addCssStyle($inputOptions, ['width' => $inputWidth.'px',]);
                    } else {
                        Html::addCssStyle($inputOptions, ['width' => '100%',]);
                    }
                    if ($placeholder) {
                        $inputOptions['placeholder'] = $placeholder;
                    }

                    if ($field->type === FormField::TYPE_TEXTAREA) {
                        $html .= Html::textarea($fieldInputName, '', $inputOptions + ['rows' => 4,]);
                    } elseif ($field->type === FormField::TYPE_TEXT) {
                        $html .= Html::input('text', $fieldInputName, '', $inputOptions);
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

                        $html .= Html::dropDownList($fieldInputCountryName, FormHelper::COUNTRY_RU, FormHelper::getCountryOptions(), $inputCountryOptions);

                        Html::addCssClass($inputOptions, 'mt-2');
                        $html .= Html::input('tel', $fieldInputName, '', $inputOptions);

                        $maskPhoneJS = "
                            jQuery('#".$fieldInputCountryID."').change(function() {
                                app.maskPhone('".$fieldInputCountryID."', '".$fieldInputID."');
                            });
                            
                            app.maskPhone('".$fieldInputCountryID."', '".$fieldInputID."');
                        ";
                    }

                    if ($textAfterInput) {
                        $html .= Html::tag('div', $textAfterInput, ['style' => 'font-size: 12px;',]);
                    }

                    $html .= Html::endTag('div');
                    break;
                case FormField::TYPE_REFERENCE_ID:
                    $html .= Html::beginTag('div', ['class' => 'form-group',]);
                    if ($textBeforeInput) {
                        $html .= Html::tag('label', $textBeforeInput . ($isRequired ? ' '.Html::tag('span', '(*)') : ''), ['for' => $fieldInputID,]);
                    }

                    $inputOptions = ['class' => 'form-control', 'style' => ['height' => 'calc(2.25rem + 9px)',], 'id' => $fieldInputID,];
                    if ($inputWidth) {
                        Html::addCssStyle($inputOptions, ['width' => $inputWidth.'px',]);
                    } else {
                        Html::addCssStyle($inputOptions, ['width' => '100%',]);
                    }
                    if ($placeholder) {
                        $inputOptions['prompt'] = $placeholder;
                    }

                    if ($referenceID) {
                        $html .= Html::beginTag('div', ['class' => 'form-group mb-0',]);
                        $html .= Html::dropDownList($fieldInputName, null, FormHelper::getReferenceValueList($referenceID), $inputOptions);
                        $html .= Html::endTag('div');
                    }

                    if ($textAfterInput) {
                        $html .= Html::tag('div', $textAfterInput, ['style' => 'font-size: 12px;',]);
                    }

                    $html .= Html::endTag('div');
                    break;
                case FormField::TYPE_CHECKBOX:
                    $html .= Html::beginTag('div', ['class' => 'form-check check1 custom-control custom-checkbox',]);
                    $inputOptions = ['class' => 'form-check-input custom-control-input', 'id' => $fieldInputID,];
                    $html .= Html::checkbox($fieldInputName, $isChecked, $inputOptions);

                    if ($textBeforeInput || $textAfterInput) {
                        $html .= Html::beginTag('label', ['class' => 'form-check-label form-check-label custom-control-label', 'for' => $fieldInputID, 'style' => 'padding-left: 10px;',]);
                        if ($textBeforeInput) {
                            $html .= Html::tag('h5', $textBeforeInput . ($isRequired ? ' '.Html::tag('span', '(*)') : ''));
                        }
                        if ($textAfterInput) {
                            $html .= Html::tag('div', $textAfterInput, ['class' => 'text0',]);
                        }
                        $html .= Html::endTag('label');
                    }

                    $html .= Html::endTag('div');
                    break;
                case FormField::TYPE_BUTTON:
                    $inputOptions = ['style' => [], 'id' => $fieldInputID, 'name' => $fieldInputName, 'type' => 'submit',];
                    if ($inputWidth) {
                        Html::addCssStyle($inputOptions, ['width' => $inputWidth.'px',]);
                    }
                    if ($buttonColor) {
                        Html::addCssStyle($inputOptions, ['background-color' => $buttonColor,]);
                    }
                    if ($buttonTextColor) {
                        Html::addCssStyle($inputOptions, ['color' => $buttonTextColor,]);
                    }
                    $html .= Html::button($buttonText, $inputOptions);
                    break;
            }
        }

        $html .= Html::endTag('div');
        $html .= Html::endForm();
        if ($isModal) {
            $html .= Html::endTag('div');
        }
        $html .= Html::endTag('div');

        /*if ($rules) {
            $html .= "
            <script>
                jQuery( document ).ready(function() {
                    jQuery('#".$formID."').validate({
                        rules: ".Json::encode($rules).",
                        messages: ".Json::encode($messages)."
                    });
                    ".$maskPhoneJS."
                });
            </script>";
        }*/

        return $html;
    }

    /**
     * @param BlockCommon $block
     * @param array       $json
     * @param bool        $isPage
     *
     * @return string
     * @throws \Exception
     */
    public static function renderBlockByGlobalType(BlockCommon $block, array $json, bool $isPage = false) : string
    {
        $html = '';
        $fields = self::getBlockFields($block->id, $block->content_block_type);

        switch ($block->global_type) {
            case Block::GLOBAL_TYPE_TEXT_NEWS_ANONS:
                //$html .= '<div class="alert alert-danger" role="alert">Этот новостной блок (#'.$block->id.') должен располагаться в соответствующем контенте!</div>';
                break;
            case Block::GLOBAL_TYPE_TEXT_TWO_SQUARES:
                $type = $leftText = $rightText = $leftImage = $rightImage = $imgVals = $valueItem = '';
                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';
                    switch ($field['type']) {
                        case BlockField::TYPE_VALUES_LIST:
                            $listValueModel = ($block->content_block_type === ContentBlock::TYPE_BLOCK) ? BlockFieldValuesList::findOne(['id' => (int) $value,]) : BlockReadyFieldValuesList::findOne(['id' => (int) $value,]);
                            if ($listValueModel) {
                                $type = $listValueModel->value;
                            }
                            break;
                        case BlockField::TYPE_TEXT:
                        case BlockField::TYPE_TEXTAREA:
                        case BlockField::TYPE_TEXTAREA_EXT:
                            $pos = mb_stripos($field['name'], 'слева', 0, 'utf-8');
                            if ($pos !== false) {
                                $leftText = (string) $value;
                            }
                            $pos = mb_stripos($field['name'], 'справа', 0, 'utf-8');
                            if ($pos !== false) {
                                $rightText = (string) $value;
                            }
                            break;
                        case BlockField::TYPE_LIST:
                            $pos = mb_stripos($field['name'], 'слева', 0, 'utf-8');
                            if ($pos !== false && is_array($value)) {
                                $leftImage = $sortValue = [];
                                $imgVals = [];
                                foreach ($value as $sort => $itemValue) {
                                    if (!empty($itemValue)) {
                                        if (isset($itemValue[Content::SORT_KEY])) {
                                            $fieldSort = (int)$itemValue[Content::SORT_KEY];
                                            unset($itemValue[Content::SORT_KEY]);
                                        } else {
                                            $fieldSort = $sort;
                                        }

                                        $sortValue[$fieldSort] = $itemValue;
                                    }
                                }
                                ksort($sortValue);
                                unset($value);
                                $ind = 0;
                                foreach ($sortValue as $sort => $itemValue) {
                                    if (!empty($itemValue)) {
                                        foreach ($itemValue as $value) {
                                            if (is_numeric($value)) {
                                                if (!empty($value)) {
                                                    $imgVals[$ind]['fill_image'] = $value;
                                                }
                                            } else {
                                                if (!empty($value)) {
                                                $pos = mb_stripos($value, 'youtube.com', 0, 'utf-8');
                                                    if ($pos !== false) {
                                                        $imgVals[$ind]['image'] = $value;
                                                    } else {
                                                        $imgVals[$ind]['image'] = self::prepareImage($value);
                                                    }
                                                }
                                            }
                                        }
                                        if (!empty($imgVals[$ind])) {
                                            $leftImage = $imgVals;
                                        }
                                        $ind++;
                                    }
                                }
                            }
                            $pos = mb_stripos($field['name'], 'справа', 0, 'utf-8');
                            if ($pos !== false && is_array($value)) {
                                $rightImage = $sortValue = [];
                                $imgVals = [];
                                foreach ($value as $sort => $itemValue) {
                                    if (!empty($itemValue)) {
                                        if (isset($itemValue[Content::SORT_KEY])) {
                                            $fieldSort = (int)$itemValue[Content::SORT_KEY];
                                            unset($itemValue[Content::SORT_KEY]);
                                        } else {
                                            $fieldSort = $sort;
                                        }

                                        $sortValue[$fieldSort] = $itemValue;
                                    }
                                }
                                ksort($sortValue);
                                unset($value);
                                $ind = 0;
                                foreach ($sortValue as $sort => $itemValue) {
                                    if (!empty($itemValue)) {
                                        foreach ($itemValue as $value) {
                                            if (is_numeric($value)) {
                                                if (!empty($value)) {
                                                    $imgVals[$ind]['fill_image'] = $value;
                                                }
                                            } else {
                                                if (!empty($value)) {
                                                $pos = mb_stripos($value, 'youtube.com', 0, 'utf-8');
                                                    if ($pos !== false) {
                                                        $imgVals[$ind]['image'] = $value;
                                                    } else {
                                                        $imgVals[$ind]['image'] = self::prepareImage($value);
                                                    }
                                                }
                                            }
                                        }
                                        if (!empty($imgVals[$ind])) {
                                            $rightImage = $imgVals;
                                        }
                                        $ind++;
                                    }
                                }
                            }
                            break;
                    }
                }

                $leftBlockContent = $rightBlockContent = '';

                if (!empty($leftImage)) {
                    if (count($leftImage) > 1) {
                        $leftImage = BlockHelper::getNewsCarousel($leftImage);
                    } else {
                        $imgCover = 'object-fit: contain;';
                        if (!empty($leftImage[0]['fill_image'])) {
                            $imgCover = 'object-fit: cover;';
                        }
                        $leftImage = Html::img($leftImage[0]['image'], ['alt' => '', 'style' => $imgCover]);
                    }
                }

                if (!empty($rightImage)) {
                    $imgCover = 'object-fit: contain;';
                    if (!empty($rightImage[0]['fill_image'])) {
                        $imgCover = 'object-fit: cover;';
                    }
                    if (count($rightImage) > 1) {
                        $rightImage = BlockHelper::getNewsCarousel($rightImage);
                    } else {
                        $rightImage = Html::img($rightImage[0]['image'], ['alt' => '', 'style' => $imgCover]);
                    }
                }

                $leftBlockClass = $rightBlockClass = 'news-post__full-block-minimized';
                if ($type === Block::FIELD_TYPE_VALUE_PIC_PIC) {
                    $leftBlockContent = $leftImage;
                    $rightBlockContent = $rightImage;
                } elseif ($type === Block::FIELD_TYPE_VALUE_TEXT_PIC) {
                    $leftBlockContent = Html::tag('div', $leftText, ['class' => 'news-post__full-regullar-text',]);
                    $rightBlockContent = $rightImage;
                } elseif ($type === Block::FIELD_TYPE_VALUE_TEXT_TEXT) {
                    $leftBlockContent = Html::tag('div', $leftText, ['class' => 'news-post__full-regullar-text',]);
                    $rightBlockContent = Html::tag('div', $rightText, ['class' => 'news-post__full-regullar-text',]);
                } elseif ($type === Block::FIELD_TYPE_VALUE_PIC_TEXT) {
                    $leftBlockContent = $leftImage;
                    $rightBlockContent = Html::tag('div', $rightText, ['class' => 'news-post__full-regullar-text',]);
                }
                
                if (self::getCurrentPage() == 'home') {
                    $html .= Html::beginTag('div', ['class' => 'news-post__full', 'style' => 'display: block;']);
                    $html .= Html::beginTag('div', ['class' => 'news-post__full-block-minimized-wrapper',]);
                }

                $html .= Html::tag('div', $leftBlockContent, ['class' => $leftBlockClass,]);
                $html .= Html::tag('div', $rightBlockContent, ['class' => $rightBlockClass,]);

                if (self::getCurrentPage() == 'home') {
                    $html .= Html::endTag('div');
                    $html .= Html::endTag('div');
                }
                break;
            case Block::GLOBAL_TYPE_GALLERY_IMAGE:
                $text = $copyright = $image = '';
                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';

                    switch ($field['type']) {
                        case BlockField::TYPE_IMAGE:
                            $image = (string) $value;
                            break;
                        case BlockField::TYPE_TEXT:
                        case BlockField::TYPE_TEXTAREA:
                        case BlockField::TYPE_TEXTAREA_EXT:
                            $pos = mb_stripos($field['name'], 'Копирайт', 0, 'utf-8');
                            if ($pos !== false) {
                                $copyright = (string) $value;
                            }
                            $pos = mb_stripos($field['name'], 'Подпись', 0, 'utf-8');
                            if ($pos !== false) {
                                $text = (string) $value;
                            }
                            break;
                    }
                }


                if ($image) {
                    $html .= Html::beginTag('div', ['class' => 'blockk13',]);
                    $html .= Html::beginTag('div', ['class' => 'container',]);
                    $html .= Html::beginTag('div', ['class' => 'row',]);
                    $html .= Html::beginTag('div', ['class' => 'product-slider', 'style' => 'margin: 0 auto;',]);
                    $html .= Html::beginTag('div', ['class' => 'carousel slide', 'id' => 'carousel'.$block->id, 'data-ride' => 'carousel'.$block->id,]);
                    $html .= Html::beginTag('div', ['class' => 'carousel-inner',]);
                    $html .= Html::beginTag('div', ['class' => 'carousel-item active',]);
                    $html .= Html::img(self::prepareImage($image));
                    if ($text || $copyright) {
                        $html .= Html::beginTag('div', ['class' => 'carousel-caption',]);
                        $html .= Html::tag('p', $text.($copyright ? ' © '.$copyright : ''));
                        $html .= Html::endTag('div');
                    }
                    $html .= Html::endTag('div');
                    $html .= Html::endTag('div');
                    $html .= Html::endTag('div');
                    $html .= Html::endTag('div');
                    $html .= Html::endTag('div');
                    $html .= Html::endTag('div');
                    $html .= Html::endTag('div');
                }
                break;
            case Block::GLOBAL_TYPE_GALLERY_TILE_3: // Галерея Плитка 3 и Плитка 6
            case Block::GLOBAL_TYPE_GALLERY_TILE_6:
                $header = $backgroundColor = $dummyText = $aboveText = $aboveTextBackgroundColor = $bottomText = $bottomTextBackgroundColor = '';
                $backgroundColorTransparency = 0;
                $galleryList = [];

                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';

                    switch ($field['type']) {
                        case BlockField::TYPE_TEXTAREA_EXT:
                            if ($field['name'] === 'Заголовок') {
                                $header = (string)$value;
                            }
                            if ($field['name'] === 'Текст заглушки') {
                                $dummyText = (string)$value;
                            }
                            $pos = mb_stripos($field['name'], 'сверху галереи', 0, 'utf-8');
                            if ($pos !== false) {
                                $aboveText = (string)$value;
                            }
                            $pos = mb_stripos($field['name'], 'внизу галереи', 0, 'utf-8');
                            if ($pos !== false) {
                                $bottomText = (string)$value;
                            }
                            break;
                        case BlockField::TYPE_COLOR:
                            if ($field['name'] === 'Цвет подложки') {
                                $backgroundColor = (string)$value;
                            }
                            $pos = mb_stripos($field['name'], 'текста сверху', 0, 'utf-8');
                            if ($pos !== false) {
                                $aboveTextBackgroundColor = (string)$value;
                            }
                            $pos = mb_stripos($field['name'], 'текста внизу', 0, 'utf-8');
                            if ($pos !== false) {
                                $bottomTextBackgroundColor = (string)$value;
                            }
                            break;
                        case BlockField::TYPE_DIGIT:
                            $backgroundColorTransparency = (float)$value;
                            break;
                        case BlockField::TYPE_LIST:
                            if (!empty($field['list']) && is_array($value) && !empty($value)) {
                                foreach ($value as $valueID => $valueItem) {
                                    $fieldImage = $fieldAlt = $fieldAltColor = $fieldSign = $fieldCopyright = '';
                                    $fieldSort = isset($valueItem[Content::SORT_KEY]) ? $valueItem[Content::SORT_KEY] : $valueID;

                                    /** @var BlockFieldList $item */
                                    foreach ($field['list'] as $item) {
                                        $val = (is_array($valueItem) && isset($valueItem[$item->id])) ? $valueItem[$item->id] : '';

                                        switch ($item->type) {
                                            case BlockField::TYPE_TEXTAREA:
                                                if ($item->name === 'Подсказка') {
                                                    $fieldAlt = (string)$val;
                                                } elseif ($item->name === 'Подпись') {
                                                    $fieldSign = (string)$val;
                                                } elseif ($item->name === 'Копирайт') {
                                                    $fieldCopyright = (string)$val;
                                                }
                                                break;
                                            case BlockField::TYPE_IMAGE:
                                                $fieldImage = (string)$val;
                                                break;
                                            case BlockField::TYPE_COLOR:
                                                $fieldAltColor = (string)$val;
                                                break;
                                        }
                                    }

                                    $galleryList[$fieldSort] = [
                                        'fieldID' => $valueID,
                                        'fieldImage' => $fieldImage,
                                        'fieldAlt' => $fieldAlt,
                                        'fieldAltColor' => $fieldAltColor,
                                        'fieldSign' => $fieldSign,
                                        'fieldCopyright' => $fieldCopyright,
                                    ];
                                }
                            }
                            break;
                    }
                }

                $blockOptions = ['class' => 'blockk12',];

                if (!empty($backgroundColor)) {
                    Html::addCssStyle($blockOptions, ['background-color' => $backgroundColor,]);
                }
                if (!empty($backgroundColorTransparency)) {
                    Html::addCssStyle($blockOptions, ['background-color' => AppHelper::hex2rgba($backgroundColor, $backgroundColorTransparency),]);
                }

                $html .= Html::beginTag('div', $blockOptions);
                $html .= Html::beginTag('div', ['class' => 'container',]);
                $html .= Html::beginTag('div', ['class' => 'row',]);

                if ($header || $aboveText) {
                    $html .= Html::beginTag('div', ['class' => 'col-12',]);
                    if ($header) {
                        $html .= $header;
                    }
                    if ($aboveText) {
                        if ($aboveTextBackgroundColor) {
                            $html .= Html::tag('div', $aboveText, ['style' => 'background-color:'.$aboveTextBackgroundColor,]);
                        } else {
                            $html .= $aboveText;
                        }
                    }
                    $html .= Html::endTag('div');
                }

                $html .= Html::beginTag('section', ['class' => 'gallery-block compact-gallery',]);
                $html .= Html::beginTag('div', ['class' => 'row no-gutters justify-content-center',]);

                ksort($galleryList);
                $index = 0;
                foreach ($galleryList as $fieldSort => $item) {
                    if (!empty($item['fieldImage'])) {
                        $class = 'col-md-6 col-lg-4 item zoom-on-hover';
                        if ($block->global_type === Block::GLOBAL_TYPE_GALLERY_TILE_6) {
                            $class = 'gallery-block__item item zoom-on-hover';
                        }

                        $html .= Html::beginTag('div', ['class' => $class,]);
                        $html .= Html::beginTag('a', ['class' => 'lightbox', 'href' => self::prepareImage($item['fieldImage']),]);
                        $html .= Html::img(self::prepareImage($item['fieldImage']), ['alt' => '', 'class' => 'img-fluid image']);
                        $html .= Html::beginTag('span', ['class' => 'description',]);
                        $html .= Html::tag('span', $item['fieldAlt'], ['class' => 'description-heading', 'style' => ['color' => !empty($item['fieldAltColor']) ? $item['fieldAltColor'] : 'white',]]);
                        $html .= Html::endTag('span');

                        if ($item['fieldSign'] || $item['fieldCopyright']) {
                            $html .= '';
                        }
                        $html .= Html::endTag('a');
                        $html .= Html::endTag('div').PHP_EOL;

                        $index++;
                    }
                }

                $html .= Html::endTag('div');

                if ($bottomText) {
                    $html .= Html::beginTag('div', ['class' => 'col-12',]);
                    if ($bottomTextBackgroundColor) {
                        $html .= Html::tag('div', $bottomText, ['style' => 'background-color: '.$bottomTextBackgroundColor,]);
                    } else {
                        $html .= $bottomText;
                    }
                    $html .= Html::endTag('div');
                }

                $html .= Html::endTag('section');

                $html .= Html::endTag('div');
                $html .= Html::endTag('div');
                $html .= Html::endTag('div');
                break;
            case Block::GLOBAL_TYPE_GALLERY_IMAGE_SLIDER_1140:
                $backgroundColor = '';
                $isAutoRotation = $isClickable = false;
                $galleryList = [];
                $delay = '';

                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';

                    switch ($field['type']) {
                        case BlockField::TYPE_COLOR:
                            $backgroundColor = (string)$value;
                            break;
                        case BlockField::TYPE_BOOL:
                            if ($field['name'] === 'Авторотация') {
                                $isAutoRotation = (bool)$value;
                            } elseif ($field['name'] === 'Кликабельные картинки') {
                                $isClickable = (bool)$value;
                            }
                            break;
                        case BlockField::TYPE_TEXT:
                            $delay = (string) $value;
                            break;
                        case BlockField::TYPE_LIST:
                            if (!empty($field['list']) && is_array($value) && !empty($value)) {
                                foreach ($value as $valueID => $valueItem) {
                                    $fieldImage = $fieldBackgroundColor = $fieldColor = $fieldSign = $fieldCopyright = '';
                                    $fieldSort = isset($valueItem[Content::SORT_KEY]) ? $valueItem[Content::SORT_KEY] : $valueID;

                                    /** @var BlockFieldList $item */
                                    foreach ($field['list'] as $item) {
                                        $val = (is_array($valueItem) && isset($valueItem[$item->id])) ? $valueItem[$item->id] : '';

                                        switch ($item->type) {
                                            case BlockField::TYPE_IMAGE:
                                                $fieldImage = (string)$val;
                                                break;
                                            case BlockField::TYPE_TEXTAREA:
                                                if ($item->name === 'Подпись') {
                                                    $fieldSign = (string)$val;
                                                } elseif ($item->name === 'Копирайт') {
                                                    $fieldCopyright = (string)$val;
                                                }
                                                break;
                                            case BlockField::TYPE_COLOR:
                                                if ($item->name === 'Цвет плашки под подпись и копирайт') {
                                                    $fieldBackgroundColor = (string)$val;
                                                } elseif ($item->name === 'Цвет текста подписи и копирайта') {
                                                    $fieldColor = (string)$val;
                                                }
                                                break;
                                            case BlockField::TYPE_BOOL:
                                                if ($item->name === 'Оригинальный размер') {
                                                    $fillImage = (string)$val;
                                                }
                                                break;
                                        }
                                    }

                                    $galleryList[$fieldSort] = [
                                        'fieldID' => $valueID,
                                        'fieldImage' => $fieldImage,
                                        'fieldBackgroundColor' => $fieldBackgroundColor,
                                        'fieldColor' => $fieldColor,
                                        'fieldSign' => $fieldSign,
                                        'fieldCopyright' => $fieldCopyright,
                                        'fillImage' => $fillImage,
                                    ];
                                }
                            }
                            break;
                    }
                }

                //$blockOptions = ['class' => 'news-post__full', 'style' => 'display: block;',];

                if (!empty($backgroundColor)) {
                    Html::addCssStyle($blockOptions, ['background-color' => $backgroundColor,]);
                }

                ksort($galleryList);

                foreach ($galleryList as $index => $item) {
                    if (!empty($item['fieldImage'])) {
                        $data[$index]['image'] = self::prepareImage($item['fieldImage']);
                    }
                    if (!empty($item['fillImage'])) {
                        $data[$index]['fill_image'] = true;
                    }
                }

                $html .= BlockHelper::getNewsCarousel($data);

                break;
            case Block::GLOBAL_TYPE_GALLERY_LIST:
                $html .= Html::tag('h1', 'Галерея должна быть здесь');
                break;
            case Block::GLOBAL_TYPE_GALLERY_TV:
                $text = $backgroundColor = $dummyText = $aboveText = $aboveTextBackgroundColor = $bottomText = $bottomTextBackgroundColor = '';
                $backgroundTransparency = 0;
                $galleryList = [];

                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';

                    switch ($field['type']) {
                        case BlockField::TYPE_TEXTAREA_EXT:
                            $pos = mb_stripos($field['name'], 'Заголовок', 0, 'utf-8');
                            if ($pos !== false) {
                                $text = (string)$value;
                            }
                            $pos = mb_stripos($field['name'], 'Текст заглушки', 0, 'utf-8');
                            if ($pos !== false) {
                                $dummyText = (string)$value;
                            }
                            $pos = mb_stripos($field['name'], 'сверху галереи', 0, 'utf-8');
                            if ($pos !== false) {
                                $aboveText = (string)$value;
                            }
                            $pos = mb_stripos($field['name'], 'внизу галереи', 0, 'utf-8');
                            if ($pos !== false) {
                                $bottomText = (string)$value;
                            }
                            break;
                        case BlockField::TYPE_COLOR:
                            $pos = mb_stripos($field['name'], 'Цвет подложки', 0, 'utf-8');
                            if ($pos !== false) {
                                $backgroundColor = (string)$value;
                            }
                            $pos = mb_stripos($field['name'], 'сверху галереи', 0, 'utf-8');
                            if ($pos !== false) {
                                $aboveTextBackgroundColor = (string)$value;
                            }
                            $pos = mb_stripos($field['name'], 'внизу галереи', 0, 'utf-8');
                            if ($pos !== false) {
                                $bottomTextBackgroundColor = (string)$value;
                            }
                            break;
                        case BlockField::TYPE_DIGIT:
                            $backgroundTransparency = (float)$value;
                            break;
                        case BlockField::TYPE_LIST:
                            if (!empty($field['list']) && is_array($value) && !empty($value)) {
                                foreach ($value as $valueID => $valueItem) {
                                    $fieldImage = $fieldSign = $fieldCopyright = '';
                                    $fieldSort = isset($valueItem[Content::SORT_KEY]) ? $valueItem[Content::SORT_KEY] : $valueID;

                                    /** @var BlockFieldList $item */
                                    foreach ($field['list'] as $item) {
                                        $val = (is_array($valueItem) && isset($valueItem[$item->id])) ? $valueItem[$item->id] : '';

                                        switch ($item->type) {
                                            case BlockField::TYPE_TEXTAREA:
                                                if ($item->name === 'Подпись') {
                                                    $fieldSign = (string)$val;
                                                } elseif ($item->name === 'Копирайт') {
                                                    $fieldCopyright = (string)$val;
                                                }
                                                break;
                                            case BlockField::TYPE_IMAGE:
                                                if ($item->name === 'Картинка') {
                                                    $fieldImage = (string)$val;
                                                }
                                                break;
                                        }
                                    }

                                    $galleryList[$fieldSort] = [
                                        'fieldID' => $valueID,
                                        'fieldImage' => $fieldImage,
                                        'fieldSign' => $fieldSign,
                                        'fieldCopyright' => $fieldCopyright,
                                    ];
                                }
                            }
                            break;
                    }
                }

                $blockOptions = ['class' => 'blockk13',];

                if (!empty($backgroundColor)) {
                    Html::addCssStyle($blockOptions, ['background-color' => $backgroundColor,]);
                }
                if (!empty($backgroundTransparency)) {
                    Html::addCssStyle($blockOptions, ['background-color' => AppHelper::hex2rgba($backgroundColor, $backgroundTransparency),]);
                }

                $html .= Html::beginTag('div', $blockOptions);
                $html .= Html::beginTag('div', ['class' => 'container',]);
                $html .= Html::beginTag('div', ['class' => 'row',]);

                if ($text || $aboveText) {
                    $html .= Html::beginTag('div', ['class' => 'col-12',]);
                    if ($text) {
                        $html .= $text;
                    }
                    if ($aboveText) {
                        if ($aboveTextBackgroundColor) {
                            $html .= Html::tag('div', $aboveText, ['style' => 'background-color:'.$aboveTextBackgroundColor,]);
                        } else {
                            $html .= $aboveText;
                        }
                    }
                    $html .= Html::endTag('div');
                }

                $hash = sha1($text.$dummyText.$aboveText.$bottomText.rand(1, 1000));
                $caruselIndex = substr($hash, 0, 7);

                $caruselID = 'carousel_'.$caruselIndex;
                $html .= Html::beginTag('div', ['class' => 'product-slider',]);
                $options = ['id' => $caruselID, 'class' => 'carousel slide', 'data' => ['ride' => 'carousel', 'interval' => 'false',],];
                $html .= Html::beginTag('div', $options);
                $html .= Html::beginTag('div', ['class' => 'carousel-inner',]);

                $linkContent = Html::tag('span', '', ['class' => 'carousel-control-prev-icon', 'aria-hidden' => 'true',]);
                $linkContent .= Html::tag('span', 'Previous', ['class' => 'sr-only',]);
                $html .= Html::a($linkContent, '#'.$caruselID, ['class' => 'carousel-control-prev d-flex d-md-none', 'role' => 'button', 'data-slide' => 'prev',]);

                $linkContent = Html::tag('span', '', ['class' => 'carousel-control-next-icon', 'aria-hidden' => 'true',]);
                $linkContent .= Html::tag('span', 'Next', ['class' => 'sr-only',]);
                $html .= Html::a($linkContent, '#'.$caruselID, ['class' => 'carousel-control-next d-flex d-md-none', 'role' => 'button', 'data-slide' => 'next',]);


                ksort($galleryList);
                $index = 0;
                foreach ($galleryList as $fieldSort => $item) {
                    if (!empty($item['fieldImage'])) {
                        $html .= Html::beginTag('div', ['class' => 'carousel-item'.($index === 0 ? ' active' : ''),]);
                        $html .= Html::img(self::prepareImage($item['fieldImage']), ['alt' => '',]);
                        if ($item['fieldSign'] || $item['fieldCopyright']) {
                            $html .= Html::beginTag('div', ['class' => 'carousel-caption',]);
                            $html .= Html::beginTag('p');
                            $html .= $item['fieldSign'] . ' ' .$item['fieldCopyright'];
                            $html .= Html::endTag('p');
                            $html .= Html::endTag('div');
                        }
                        $html .= Html::endTag('div').PHP_EOL;

                        $index++;
                    }
                }

                $html .= Html::endTag('div');
                $html .= Html::endTag('div');

                $carusel2ID = $caruselID.'_'.time();
                $html .= Html::beginTag('div', ['class' => 'clearfix d-none d-md-block',]);
                $html .= Html::beginTag('div', ['class' => 'carousel slide', 'id' => $carusel2ID, 'data' => ['interval' => 'false',],]);
                $html .= Html::beginTag('div', ['class' => 'carousel-inner',]);
                $html .= Html::beginTag('div', ['class' => 'carousel-item active d-flex flex-wrap',]);
                $index = 0;
                foreach ($galleryList as $fieldSort => $item) {
                    if (!empty($item['fieldImage'])) {
                        $html .= Html::beginTag('div', ['class' => 'thumb', 'data' => ['target' => '#'.$caruselID, 'slide-to' => $index++,]]);
                        $html .= Html::img(self::prepareImage($item['fieldImage']), ['alt' => '',]);
                        $html .= Html::endTag('div').PHP_EOL;
                    }
                }
                $html .= Html::endTag('div');
                $html .= Html::endTag('div');
                $html .= Html::endTag('div');
                $html .= Html::endTag('div'); // clearfix

                if ($bottomText) {
                    $html .= Html::beginTag('div', ['class' => 'col-12',]);
                    if ($bottomTextBackgroundColor) {
                        $html .= Html::tag('div', $bottomText, ['style' => 'background-color:'.$bottomTextBackgroundColor,]);
                    } else {
                        $html .= $bottomText;
                    }
                    $html .= Html::endTag('div');
                }

                $html .= Html::endTag('div'); //product-slider

                $html .= Html::endTag('div');
                $html .= Html::endTag('div');
                $html .= Html::endTag('div');

                $js = "<script> 
                    jQuery(function() {
                        app.equivalentHeight(jQuery('div.product-slider #".$caruselID." .carousel-item'));
                    });
                </script>";
                $html .= $js;

                break;
            case Block::GLOBAL_TYPE_GALLERY_YOUTUBE:
                $text = $backgroundColor = $aboveText = $aboveTextBackgroundColor = $bottomText = $bottomTextBackgroundColor = $link = '';
                $backgroundTransparency = 0;

                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';

                    switch ($field['type']) {
                        case BlockField::TYPE_TEXTAREA_EXT:
                            if ($field['name'] === 'Заголовок') {
                                $text = (string)$value;
                            }
                            if ($field['name'] === 'Текст сверху картинки') {
                                $aboveText = (string)$value;
                            }
                            if ($field['name'] === 'Текст внизу картинки') {
                                $bottomText = (string)$value;
                            }
                            break;
                        case BlockField::TYPE_COLOR:
                            if ($field['name'] === 'Цвет подложки') {
                                $backgroundColor = (string)$value;
                            }
                            if ($field['name'] === 'Цвет заливки текста сверху') {
                                $aboveTextBackgroundColor = (string)$value;
                            }
                            if ($field['name'] === 'Цвет заливки текста снизу') {
                                $bottomTextBackgroundColor = (string)$value;
                            }
                            break;
                        case BlockField::TYPE_DIGIT:
                            $backgroundTransparency = (float)$value;
                            break;
                        case BlockField::TYPE_TEXT:
                            $link = (string)$value;
                            break;
                    }
                }

                $blockOptions = ['class' => 'blockk1',];

                if (!empty($backgroundColor)) {
                    Html::addCssStyle($blockOptions, ['background-color' => $backgroundColor,]);
                }
                if (!empty($backgroundTransparency)) {
                    Html::addCssStyle($blockOptions, ['background-color' => AppHelper::hex2rgba($backgroundColor, $backgroundTransparency),]);
                }

                $html .= Html::beginTag('div', $blockOptions);
                $html .= Html::beginTag('div', ['class' => 'container mycontainer',]);
                $html .= Html::beginTag('div', ['class' => 'row',]);

                if ($text || $aboveText) {
                    $html .= Html::beginTag('div', ['class' => 'col-12',]);
                    if ($text) {
                        $html .= $text;
                    }
                    if ($aboveText) {
                        if ($aboveTextBackgroundColor) {
                            $html .= Html::tag('div', $aboveText, ['style' => 'background-color:'.$aboveTextBackgroundColor,]);
                        } else {
                            $html .= $aboveText;
                        }
                    }
                    $html .= Html::endTag('div');
                }

                if (!empty($link)) {
                    $html .= Html::beginTag('div', ['class' => 'col-12',]);
                    $html .= Html::beginTag('div', ['class' => 'embed-responsive embed-responsive-16by9',]);
                    $html .= Html::tag('iframe', '', ['width' => '100%', 'height' => '100%', 'src' => $link, 'frameborder' => '0', 'allow' => 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture', 'allowfullscreen' => true,]);
                    $html .= Html::endTag('div');
                    $html .= Html::endTag('div');
                }

                if ($bottomText) {
                    $html .= Html::beginTag('div', ['class' => 'col',]);
                    $options = ['style' => '',];

                    if (!empty($bottomTextBackgroundColor)) {
                        Html::addCssStyle($options, ['background-color' => $bottomTextBackgroundColor,]);
                    }

                    $html .= Html::beginTag('section', $options);
                    $html .= $bottomText;
                    $html .= Html::endTag('section');
                    $html .= Html::endTag('div');
                }

                $html .= Html::endTag('div');
                $html .= Html::endTag('div');
                $html .= Html::endTag('div');

                break;
            case Block::GLOBAL_TYPE_AGGREGATOR_NEWS_TILE: //Плитка новостей
                $text = '';
                $isExternal = '';
                $anonsCount = 0;
                $isForIndex = false;
                $tags = [];

                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';

                    switch ($field['type']) {
                        case BlockField::TYPE_TEXTAREA_EXT:
                            $text = (string)$value;
                            break;
                        case BlockField::TYPE_TEXT:
                            if ($field['name'] === 'Отдельная страница') {

                            }
                            $isExternal = (string)$value;
                            break;
                        case BlockField::TYPE_DIGIT:
                            $anonsCount = (int)$value;
                            break;
                        case BlockField::TYPE_TAGS:
                            $tags = (array)$value;
                            break;
                        case BlockField::TYPE_BOOL:
                            if ($field['name'] === 'Для главной') {
                                $isForIndex = (bool)$value;
                            }
                            break;
                    }
                }

                $html = LastNewsWidget::widget(['header' => $text, 'anonsCount' => $anonsCount, 'isExternal' => $isExternal, 'isForIndex' => $isForIndex, 'tags' => $tags,]);

                break;
            case Block::GLOBAL_TYPE_AGGREGATOR_NEWS_TAPE: //Лента новостей
                $text = '';
                $isPageFilter = false;
                $tags = $departmentFilter = $menuFilter = $tagFilter = [];
                $limit = $offset = 0;

                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';

                    switch ($field['type']) {
                        case BlockField::TYPE_TEXTAREA_EXT:
                            $text = (string)$value;
                            break;
                        case BlockField::TYPE_DIGIT:
                            if ($field['name'] === 'LIMIT') {
                                $limit = (int)$value;
                            }
                            if ($field['name'] === 'OFFSET') {
                                $offset = (int)$value;
                            }
                            break;
                        case BlockField::TYPE_TAGS:
                            $tags = (array)$value;
                            break;
                        case BlockField::TYPE_STRUCTURE_ID:
                            if (!empty($value[ContentFilter::TYPE_DEPARTMENT])) {
                                $departmentFilter = (array) $value[ContentFilter::TYPE_DEPARTMENT];
                            }
                            if (!empty($value[ContentFilter::TYPE_MENU])) {
                                $menuFilter = (array) $value[ContentFilter::TYPE_MENU];
                            }
                            if (!empty($value[ContentFilter::TYPE_TAG])) {
                                $tagFilter = (array) $value[ContentFilter::TYPE_TAG];
                            }
                            break;
                    }
                }

                $html = NewsTapeWidget::widget([
                    'header' => $text,
                    'isPageFilter' => $isPageFilter,
                    'limit' => $limit,
                    'offset' => $offset,
                    'tags' => $tags,
                    'departmentFilter' => $departmentFilter,
                    'menuFilter' => $menuFilter,
                    'tagFilter' => $tagFilter,
                ]);

                break;
            case Block::GLOBAL_TYPE_AGGREGATOR_SPECIAL_OFFER: //Спецпредложение Товаров
                $params = self::parseSpecialOfferBlock($fields, $json);
                $params['bid'] = $block->id;

                $html = SpecialOfferWidget::widget($params);

                break;
            case Block::GLOBAL_TYPE_TEXT_HEADER:
                $text = $textColor = '';
                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';

                    switch ($field['type']) {
                        case BlockField::TYPE_COLOR:
                            $textColor = (string) $value;
                            break;
                        case BlockField::TYPE_TEXT:
                        case BlockField::TYPE_TEXTAREA:
                        case BlockField::TYPE_TEXTAREA_EXT:
                            $text = (string) $value;
                            break;
                    }
                }

                $html .= Html::tag('section', Html::tag('div', $text, ['class' => 'unique-page-title__wrapper',]), ['class' => 'unique-page-title', 'style' => ($textColor ? 'background-color:'.$textColor.';' : ''),]);

                break;
            case Block::GLOBAL_TYPE_TEXT_850:
                $text = $backgroundColor = $backgroundImage = '';
                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';

                    switch ($field['type']) {
                        case BlockField::TYPE_IMAGE:
                            $backgroundImage = (string) $value;
                            break;
                        case BlockField::TYPE_COLOR:
                            $backgroundColor = (string) $value;
                            break;
                        case BlockField::TYPE_TEXT:
                        case BlockField::TYPE_TEXTAREA:
                        case BlockField::TYPE_TEXTAREA_EXT:
                            $text = (string) $value;
                            break;
                    }
                }

                $blockOptions = ['class' => 'blockk3',];

                $rowOptions = ['class' => 'row justify-content-center', 'style' => [],];

                if (!empty($backgroundImage)) {
                    Html::addCssStyle($blockOptions, ['background-image' => 'url(' . self::prepareImage($backgroundImage) . ')', 'background-repeat' => 'repeat', 'background-position' => 'top',]);
                } else {
                    Html::addCssStyle($blockOptions, ['background-image' => 'none',]);
                }
                if (!empty($backgroundColor)) {
                    Html::addCssStyle($blockOptions, ['background-color' => $backgroundColor,]);
                }

                $html .= Html::beginTag('div', $blockOptions);
                $html .= Html::beginTag('div', ['class' => 'container mycontainer', 'style' => 'max-width: 850px',]);
                $html .= Html::beginTag('div', $rowOptions);
                $html .= $text;
                $html .= Html::endTag('div');
                $html .= Html::endTag('div');
                $html .= Html::endTag('div');

                break;
            case Block::GLOBAL_TYPE_TEXT_EMPTY_STRING:
                $height = $backgroundColor = '';
                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';

                    switch ($field['type']) {
                        case BlockField::TYPE_COLOR:
                            $backgroundColor = (string) $value;
                            break;
                        case BlockField::TYPE_TEXT:
                            $height = (string) $value;
                            break;
                    }
                }

                $blockOptions = ['class' => 'empty-string', 'style' => ['width' => '100%',],];

                if (!empty($backgroundColor)) {
                    Html::addCssStyle($blockOptions, ['background-color' => $backgroundColor,]);
                }

                if (empty($height)) {
                    $height = '1px';
                }

                Html::addCssStyle($blockOptions, ['height' => $height.'px', ]);

                $html .= Html::tag('div', '', $blockOptions);

                break;
            case Block::GLOBAL_TYPE_BANNER_HOMEPAGE_1_4:
                $bannerBgImage = $bannerUrl = $module1BgColor = $module2BgColor = $module3BgColor = $module4BgColor = '';
                $bannerBgImageTransparency = $module1BgTransparency = $module2BgTransparency = $module3BgTransparency = $module4BgTransparency = 0;
                $module1ImageTransparency = $module2ImageTransparency = $module3ImageTransparency = $module4ImageTransparency = 0;
                $departmentID = 0;
                $module1Image = $module2Image = $module3Image = $module4Image =  '';
                $module1Text = $module2Text = $module3Text = $module4Text =  '';
                $module1ImageIsBg = $module2ImageIsBg = $module3ImageIsBg = $module4ImageIsBg = false;

                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';
                    switch ($field['type']) {
                        case BlockField::TYPE_COLOR:
                            $pos = mb_stripos($field['name'], 'Цвет заливки модуля 1', 0, 'utf-8');
                            if ($pos !== false) {
                                $module1BgColor = (string)$value;
                            }
                            $pos = mb_stripos($field['name'], 'Цвет заливки модуля 2', 0, 'utf-8');
                            if ($pos !== false) {
                                $module2BgColor = (string)$value;
                            }
                            $pos = mb_stripos($field['name'], 'Цвет заливки модуля 3', 0, 'utf-8');
                            if ($pos !== false) {
                                $module3BgColor = (string)$value;
                            }
                            $pos = mb_stripos($field['name'], 'Цвет заливки модуля 4', 0, 'utf-8');
                            if ($pos !== false) {
                                $module4BgColor = (string)$value;
                            }
                            break;
                        case BlockField::TYPE_DIGIT:
                            $pos = mb_stripos($field['name'], 'Прозрачность картинки подложки', 0, 'utf-8');
                            if ($pos !== false) {
                                $bannerBgImageTransparency = (float)$value;
                            }
                            $pos = mb_stripos($field['name'], 'Прозрачность заливки модуля 1', 0, 'utf-8');
                            if ($pos !== false) {
                                $module1BgTransparency = (float)$value;
                            }
                            $pos = mb_stripos($field['name'], 'Прозрачность заливки модуля 2', 0, 'utf-8');
                            if ($pos !== false) {
                                $module2BgTransparency = (float)$value;
                            }
                            $pos = mb_stripos($field['name'], 'Прозрачность заливки модуля 3', 0, 'utf-8');
                            if ($pos !== false) {
                                $module3BgTransparency = (float)$value;
                            }
                            $pos = mb_stripos($field['name'], 'Прозрачность заливки модуля 4', 0, 'utf-8');
                            if ($pos !== false) {
                                $module4BgTransparency = (float)$value;
                            }
                            $pos = mb_stripos($field['name'], 'прозрачность картинки модуля 1', 0, 'utf-8');
                            if ($pos !== false) {
                                $module1ImageTransparency = (float)$value;
                            }
                            $pos = mb_stripos($field['name'], 'прозрачность картинки модуля 2', 0, 'utf-8');
                            if ($pos !== false) {
                                $module2ImageTransparency = (float)$value;
                            }
                            $pos = mb_stripos($field['name'], 'прозрачность картинки модуля 3', 0, 'utf-8');
                            if ($pos !== false) {
                                $module3ImageTransparency = (float)$value;
                            }
                            $pos = mb_stripos($field['name'], 'прозрачность картинки модуля 4', 0, 'utf-8');
                            if ($pos !== false) {
                                $module4ImageTransparency = (float)$value;
                            }
                            $pos = mb_stripos($field['name'], 'Департамент', 0, 'utf-8');
                            if ($pos !== false) {
                                $departmentID = (int)$value;
                            }
                            break;
                        case BlockField::TYPE_IMAGE:
                            $pos = mb_stripos($field['name'], 'Картинка подложки', 0, 'utf-8');
                            if ($pos !== false) {
                                $bannerBgImage = (string)$value;
                            }
                            $pos = mb_stripos($field['name'], 'Картинка модуля 1', 0, 'utf-8');
                            if ($pos !== false) {
                                $module1Image = (string)$value;
                            }
                            $pos = mb_stripos($field['name'], 'Картинка модуля 2', 0, 'utf-8');
                            if ($pos !== false) {
                                $module2Image = (string)$value;
                            }
                            $pos = mb_stripos($field['name'], 'Картинка модуля 3', 0, 'utf-8');
                            if ($pos !== false) {
                                $module3Image = (string)$value;
                            }
                            $pos = mb_stripos($field['name'], 'Картинка модуля 4', 0, 'utf-8');
                            if ($pos !== false) {
                                $module4Image = (string)$value;
                            }
                            break;
                        case BlockField::TYPE_BOOL:
                            $pos = mb_stripos($field['name'], 'Картинка под текстом 1', 0, 'utf-8');
                            if ($pos !== false) {
                                $module1ImageIsBg = (bool)$value;
                            }
                            $pos = mb_stripos($field['name'], 'Картинка под текстом 2', 0, 'utf-8');
                            if ($pos !== false) {
                                $module2ImageIsBg = (bool)$value;
                            }
                            $pos = mb_stripos($field['name'], 'Картинка под текстом 3', 0, 'utf-8');
                            if ($pos !== false) {
                                $module3ImageIsBg = (bool)$value;
                            }
                            $pos = mb_stripos($field['name'], 'Картинка под текстом 4', 0, 'utf-8');
                            if ($pos !== false) {
                                $module4ImageIsBg = (bool)$value;
                            }
                            break;
                        case BlockField::TYPE_TEXT:
                        case BlockField::TYPE_TEXTAREA:
                        case BlockField::TYPE_TEXTAREA_EXT:
                            $pos = mb_stripos($field['name'], 'Текст модуля 1', 0, 'utf-8');
                            if ($pos !== false) {
                                $module1Text = (string) $value;
                            }
                            $pos = mb_stripos($field['name'], 'Текст модуля 2', 0, 'utf-8');
                            if ($pos !== false) {
                                $module2Text = (string) $value;
                            }
                            $pos = mb_stripos($field['name'], 'Текст модуля 3', 0, 'utf-8');
                            if ($pos !== false) {
                                $module3Text = (string) $value;
                            }
                            $pos = mb_stripos($field['name'], 'Текст модуля 4', 0, 'utf-8');
                            if ($pos !== false) {
                                $module4Text = (string) $value;
                            }
                            break;
                    }

                }

                $html .= Html::beginTag('div', ['class' => 'container mycontainer',]);
                $html .= Html::beginTag('div', ['class' => 'row',]);

                $options = ['class' => 'col-sm-12 col-md-12 col-lg-12 col-xl-12', 'style' => [],];
                $endLink = '';
                $html .= Html::beginTag('div', $options);
                if (!empty($departmentID)) {
                    $department = Department::findOne(['id' => $departmentID, 'is_active' => true,]);
                    if ($department) {
                        $html .= Html::beginTag('a', ['href' => Url::to(['shop/shop', 'shop' => $department->url,]), 'class' => 'color_a1',]);
                        $endLink = Html::endTag('a');
                    }
                }

                $options = ['class' => 'shop1', 'style' => [],];
                if (!empty($bannerBgImage)) {
                    Html::addCssStyle($options, ['background-image' => 'url('.self::prepareImage($bannerBgImage).')',]);
                    if (!empty($bannerBgImageTransparency) && $bannerBgImageTransparency < 1) {
                        Html::addCssStyle($options, ['background-color' => AppHelper::hex2rgba('#000000', $bannerBgImageTransparency),]);
                        Html::addCssStyle($options, ['background-blend-mode' => 'color',]);
                    }
                }
                $html .= Html::beginTag('div', $options);

                for ($index = 1; $index < 5; $index++) {
                    $options = ['class' => 'block'.$index, 'style' => [],];
                    if (!empty(${"module".$index."BgColor"})) {
                        if (!empty(${"module".$index."BgTransparency"})) {
                            Html::addCssStyle($options, ['background-color' => AppHelper::hex2rgba(${"module".$index."BgColor"}, ${"module".$index."BgTransparency"}),]);
                        } else {
                            Html::addCssStyle($options, ['background-color' => ${"module".$index."BgColor"},]);
                        }
                    } else {
                        Html::addCssClass($options, 'shop_color'.rand(1, 4));
                    }
                    if (!empty(${"module".$index."ImageIsBg"}) && !empty(${"module".$index."Image"})) {
                        Html::addCssStyle($options, [
                            'background-image' => 'url('.self::prepareImage(${"module".$index."Image"}).')',
                            'background-position' => 'top',
                            'background-repeat' => 'no-repeat',
                        ]);
                    }

                    $html .= Html::beginTag('div', $options);

                    if (!empty(${"module".$index."Image"}) && empty(${"module".$index."ImageIsBg"})) {
                        $html .= Html::tag('div', Html::img(self::prepareImage(${"module".$index."Image"}), ['alt' => '',]), ['class' => 'block2-image',]);
                    }

                    $html .= ${"module".$index."Text"};
                    $html .= Html::endTag('div');
                }

                $html .= Html::endTag('div');
                $html .= $endLink;
                $html .= Html::endTag('div');
                $html .= Html::endTag('div');
                $html .= Html::endTag('div');
                break;

            case Block::GLOBAL_TYPE_BANNER_HOMEPAGE_2_4:
                $department1ID = $department2ID = 0;
                $banner1BgImage = $banner2BgImage = '';
                $banner1BgImageTransparency = $banner2BgImageTransparency = 0;
                $module1Part1BgColor = $module1Part2BgColor = $module2Part1BgColor = $module2Part2BgColor = '';
                $module1Part1BgColorTransparency = $module1Part2BgColorTransparency = $module2Part1BgColorTransparency = $module2Part2BgColorTransparency = 0;
                $module1Part1Image = $module1Part2Image = $module2Part1Image = $module2Part2Image = '';
                $module1Part1ImageTransparency = $module1Part2ImageTransparency = $module2Part1ImageTransparency = $module2Part2ImageTransparency = 0;
                $module1Part1Text = $module1Part2Text = $module2Part1Text = $module2Part2Text =  '';

                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';
                    switch ($field['type']) {
                        case BlockField::TYPE_COLOR:
                            if ($field['name'] === 'Цвет заливки модуля 1 части 1') {
                                $module1Part1BgColor = (string)$value;
                            }
                            if ($field['name'] === 'Цвет заливки модуля 1 части 2') {
                                $module1Part2BgColor = (string)$value;
                            }
                            if ($field['name'] === 'Цвет заливки модуля 2 части 1') {
                                $module2Part1BgColor = (string)$value;
                            }
                            if ($field['name'] === 'Цвет заливки модуля 2 части 2') {
                                $module2Part2BgColor = (string)$value;
                            }
                            break;
                        case BlockField::TYPE_DIGIT:
                            if ($field['name'] === 'Прозрачность картинки подложки части 1') {
                                $banner1BgImageTransparency = (float)$value;
                            }
                            if ($field['name'] === 'Прозрачность картинки подложки части 2') {
                                $banner2BgImageTransparency = (float)$value;
                            }
                            if ($field['name'] === 'Прозрачность заливки модуля 1 части 1') {
                                $module1Part1BgColorTransparency = (float)$value;
                            }
                            if ($field['name'] === 'Прозрачность заливки модуля 1 части 2') {
                                $module1Part2BgColorTransparency = (float)$value;
                            }
                            if ($field['name'] === 'Прозрачность заливки модуля 2 части 1') {
                                $module2Part1BgColorTransparency = (float)$value;
                            }
                            if ($field['name'] === 'Прозрачность заливки модуля 2 части 2') {
                                $module2Part2BgColorTransparency = (float)$value;
                            }
                            if ($field['name'] === 'Прозрачность картинки модуля 1 части 1') {
                                $module1Part1ImageTransparency = (float)$value;
                            }
                            if ($field['name'] === 'Прозрачность картинки модуля 1 части 2') {
                                $module1Part2ImageTransparency = (float)$value;
                            }
                            if ($field['name'] === 'Прозрачность картинки модуля 2 части 1') {
                                $module2Part1ImageTransparency = (float)$value;
                            }
                            if ($field['name'] === 'Прозрачность картинки модуля 2 части 2') {
                                $module2Part2ImageTransparency = (float)$value;
                            }
                            if ($field['name'] === 'Id Департамента части 1') {
                                $department1ID = (int)$value;
                            }
                            if ($field['name'] === 'Id Департамента части 2') {
                                $department2ID = (int)$value;
                            }
                            break;
                        case BlockField::TYPE_IMAGE:
                            if ($field['name'] === 'Картинка подложки части 1') {
                                $banner1BgImage = (string)$value;
                            }
                            if ($field['name'] === 'Картинка подложки части 2') {
                                $banner2BgImage = (string)$value;
                            }
                            if ($field['name'] === 'Картинка модуля 1 части 1') {
                                $module1Part1Image = (string)$value;
                            }
                            if ($field['name'] === 'Картинка модуля 1 части 2') {
                                $module1Part2Image = (string)$value;
                            }
                            if ($field['name'] === 'Картинка модуля 2 части 1') {
                                $module2Part1Image = (string)$value;
                            }
                            if ($field['name'] === 'Картинка модуля 2 части 2') {
                                $module2Part2Image = (string)$value;
                            }
                            break;
                        case BlockField::TYPE_TEXT:
                        case BlockField::TYPE_TEXTAREA:
                        case BlockField::TYPE_TEXTAREA_EXT:
                            if ($field['name'] === 'Текст модуля 1 части 1') {
                                $module1Part1Text = (string) $value;
                            }
                            if ($field['name'] === 'Текст модуля 1 части 2') {
                                $module1Part2Text = (string) $value;
                            }
                            if ($field['name'] === 'Текст модуля 2 части 1') {
                                $module2Part1Text = (string) $value;
                            }
                            if ($field['name'] === 'Текст модуля 2 части 2') {
                                $module2Part2Text = (string) $value;
                            }
                            break;
                    }

                }

                $html .= Html::beginTag('div', ['class' => 'container mycontainer',]);
                $html .= Html::beginTag('div', ['class' => 'row',]);

                $paddings = [1 => 'right', 2 => 'left',];
                for ($topIndex = 1; $topIndex <= 2; $topIndex++) {
                    $options = ['class' => 'col-sm-12 col-md-12 col-lg-6 col-xl-6 padding-'.$paddings[$topIndex], 'style' => [],];
                    $endLink = '';
                    $html .= Html::beginTag('div', $options);
                    if (!empty(${"department" . $topIndex . "ID"})) {
                        if ($department = Department::find()->where([
                            'id' => ${"department" . $topIndex . "ID"},
                            'is_active' => true,
                        ])->asArray()->one()) {
                            $html .= Html::beginTag('a', [
                                'href' => Url::to(['shop/shop', 'shop' => $department['url'],]),
                                'class' => 'color_a1',
                            ]);
                            $endLink = Html::endTag('a');
                        }
                    }

                    $options = ['class' => 'shop2', 'style' => [],];
                    if (!empty(${"banner" . $topIndex . "BgImage"})) {
                        Html::addCssStyle($options, [
                            'background-image' => 'url(' . self::prepareImage(${"banner" . $topIndex . "BgImage"}) . ')',
                            'background-position' => 'top',
                            'background-repeat' => 'no-repeat',
                        ]);

                        if (!empty(${"banner".$topIndex."BgImageTransparency"}) && ${"banner" . $topIndex . "BgImageTransparency"} < 1) {
                            Html::addCssStyle($options, ['background-color' => AppHelper::hex2rgba('#000000', ${"banner" . $topIndex . "BgImageTransparency"}),]);
                            Html::addCssStyle($options, ['background-blend-mode' => 'color',]);
                        }
                    }
                    $html .= Html::beginTag('div', $options);

                    $colors = [1 => 'shop_color2', 2 => 'shop_color3',];
                    for ($index = 1; $index <= 2; $index++) {
                        $options = ['class' => 'block' . $index, 'style' => [],];
                        if (!empty(${"module".$topIndex."Part".$index."BgColor"})) {
                            if (!empty(${"module".$topIndex."Part".$index."BgColorTransparency"})) {
                                Html::addCssStyle($options, ['background-color' => AppHelper::hex2rgba(${"module".$topIndex."Part".$index."BgColor"}, ${"module".$topIndex."Part".$index."BgColorTransparency"}),]);
                            } else {
                                Html::addCssStyle($options, ['background-color' => ${"module".$topIndex."Part".$index."BgColor"},]);
                            }
                        } else {
                            Html::addCssClass($options, 'shop_color'.rand(1, 4));
                        }
                        $html .= Html::beginTag('div', $options);

                        if (!empty(${"module".$topIndex."Part".$index."Image"})) {
                            $html .= Html::beginTag('div', ['class' => 'block'.$index.'-image',]);
                            $options = ['style' => ['max-width' => '266px',], 'alt' => '',];
                            if (!empty(${"module".$topIndex."Part".$index."ImageTransparency"}) && ${"module".$topIndex."Part".$index."ImageTransparency"} < 1) {
                                Html::addCssStyle($options,
                                    ['opacity' => ${"module".$topIndex."Part".$index."ImageTransparency"},]);
                            }
                            $html .= Html::tag('div', Html::img(self::prepareImage(${"module".$topIndex."Part".$index."Image"}), $options), ['class' => 'block2-image',]);
                            $html .= Html::endTag('div');
                        }

                        if (!empty(${"module".$topIndex."Part".$index."Text"})) {
                            $html .= ${"module".$topIndex."Part".$index."Text"};
                        }
                        $html .= Html::endTag('div'); //block1
                    } // for

                    $html .= Html::endTag('div'); //shop2
                    $html .= $endLink;
                    $html .= Html::endTag('div'); //col-sm-12 col-md-12 col-lg-6 col-xl-6 padding-right
                }

                $html .= Html::endTag('div');
                $html .= Html::endTag('div');
                break;

            case Block::GLOBAL_TYPE_BANNER_HOMEPAGE_6_6:
                for ($index = 1; $index <= 6; $index++) {
                    ${"module".$index."BgColor"} = '';
                    ${"module".$index."BgColorTransparency"} = 0;
                    ${"module".$index."Image"} = '';
                    ${"module".$index."ImageTransparency"} = 0;
                    ${"module".$index."Text"} = '';
                    ${"department".$index."ID"} = 0;
                }

                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';
                    switch ($field['type']) {
                        case BlockField::TYPE_COLOR:
                            for ($index = 1; $index <= 6; $index++) {
                                if ($field['name'] === 'Цвет заливки модуля '.$index) {
                                    ${"module".$index."BgColor"} = (string)$value;
                                }
                            }
                            break;
                        case BlockField::TYPE_DIGIT:
                            for ($index = 1; $index <= 6; $index++) {
                                if ($field['name'] === 'Прозрачность заливки модуля '.$index) {
                                    ${"module".$index."BgColorTransparency"} = (float)$value;
                                }
                                if ($field['name'] === 'Прозрачность картинки модуля '.$index) {
                                    ${"module".$index."ImageTransparency"} = (float)$value;
                                }
                                if ($field['name'] === 'Id Департамента модуля '.$index) {
                                    ${"department".$index."ID"} = (int)$value;
                                }
                            }
                            break;
                        case BlockField::TYPE_IMAGE:
                            for ($index = 1; $index <= 6; $index++) {
                                if ($field['name'] === 'Картинка модуля '.$index) {
                                    ${"module".$index."Image"} = (string)$value;
                                }
                            }
                            break;
                        case BlockField::TYPE_TEXT:
                        case BlockField::TYPE_TEXTAREA:
                        case BlockField::TYPE_TEXTAREA_EXT:
                            for ($index = 1; $index <= 6; $index++) {
                                if ($field['name'] === 'Текст модуля '.$index) {
                                    ${"module".$index."Text"} = (string)$value;
                                }
                            }
                            break;
                    }

                }

                $html .= Html::beginTag('div', ['class' => 'container mycontainer',]);
                $html .= Html::beginTag('div', ['class' => 'd-flex justify-content-center flex-wrap',]);

                $departments = [];
                for ($index = 1; $index <= 6; $index++) {
                    $html .= Html::beginTag('div', ['class' => 'main-card__item-wrapper',]);
                    $endLink = '';
                    if (!empty(${"department" . $index . "ID"})) {
                        if (empty($departments[${"department" . $index . "ID"}])) {
                            $department = Department::find()->where([
                                'id' => ${"department" . $index . "ID"},
                                'is_active' => true,
                            ])->asArray()->one();
                        } else {
                            $department = $departments[${"department" . $index . "ID"}];
                        }

                        if ($department) {
                            $html .= Html::beginTag('a', [
                                'href' => Url::to(['shop/shop', 'shop' => $department['url'],]),
                            ]);
                            $endLink = Html::endTag('a');
                            $departments[${"department" . $index . "ID"}] = $department;
                        }
                    }

                    $options = ['class' => 'main-card__item-content', 'style' => [],];
                    if (!empty(${"module".$index."BgColor"})) {
                        if (!empty(${"module".$index."BgColorTransparency"})) {
                            Html::addCssStyle($options, ['background-color' => AppHelper::hex2rgba(${"module".$index."BgColor"}, ${"module".$index."BgColorTransparency"}),]);
                        } else {
                            Html::addCssStyle($options, ['background-color' => ${"module".$index."BgColor"},]);
                        }
                    }
                    $html .= Html::beginTag('div', $options);

                    if (!empty(${"module".$index."Image"})) {
                        $html .= Html::beginTag('div', ['class' => 'block'.$index.'-image',]);
                        $options = ['style' => ['max-width' => '142px',], 'alt' => '',];
                        if (!empty(${"module".$index."ImageTransparency"}) && ${"module".$index."ImageTransparency"} < 1) {
                            Html::addCssStyle($options, ['opacity' => ${"module".$index."ImageTransparency"},]);
                        }
                        $html .= Html::img(self::prepareImage(${"module".$index."Image"}), $options);
                        $html .= Html::endTag('div');
                    }

                    if (!empty(${"module".$index."Text"})) {
                        $html .= ${"module".$index."Text"};
                    }

                    $html .= Html::endTag('div');
                    $html .= $endLink;
                    $html .= Html::endTag('div');
                }

                $html .= Html::endTag('div');
                $html .= Html::endTag('div');
                break;

            case Block::GLOBAL_TYPE_BANNER_HOMEPAGE_8_8:
                $indexLimit = 8;
                for ($index = 1; $index <= $indexLimit; $index++) {
                    ${"module".$index."BgColor"} = '';
                    ${"module".$index."BgColorTransparency"} = 0;
                    ${"module".$index."Image"} = '';
                    ${"module".$index."ImageTransparency"} = 0;
                    ${"module".$index."Text"} = '';
                    ${"department".$index."ID"} = 0;
                }

                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';
                    switch ($field['type']) {
                        case BlockField::TYPE_COLOR:
                            for ($index = 1; $index <= $indexLimit; $index++) {
                                if ($field['name'] === 'Цвет заливки модуля '.$index) {
                                    ${"module".$index."BgColor"} = (string)$value;
                                }
                            }
                            break;
                        case BlockField::TYPE_DIGIT:
                            for ($index = 1; $index <= $indexLimit; $index++) {
                                if ($field['name'] === 'Прозрачность заливки модуля '.$index) {
                                    ${"module".$index."BgColorTransparency"} = (float)$value;
                                }
                                if ($field['name'] === 'Прозрачность картинки модуля '.$index) {
                                    ${"module".$index."ImageTransparency"} = (float)$value;
                                }
                                if ($field['name'] === 'Id Департамента модуля '.$index) {
                                    ${"department".$index."ID"} = (int)$value;
                                }
                            }
                            break;
                        case BlockField::TYPE_IMAGE:
                            for ($index = 1; $index <= $indexLimit; $index++) {
                                if ($field['name'] === 'Картинка модуля '.$index) {
                                    ${"module".$index."Image"} = (string)$value;
                                }
                            }
                            break;
                        case BlockField::TYPE_TEXT:
                        case BlockField::TYPE_TEXTAREA:
                        case BlockField::TYPE_TEXTAREA_EXT:
                            for ($index = 1; $index <= $indexLimit; $index++) {
                                if ($field['name'] === 'Текст модуля '.$index) {
                                    ${"module".$index."Text"} = (string)$value;
                                }
                            }
                            break;
                    }

                }

                $html .= Html::beginTag('div', ['class' => 'container mycontainer',]);
                $html .= Html::beginTag('div', ['class' => 'd-flex flex-wrap card-8-row justify-content-center',]);

                $departments = [];
                for ($index = 1; $index <= $indexLimit; $index++) {
                    $html .= Html::beginTag('div', ['class' => 'main-card__item-wrapper',]);
                    $endLink = '';
                    if (!empty(${"department" . $index . "ID"})) {
                        if (empty($departments[${"department" . $index . "ID"}])) {
                            $department = Department::find()->where([
                                'id' => ${"department" . $index . "ID"},
                                'is_active' => true,
                            ])->asArray()->one();
                        } else {
                            $department = $departments[${"department" . $index . "ID"}];
                        }

                        if ($department) {
                            $html .= Html::beginTag('a', [
                                'href' => Url::to(['shop/shop', 'shop' => $department['url'],]),
                            ]);
                            $endLink = Html::endTag('a');
                            $departments[${"department" . $index . "ID"}] = $department;
                        }
                    }

                    $options = ['class' => 'main-card__item-content', 'style' => [],];
                    if (!empty(${"module".$index."BgColor"})) {
                        if (!empty(${"module".$index."BgColorTransparency"})) {
                            Html::addCssStyle($options, ['background-color' => AppHelper::hex2rgba(${"module".$index."BgColor"}, ${"module".$index."BgColorTransparency"}),]);
                        } else {
                            Html::addCssStyle($options, ['background-color' => ${"module".$index."BgColor"},]);
                        }
                    }
                    $html .= Html::beginTag('div', $options);

                    if (!empty(${"module".$index."Image"})) {
                        $html .= Html::beginTag('div', ['class' => 'block'.$index.'-image',]);
                        $options = ['style' => ['max-width' => '117px',], 'alt' => '',];
                        if (!empty(${"module".$index."ImageTransparency"}) && ${"module".$index."ImageTransparency"} < 1) {
                            Html::addCssStyle($options, ['opacity' => ${"module".$index."ImageTransparency"},]);
                        }
                        $html .= Html::img(self::prepareImage(${"module".$index."Image"}), $options);
                        $html .= Html::endTag('div');
                    }

                    if (!empty(${"module".$index."Text"})) {
                        $html .= ${"module".$index."Text"};
                    }

                    $html .= Html::endTag('div');
                    $html .= $endLink;
                    $html .= Html::endTag('div');
                }

                $html .= Html::endTag('div');
                $html .= Html::endTag('div');
                break;

            case Block::GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_1:
                $link = $buttonText = $buttonColor =  ''; //Ссылка с баннера
                $isAutoRotation = false;
                $bannersList = [];

                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';
                    switch ($field['type']) {
                        case BlockField::TYPE_COLOR:
                            $buttonColor = (string)$value;
                            break;
                        case BlockField::TYPE_TEXT:
                            if ($field['name'] === 'Ссылка с баннера') {
                                $link = (string)$value;
                            } else {
                                $buttonText = (string)$value;
                            }
                            break;
                        case BlockField::TYPE_BOOL:
                            $isAutoRotation = (bool) $value;
                            break;

                        case BlockField::TYPE_LIST:
                            if (!empty($field['list']) && is_array($value) && !empty($value)) {
                                foreach ($value as $valueID => $valueItem) {
                                    $fieldLeftBgColor = $fieldLeftTextColor = $fieldLeftTextColorPart1 = $fieldRightBgColor = '';
                                    $fieldLeftHeader = $fieldLeftTextPart1 = $fieldLeftTextPart2 = '';
                                    $fieldImageMobile = $fieldImageDesktop = $fieldImageWide2k = '';
                                    $fieldSort = isset($valueItem[Content::SORT_KEY]) ? $valueItem[Content::SORT_KEY] : $valueID;

                                    /** @var BlockFieldList $item */
                                    foreach ($field['list'] as $item) {
                                        $val = (is_array($valueItem) && isset($valueItem[$item->id])) ? $valueItem[$item->id] : '';

                                        switch ($item->type) {
                                            case BlockField::TYPE_COLOR:
                                                if ($item->name === 'Цвет заливки левого блока') {
                                                    $fieldLeftBgColor = (string)$val;
                                                } elseif ($item->name === 'Цвет текста левого блока') {
                                                    $fieldLeftTextColor = (string)$val;
                                                } elseif ($item->name === 'Цвет текста левого блока первая часть') {
                                                    $fieldLeftTextColorPart1 = (string)$val;
                                                } elseif ($item->name === 'Цвет заливки правого блока') {
                                                    $fieldRightBgColor = (string)$val;
                                                }
                                                break;
                                            case BlockField::TYPE_TEXT:
                                                $fieldLeftHeader = (string)$val;
                                                break;
                                            case BlockField::TYPE_TEXTAREA:
                                                $pos = mb_stripos($item->name, 'Текст левого блока первая часть', 0, 'utf-8');
                                                if ($pos !== false) {
                                                    $fieldLeftTextPart1 = (string)$val;
                                                }
                                                $pos = mb_stripos($item->name, 'Текст левого блока вторая часть', 0, 'utf-8');
                                                if ($pos !== false) {
                                                    $fieldLeftTextPart2 = (string)$val;
                                                }

//                                                if ($item->name === 'Текст левого блока первая часть') {
//                                                    $fieldLeftTextPart1 = (string)$val;
//                                                } elseif ($item->name === 'Текст левого блока вторая часть') {
//                                                    $fieldLeftTextPart2 = (string)$val;
//                                                }
                                                break;
                                            case BlockField::TYPE_IMAGE:
                                                if ($item->name === 'Картинка правой части, mobile') {
                                                    $fieldImageMobile = (string)$val;
                                                } elseif ($item->name === 'Картинка правой части, desktop') {
                                                    $fieldImageDesktop = (string)$val;
                                                } elseif ($item->name === 'Картинка правой части, wide2k') {
                                                    $fieldImageWide2k = (string)$val;
                                                }
                                                break;
                                        }
                                    }

                                    $bannersList[$fieldSort] = [
                                        'fieldID' => $valueID,
                                        'fieldLeftBgColor' => $fieldLeftBgColor,
                                        'fieldLeftTextColor' => $fieldLeftTextColor,
                                        'fieldLeftTextColorPart1' => $fieldLeftTextColorPart1,
                                        'fieldRightBgColor' => $fieldRightBgColor,
                                        'fieldLeftHeader' => $fieldLeftHeader,
                                        'fieldLeftTextPart1' => nl2br($fieldLeftTextPart1),
                                        'fieldLeftTextPart2' => nl2br($fieldLeftTextPart2),
                                        'fieldImageMobile' => $fieldImageMobile,
                                        'fieldImageDesktop' => $fieldImageDesktop,
                                        'fieldImageWide2k' => $fieldImageWide2k,
                                    ];
                                }
                            }
                            break;
                    }
                }

                $html .= Html::beginTag('section', ['class' => 'departaments',]);
                $html .= Html::beginTag('div', ['class' => 'main-departament',]);

                $bannerButton = '';
                if ($link) {
                    $options = ['class' => 'main-dep-info__watch-all-btn', 'style' => '',];
                    if (!empty($buttonColor)) {
                        Html::addCssStyle($options, ['border-color' => $buttonColor,]);
                    }

                    $bannerButton = Html::a($buttonText ? $buttonText : 'Перейти', $link, $options);
                }


                ksort($bannersList);
                foreach ($bannersList as $fieldSort => $item) {
                    if (!empty($item['fieldImageMobile']) || !empty($item['fieldImageDesktop']) || !empty($item['fieldImageWide2k'])) {
                        $options = ['class' => 'main-departament__content', 'style' => '',];
                        if (!empty($item['fieldRightBgColor'])) {
                            Html::addCssStyle($options, ['background-color' => $item['fieldRightBgColor'],]);
                        }
                        $html .= Html::beginTag('div', $options);
                        $html .= Html::beginTag('picture');

                        if (!empty($item['fieldImageWide2k'])) {
                            $html .= Html::tag('source', '', ['media' => '(min-width: 1990px)', 'srcset' => self::prepareImage($item['fieldImageWide2k']),]);
                        }
                        if (!empty($item['fieldImageDesktop'])) {
                            $html .= Html::tag('source', '', ['media' => '(min-width: 768px)', 'srcset' => self::prepareImage($item['fieldImageDesktop']),]);
                        }
                        if (!empty($item['fieldImageMobile'])) {
                            $html .= Html::img(self::prepareImage($item['fieldImageMobile']), ['alt' => '',]);
                        }
                        $html .= Html::endTag('picture');
                        $html .= Html::endTag('div').PHP_EOL;
                    }

                    $options = ['class' => 'main-departament__info main-dep-info', 'style' => '',];
                    if (!empty($item['fieldLeftBgColor'])) {
                        Html::addCssStyle($options, ['background-color' => $item['fieldLeftBgColor'],]);
                    }
                    $html .= Html::beginTag('div', $options);

                    $options = ['class' => 'main-dep-info__title', 'style' => '',];
                    if (!empty($item['fieldLeftTextColor'])) {
                        Html::addCssStyle($options, ['color' => $item['fieldLeftTextColor'],]);
                    }
                    $html .= Html::beginTag('div', $options);
                    $html .= $item['fieldLeftHeader'];
                    $html .= Html::endTag('div').PHP_EOL;

                    $options = ['class' => 'main-dep-info__text', 'style' => '',];
                    if (!empty($item['fieldLeftTextColorPart1'])) {
                        Html::addCssStyle($options, ['color' => $item['fieldLeftTextColorPart1'],]);
                    }
                    $html .= Html::beginTag('div', $options);
                    $html .= $item['fieldLeftTextPart1'];
                    $html .= Html::endTag('div').PHP_EOL;

                    $html .= $bannerButton;

                    $html .= Html::endTag('div').PHP_EOL;
                    break;
                }

                $html .= Html::endTag('div');
                $html .= Html::endTag('section');
                break;

            case Block::GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_2:
                $link1 = $link2 = $button1Text = $button1Color =  $button2Text = $button2Color =  '';
                $isAutoRotation1 = $isAutoRotation2 = false;
                $bannersList1 = $bannersList2 = [];

                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';
                    switch ($field['type']) {
                        case BlockField::TYPE_COLOR:
                            if ($field['name'] === 'Цвет контура кнопки перехода 1') {
                                $button1Color = (string)$value;
                            } elseif ($field['name'] === 'Цвет контура кнопки перехода 2') {
                                $button2Color = (string)$value;
                            }
                            break;
                        case BlockField::TYPE_TEXT:
                            if ($field['name'] === 'Текст кнопки перехода 1') {
                                $button1Text = (string)$value;
                            } elseif ($field['name'] === 'Текст кнопки перехода 2') {
                                $button2Text = (string)$value;
                            } elseif ($field['name'] === 'Ссылка с баннера 1') {
                                $link1 = (string)$value;
                            } elseif ($field['name'] === 'Ссылка с баннера 2') {
                                $link2 = (string)$value;
                            }
                            break;
                        case BlockField::TYPE_BOOL:
                            if ($field['name'] === 'Авторотация 1') {
                                $isAutoRotation1 = (bool)$value;
                            } elseif ($field['name'] === 'Авторотация 2') {
                                $isAutoRotation2 = (bool)$value;
                            }
                            break;

                        case BlockField::TYPE_LIST:
                            for ($index = 1; $index <= 2; $index++) {
                                if ($field['name'] === 'Подбаннеры '.$index && !empty($field['list']) && is_array($value) && !empty($value)) {
                                    foreach ($value as $valueID => $valueItem) {
                                        $fieldLeftBgColor = $fieldLeftTextColor = $fieldLeftTextColorPart1 = $fieldRightBgColor = '';
                                        $fieldLeftHeader = $fieldLeftTextPart1 = $fieldLeftTextPart2 = '';
                                        $fieldImageMobile = $fieldImageDesktop = $fieldImageWide2k = '';
                                        $fieldSort = isset($valueItem[Content::SORT_KEY]) ? $valueItem[Content::SORT_KEY] : $valueID;

                                        /** @var BlockFieldList $item */
                                        foreach ($field['list'] as $item) {
                                            $val = (is_array($valueItem) && isset($valueItem[$item->id])) ? $valueItem[$item->id] : '';

                                            switch ($item->type) {
                                                case BlockField::TYPE_COLOR:
                                                    if ($item->name === 'Цвет заливки левого блока') {
                                                        $fieldLeftBgColor = (string)$val;
                                                    } elseif ($item->name === 'Цвет текста левого блока') {
                                                        $fieldLeftTextColor = (string)$val;
                                                    } elseif ($item->name === 'Цвет текста левого блока первая часть') {
                                                        $fieldLeftTextColorPart1 = (string)$val;
                                                    } elseif ($item->name === 'Цвет заливки правого блока') {
                                                        $fieldRightBgColor = (string)$val;
                                                    }
                                                    break;
                                                case BlockField::TYPE_TEXT:
                                                    $fieldLeftHeader = (string)$val;
                                                    break;
                                                case BlockField::TYPE_TEXTAREA:
                                                    if ($item->name === 'Текст левого блока первая часть') {
                                                        $fieldLeftTextPart1 = (string)$val;
                                                    } elseif ($item->name === 'Текст левого блока вторая часть') {
                                                        $fieldLeftTextPart2 = (string)$val;
                                                    }
                                                    break;
                                                case BlockField::TYPE_IMAGE:
                                                    if ($item->name === 'Картинка правой части, mobile') {
                                                        $fieldImageMobile = (string)$val;
                                                    } elseif ($item->name === 'Картинка правой части, desktop') {
                                                        $fieldImageDesktop = (string)$val;
                                                    } elseif ($item->name === 'Картинка правой части, wide2k') {
                                                        $fieldImageWide2k = (string)$val;
                                                    }
                                                    break;
                                            }
                                        }

                                        ${"bannersList".$index}[$fieldSort] = [
                                            'fieldID' => $valueID,
                                            'fieldLeftBgColor' => $fieldLeftBgColor,
                                            'fieldLeftTextColor' => $fieldLeftTextColor,
                                            'fieldLeftTextColorPart1' => $fieldLeftTextColorPart1,
                                            'fieldRightBgColor' => $fieldRightBgColor,
                                            'fieldLeftHeader' => $fieldLeftHeader,
                                            'fieldLeftTextPart1' => nl2br($fieldLeftTextPart1),
                                            'fieldLeftTextPart2' => nl2br($fieldLeftTextPart2),
                                            'fieldImageMobile' => $fieldImageMobile,
                                            'fieldImageDesktop' => $fieldImageDesktop,
                                            'fieldImageWide2k' => $fieldImageWide2k,
                                        ];
                                    }
                                }
                            }
                            break;
                    }
                }

                $html .= Html::beginTag('section', ['class' => 'departaments',]);
                $html .= Html::beginTag('div', ['class' => 'second-departaments',]);

                for ($index = 1; $index <= 2; $index++) {
                    $html .= Html::beginTag('div', ['class' => 'second-departaments__block',]);

                    $bannerButton = '';
                    if (!empty(${"link".$index})) {
                        $options = ['class' => 'sec-dep-info__watch-all-btn', 'style' => '',];
                        if (!empty(${"button".$index."Color"})) {
                            Html::addCssStyle($options, ['border-color' => ${"button".$index."Color"},]);
                        }

                        $bannerButton = Html::a(${"button".$index."Text"} ? ${"button".$index."Text"} : 'Перейти', ${"link".$index}, $options);
                    }

                    ksort(${"bannersList".$index});
                    foreach (${"bannersList".$index} as $fieldSort => $item) {
                        if (!empty($item['fieldImageMobile']) || !empty($item['fieldImageDesktop']) || !empty($item['fieldImageWide2k'])) {
                            $options = ['class' => 'second-departaments__content', 'style' => '',];
                            if (!empty($item['fieldRightBgColor'])) {
                                Html::addCssStyle($options, ['background-color' => $item['fieldRightBgColor'],]);
                            }

                            $html .= Html::beginTag('div', $options);
                            if (!empty($item['fieldImageDesktop'])) {
                                $html .= Html::img(self::prepareImage($item['fieldImageDesktop']), ['alt' => '',]);
                            } elseif (!empty($item['fieldImageMobile'])) {
                                $html .= Html::img(self::prepareImage($item['fieldImageMobile']), ['alt' => '',]);
                            } elseif (!empty($item['fieldImageWide2k'])) {
                                $html .= Html::img(self::prepareImage($item['fieldImageWide2k']), ['alt' => '',]);
                            }
                            $html .= Html::endTag('div').PHP_EOL;
                        }

                        $options = ['class' => 'second-departaments__info sec-dep-info', 'style' => '',];
                        if (!empty($item['fieldLeftBgColor'])) {
                            Html::addCssStyle($options, ['background-color' => $item['fieldLeftBgColor'],]);
                        }
                        $html .= Html::beginTag('div', $options);

                        $options = ['class' => 'sec-dep-info__title', 'style' => '',];
                        if (!empty($item['fieldLeftTextColor'])) {
                            Html::addCssStyle($options, ['color' => $item['fieldLeftTextColor'],]);
                        }
                        $html .= Html::beginTag('div', $options);
                        $html .= $item['fieldLeftHeader'];
                        $html .= Html::endTag('div').PHP_EOL;

                        $options = ['class' => 'sec-dep-info__text', 'style' => '',];
                        if (!empty($item['fieldLeftTextColorPart1'])) {
                            Html::addCssStyle($options, ['color' => $item['fieldLeftTextColorPart1'],]);
                        }
                        $html .= Html::beginTag('div', $options);
                        $html .= $item['fieldLeftTextPart1'];
                        $html .= Html::endTag('div').PHP_EOL;

                        $html .= $bannerButton;

                        $html .= Html::endTag('div').PHP_EOL;
                        break;
                    }

                    $html .= Html::endTag('div');
                }

                $html .= Html::endTag('div');
                $html .= Html::endTag('section');
                break;

            case Block::GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_3:
                $indexLimit = 3;
                for ($index = 1; $index <= $indexLimit; $index++) {
                    ${"department".$index."ID"} = 0;
                    ${"leftBgColor".$index} = '';
                    ${"leftHoverColor".$index} = '#3D4856';
                    ${"leftTextColor".$index} = '';
                    ${"leftTextColorPart1".$index} = '';
                    ${"rightBgColor".$index} = '';
                    ${"leftHeader".$index} = '';
                    ${"leftTextPart1".$index} = '';
                    ${"leftTextPart2".$index} = '';
                    ${"imageMobile".$index} = '';
                    ${"imageDesktop".$index} = '';
                    ${"imageWide2k".$index} = '';
                }

                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';
                    switch ($field['type']) {
                        case BlockField::TYPE_COLOR:
                            for ($index = 1; $index <= $indexLimit; $index++) {
                                if ($field['name'] === 'Цвет заливки левого блока '.$index) {
                                    ${"leftBgColor".$index} = (string)$value;
                                } elseif ($field['name'] === 'Цвет фона левого блока при наведении мышью '.$index) {
                                    if (!empty($value)) {
                                        ${"leftHoverColor".$index} = (string)$value;
                                    }
                                } elseif ($field['name'] === 'Цвет текста левого блока '.$index) {
                                    ${"leftTextColor".$index} = (string)$value;
                                } elseif ($field['name'] === 'Цвет текста левого блока первая часть '.$index) {
                                    ${"leftTextColorPart1".$index} = (string)$value;
                                } elseif ($field['name'] === 'Цвет заливки правого блока '.$index) {
                                    ${"rightBgColor".$index} = (string)$value;
                                }
                            }
                            break;
                        case BlockField::TYPE_DEPARTMENTS:
                            for ($index = 1; $index <= $indexLimit; $index++) {
                                if ($field['name'] === 'Департамент '.$index) {
                                    ${"department".$index."ID"} = (int)$value;
                                }
                            }
                            break;
                        case BlockField::TYPE_TEXT:
                            for ($index = 1; $index <= $indexLimit; $index++) {
                                if ($field['name'] === 'Текст заголовка левого блока '.$index) {
                                    ${"leftHeader".$index} = (string)$value;
                                }
                            }
                            break;
                        case BlockField::TYPE_TEXTAREA:
                            for ($index = 1; $index <= $indexLimit; $index++) {
                                if ($field['name'] === 'Текст левого блока первая часть '.$index) {
                                    ${"leftTextPart1".$index} = (string)$value;
                                } elseif ($field['name'] === 'Текст левого блока вторая часть '.$index) {
                                    ${"leftTextPart2".$index} = (string)$value;
                                }
                            }
                            break;
                        case BlockField::TYPE_IMAGE:
                            for ($index = 1; $index <= $indexLimit; $index++) {
                                if ($field['name'] === 'Картинка правой части, mobile '.$index) {
                                    ${"imageMobile".$index} = (string)$value;
                                } elseif ($field['name'] === 'Картинка правой части, desktop '.$index) {
                                    ${"imageDesktop".$index} = (string)$value;
                                } elseif ($field['name'] === 'Картинка правой части, wide2k '.$index) {
                                    ${"imageWide2k".$index} = (string)$value;
                                }
                            }
                            break;
                    }
                }

                $html .= Html::beginTag('section', ['class' => 'departaments',]);
                $html .= Html::beginTag('div', ['class' => 'third-departaments',]);

                for ($index = 1; $index <= $indexLimit; $index++) {
                    $options = ['class' => 'third-departaments__block', 'style' => '',];
                    $html .= Html::beginTag('div', $options);

                    $options = ['href' => 'javascript:void(0);', 'style' => '',];
                    if (!empty(${"department".$index."ID"})) {
                        $department = Department::find()->where([
                            'id' => ${"department".$index."ID"},
                            'is_active' => true,
                        ])->asArray()->one();

                        if ($department) {
                            $url = !empty($department['catalog_code']) ? Url::to(['catalog/view', 'code' => $department['catalog_code'],]) : Url::to(['shop/shop', 'shop' => $department['url'],]);
                            $options['href'] = $url;

//                            if (!empty(${"leftBgColor".$index})) {
//                                Html::addCssStyle($options, ['background-color' => ${"leftBgColor".$index},]);
//                            }
                        }
                    }
                    $bannerButton = Html::beginTag('a', $options);

                    $html .= $bannerButton;

                    $options = ['class' => 'third-departaments__info th-dep-info', 'style' => '',];
                    if (!empty(${"leftBgColor".$index})) {
                        Html::addCssStyle($options, ['background-color' => ${"leftBgColor".$index},]);
                    }
                    if (!empty(${"leftHoverColor".$index})) {
                        Html::addCssStyle($options, ['--hover-color' => ${"leftHoverColor".$index},]);
                    }
                    $html .= Html::beginTag('div', $options);

                    $options = ['class' => 'th-dep-info__title', 'style' => '',];
                    if (!empty(${"leftTextColor".$index})) {
                        Html::addCssStyle($options, ['color' => ${"leftTextColor".$index},]);
                    }
                    $html .= Html::beginTag('div', $options);
                    $html .= ${"leftHeader".$index};
                    $html .= Html::endTag('div').PHP_EOL;

                    $options = ['class' => 'th-dep-info__text', 'style' => '',];
                    if (!empty(${"leftTextColorPart1".$index})) {
                        Html::addCssStyle($options, ['color' => ${"leftTextColorPart1".$index},]);
                    }
                    $html .= Html::beginTag('div', $options);
                    $html .= ${"leftTextPart1".$index};
                    $html .= Html::endTag('div').PHP_EOL;
                    $html .= Html::endTag('div').PHP_EOL;

                    if (!empty(${"imageMobile".$index}) || !empty(${"imageDesktop".$index}) || !empty(${"imageWide2k".$index})) {
                        $options = ['class' => 'third-departaments__content', 'style' => '',];
                        if (!empty(${"rightBgColor".$index})) {
                            Html::addCssStyle($options, ['background-color' => ${"rightBgColor".$index},]);
                        }
                        $html .= Html::beginTag('div', $options);

                        if (!empty(${"imageDesktop".$index})) {
                            $html .= Html::img(self::prepareImage(${"imageDesktop".$index}), ['alt' => '',]);
                        } elseif (!empty(${"imageMobile".$index})) {
                            $html .= Html::img(self::prepareImage(${"imageMobile".$index}), ['alt' => '',]);
                        } elseif (!empty(${"imageWide2k".$index})) {
                            $html .= Html::img(self::prepareImage(${"imageWide2k".$index}), ['alt' => '',]);
                        }
                        $html .= Html::endTag('div').PHP_EOL;
                    }

                    $html .= Html::endTag('a');
                    $html .= Html::endTag('div');
                }

                $html .= Html::endTag('div');
                $html .= Html::endTag('section');
                break;

            case Block::GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_6:
                $indexLimit = 6;
                for ($index = 1; $index <= $indexLimit; $index++) {
                    ${"department".$index."ID"} = 0;
                    ${"bgColor".$index} = '';
                    ${"text".$index} = '';
                    ${"textColor".$index} = '';
                    ${"image".$index} = '';
                }

                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';
                    switch ($field['type']) {
                        case BlockField::TYPE_COLOR:
                            for ($index = 1; $index <= $indexLimit; $index++) {
                                if ($field['name'] === 'Цвет заливки '.$index) {
                                    ${"bgColor".$index} = (string)$value;
                                } elseif ($field['name'] === 'Цвет текста '.$index) {
                                    ${"textColor".$index} = (string)$value;
                                }
                            }
                            break;
                        case BlockField::TYPE_DEPARTMENTS:
                            for ($index = 1; $index <= $indexLimit; $index++) {
                                if ($field['name'] === 'Департамент '.$index) {
                                    ${"department".$index."ID"} = (int)$value;
                                }
                            }
                            break;
                        case BlockField::TYPE_TEXTAREA:
                            for ($index = 1; $index <= $indexLimit; $index++) {
                                if ($field['name'] === 'Текст '.$index) {
                                    ${"text" . $index} = (string)$value;
                                }
                            }
                            break;
                        case BlockField::TYPE_IMAGE:
                            for ($index = 1; $index <= $indexLimit; $index++) {
                                if ($field['name'] === 'Картинка '.$index) {
                                    ${"image" . $index} = (string)$value;
                                }
                            }
                            break;
                    }
                }

                $html .= Html::beginTag('section', ['class' => 'optional',]);
                $html .= Html::beginTag('ul', ['class' => 'optional-list',]);

                for ($index = 1; $index <= $indexLimit; $index++) {
                    $html .= Html::beginTag('li', ['class' => 'optional-list__item optional-list-item',]);

                    $options = [];
                    if (!empty(${"bgColor".$index})) {
                        Html::addCssStyle($options, ['background-color' => ${"bgColor".$index},]);
                    }
                    $bannerButton = Html::beginTag('a', $options);

                    if (!empty(${"department".$index."ID"})) {
                        $department = Department::find()->where([
                            'id' => ${"department".$index."ID"},
                            'is_active' => true,
                        ])->asArray()->one();

                        if ($department) {
                            $url = !empty($department['catalog_code']) ? Url::to(['catalog/view', 'code' => $department['catalog_code'],]) : Url::to(['shop/shop', 'shop' => $department['url'],]);

                            $options = ['href' => $url, 'style' => '',];
                            if (!empty(${"bgColor".$index})) {
                                Html::addCssStyle($options, ['background-color' => ${"bgColor".$index},]);
                            }
                            $bannerButton = Html::beginTag('a', $options);
                        }
                    }

                    $html .= $bannerButton;

                    if (!empty(${"image".$index})) {
                        $html .= Html::tag('div', Html::img(self::prepareImage(${"image".$index}), ['alt' => '',]), ['class' => 'optional-list-item__picture',]) . PHP_EOL;
                    }

                    if (!empty(${"text".$index})) {
                        $options = ['style' => '', 'class' => 'optional-list-item__text',];

                        if (!empty(${"textColor".$index})) {
                            Html::addCssStyle($options, ['color' => ${"textColor".$index},]);
                        }

                        $html .= Html::tag('div', ${"text".$index}, $options);
                    }

                    $html .= $bannerButton ? Html::endTag('a') : '';
                    $html .= Html::endTag('li');
                }

                $html .= Html::endTag('ul');
                $html .= Html::endTag('section');
                break;

            case Block::GLOBAL_TYPE_BANNER_AGREEMENT:
                $bannerAgreementCookieName = self::generateBannerAgreementCookieName($block->id);
                if (!empty($_COOKIE[$bannerAgreementCookieName])) { //баннер не выводится, если есть Куки
                    return $html;
                }

                $position = $bgColor = $text = $text = $buttonColor = $buttonText = '';
                $bannerFields = [];

                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';
                    switch ($field['type']) {
                        case BlockField::TYPE_COLOR:
                            if ($field['name'] === 'Цвет подложки') {
                                $bgColor = (string)$value;
                            }
                            if ($field['name'] === 'Цвет кнопки') {
                                $buttonColor = (string)$value;
                            }
                            break;
                        case BlockField::TYPE_TEXT:
                        case BlockField::TYPE_TEXTAREA:
                        case BlockField::TYPE_TEXTAREA_EXT:
                            if ($field['name'] === 'Заголовок') {
                                $text = (string)$value;
                            }
                            if ($field['name'] === 'Текст') {
                                $text = (string)$value;
                            }
                            if ($field['name'] === 'Текст кнопки') {
                                $buttonText = (string)$value;
                            }
                            break;
                        case BlockField::TYPE_VALUES_LIST:
                            if (!empty($field['values_list']) && is_array($field['values_list'])) {
                                foreach ($field['values_list'] as $item) {
                                    if ($value == $item->id) {
                                        $position = (string) $item->value;
                                        break;
                                    }
                                }
                            }
                            break;
                        case BlockField::TYPE_LIST:
                            if (!empty($field['list']) && is_array($value) && !empty($value)) {
                                foreach ($value as $valueID => $valueItem) {
                                    $fieldBgColor = $fieldColor = $fieldLink = $fieldText = '';
                                    $fieldSort = isset($valueItem[Content::SORT_KEY]) ? $valueItem[Content::SORT_KEY] : $valueID;

                                    /** @var BlockFieldList $item */
                                    foreach ($field['list'] as $item) {
                                        $val = (is_array($valueItem) && isset($valueItem[$item->id])) ? $valueItem[$item->id] : '';

                                        switch ($item->type) {
                                            case BlockField::TYPE_TEXTAREA:
                                                if ($item->name === 'Текст условия') {
                                                    $fieldText = (string)$val;
                                                }
                                                break;
                                            case BlockField::TYPE_TEXT:
                                                if ($item->name === 'Ссылка с условием') {
                                                    $fieldLink = (string)$val;
                                                }
                                                break;
                                            case BlockField::TYPE_COLOR:
                                                if ($item->name === 'Заливка прямоугольника с условием') {
                                                    $fieldBgColor = (string)$val;
                                                }
                                                if ($item->name === 'Цвет условия') {
                                                    $fieldColor = (string)$val;
                                                }
                                                break;
                                        }
                                    }

                                    $bannerFields[$fieldSort] = [
                                        'fieldID' => $valueID,
                                        'fieldBgColor' => $fieldBgColor,
                                        'fieldColor' => $fieldColor,
                                        'fieldLink' => $fieldLink,
                                        'fieldText' => $fieldText,
                                    ];
                                }
                            }
                            break;
                    }
                }

                $options = ['class' => 'overlay', 'style' => [], 'data' => ['name' => $bannerAgreementCookieName,],];
                if (!empty($bgColor)) {
                    $options['style'] = 'background-color:'.$bgColor;
                }
                if (!empty($position)) {
                    if ($position === 'сверху') {
                        Html::addCssStyle($options, ['top' => 0, 'bottom' => 'unset',]);
                    }
                }
                $html .= Html::beginTag('div', $options);
                $html .= Html::beginTag('div', ['class' => 'container mycontainer',]);

                $html .= Html::beginTag('button', ['class' => 'close btn-close banner-agreement-close', 'type' => 'button', 'aria-label' => 'Close',]);
                $html .= Html::tag('span', '&times;', ['aria-hidden' => 'true',]);
                $html .= Html::endTag('button');

                $html .= Html::beginTag('div', ['class' => 'row',]);

                $html .= Html::beginTag('div', ['class' => 'col-12  col-lg-2 d-flex justify-content-center align-items-center',]);
                $html .= Html::tag('i', '', ['aria-hidden' => 'true', 'class' => 'fa fa-info-circle',]);
                $html .= Html::endTag('div');

                if ($text || $text) {
                    $html .= Html::beginTag('div', ['class' => 'col-12 col-lg-10',]);
                    if ($text) {
                        $html .= Html::tag('h3', $text);
                    }
                    if ($text) {
                        $html .= Html::tag('p', $text);
                    }
                    $html .= Html::endTag('div');
                }

                $html .= Html::beginTag('div', ['class' => 'col-12 d-flex flex-wrap justify-content-between',]);
                ksort($bannerFields);
                foreach ($bannerFields as $bannerField) {
                    $id = 'banner-agreement-'.$bannerField['fieldID'];
                    $options = ['class' => 'custom-control custom-checkbox', 'style' => [],];
                    if (!empty($bannerField['fieldBgColor'])) {
                        Html::addCssStyle($options, ['background-color' => $bannerField['fieldBgColor'],]);
                    }
                    $html .= Html::beginTag('div', $options);
                    $html .= Html::checkbox('banner_agreement['.$bannerField['fieldID'].']', false, ['class' => 'custom-control-input assentingCheck', 'id' => $id,]);

                    $options = ['class' => 'custom-control-label', 'for' => $id, 'style' => ['position' => 'initial',],];
                    if (!empty($bannerField['fieldColor'])) {
                        Html::addCssStyle($options, ['color' => $bannerField['fieldColor'],]);
                    }
                    $html .= Html::tag('label', $bannerField['fieldText'].(!empty($bannerField['fieldLink']) ? ' ('.Html::a('подробнее ...', $bannerField['fieldLink'], ['target' => '_blank',]).')' : ''), $options);
                    $html .= Html::endTag('div');
                }
                $html .= Html::endTag('div');

                $options = ['type' => 'button', 'class' => 'btn btn-success btn-accept', 'disabled' => true,];
                if (!empty($buttonColor)) {
                    $options['style'] = 'background-color:'.$buttonColor;
                }
                $html .= Html::beginTag('div', ['class' => 'col-12 text-right mt-2',]);
                $html .= Html::tag('button', strip_tags($buttonText), $options);
                $html .= Html::endTag('div');

                $html .= Html::endTag('div');
                $html .= Html::endTag('div');
                $html .= Html::endTag('div');
                break;

            case Block::GLOBAL_TYPE_BANNER_NARROW: //Баннер узкий
                $bannerUrl = $bannerBgColor = $bannerBgImage = $header = $textColor = $message = $messageColor = '';
                $bannerBgGradientLeftColor = $bannerBgGradientCenterColor = $bannerBgGradientRightColor = '';
                $bannerBgColorTransparency = $bannerBgImageTransparency = 0;

                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';
                    switch ($field['type']) {
                        case BlockField::TYPE_COLOR:
                            $pos = mb_stripos($field['name'], 'Заливка подложк', 0, 'utf-8');
                            if ($pos !== false) {
                                $bannerBgColor = (string) $value;
                            }
                            $pos = mb_stripos($field['name'], 'Цвет заголовк', 0, 'utf-8');
                            if ($pos !== false) {
                                $textColor = (string) $value;
                            }
                            $pos = mb_stripos($field['name'], 'Цвет сообщ', 0, 'utf-8');
                            if ($pos !== false) {
                                $messageColor = (string) $value;
                            }
                            break;
                        case BlockField::TYPE_GRADIENT_COLOR:
                            $bannerBgGradientLeftColor = !empty($value[BlockField::GRADIENT_COLOR_LEFT]) ? $value[BlockField::GRADIENT_COLOR_LEFT] : '';
                            $bannerBgGradientCenterColor = !empty($value[BlockField::GRADIENT_COLOR_CENTER]) ? $value[BlockField::GRADIENT_COLOR_CENTER] : '';
                            $bannerBgGradientRightColor = !empty($value[BlockField::GRADIENT_COLOR_RIGHT]) ? $value[BlockField::GRADIENT_COLOR_RIGHT] : '';
                            break;
                        case BlockField::TYPE_DIGIT:
                            $pos = mb_stripos($field['name'], 'Прозрачность заливки', 0, 'utf-8');
                            if ($pos !== false) {
                                $bannerBgColorTransparency = (float) $value;
                            }
                            $pos = mb_stripos($field['name'], 'Прозрачность картинк', 0, 'utf-8');
                            if ($pos !== false) {
                                $bannerBgImageTransparency = (float) $value;
                            }
                            break;
                        case BlockField::TYPE_IMAGE:
                            $bannerBgImage = (string) $value;
                            break;
                        case BlockField::TYPE_TEXTAREA:
                        case BlockField::TYPE_TEXTAREA_EXT:
                            $pos = mb_stripos($field['name'], 'Заголовок', 0, 'utf-8');
                            if ($pos !== false) {
                                $header = (string) $value;
                            }
                            $pos = mb_stripos($field['name'], 'сообщен', 0, 'utf-8');
                            if ($pos !== false) {
                                $message = (string) $value;
                            }
                            break;
                        case BlockField::TYPE_TEXT:
                            $bannerUrl = (string) $value;
                            break;
                    }
                }

                $options = ['class' => 'promotion', 'style' => [],];

                if (!empty($bannerBgImage)) {
                    Html::addCssStyle($options, ['background-image' => 'url('.self::prepareImage($bannerBgImage).')',]);
                    if (!empty($bannerBgImageTransparency) && $bannerBgImageTransparency < 1) {
                        Html::addCssStyle($options, ['background-color' => AppHelper::hex2rgba('#000000', $bannerBgImageTransparency),]);
                        Html::addCssStyle($options, ['background-blend-mode' => 'color',]);
                    }
                } else {
                    if (!empty($bannerBgGradientLeftColor) && !empty($bannerBgGradientCenterColor) && !empty($bannerBgGradientRightColor)) {
                        Html::addCssStyle($options, ['background' =>
                            '-webkit-gradient(linear, left top, right top, color-stop(7%, '.$bannerBgGradientLeftColor.'), color-stop(60%, '.$bannerBgGradientCenterColor.'), to('.$bannerBgGradientRightColor.'));linear-gradient(90deg, '.$bannerBgGradientLeftColor.' 7%, '.$bannerBgGradientCenterColor.' 60%, '.$bannerBgGradientRightColor.' 100%)',]);
                    } elseif (!empty($bannerBgColor)){
                        if (!empty($bannerBgColorTransparency)) {
                            Html::addCssStyle($options,
                                ['background-color' => AppHelper::hex2rgba($bannerBgColor, $bannerBgColorTransparency),]);
                        } else {
                            Html::addCssStyle($options, ['background-color' => $bannerBgColor,]);
                        }
                    }
                }

                $html .= Html::beginTag('section', $options);
                $tagContent = '';
                if ($header) {
                    $options = ['class' => 'promotion__title', 'style' => [],];
                    if (!empty($textColor)) {
                        Html::addCssStyle($options, ['color' => $textColor,]);
                    }
                    $tagContent .= Html::tag('div', $header, $options);
                }
                if ($message) {
                    $options = ['class' => 'promotion__text', 'style' => [],];
                    if (!empty($messageColor)) {
                        Html::addCssStyle($options, ['color' => $messageColor,]);
                    }
                    $tagContent .= Html::tag('div', $message, $options);;
                }

                $url = $bannerUrl ? $bannerUrl : '/';
                $html .= Html::a($tagContent, $url);

                $html .= Html::endTag('section');
                break;
            case Block::GLOBAL_TYPE_SLIDER_CAROUSEL:
                $isAutoRotation = false;
                $delay = '';
                $sliderHeight = [];
                
                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';
                    if($field['type'] == 'digit') {
                        $delay = $value;
                    }
                    if ($field['type'] == 'list' || $field['type'] == 'radio') {
                        if ($field['type'] == 'radio' && isset($json[$field['id']])) {
                            $heightKey = 0;
                            $sliderType = '';
                            // 368 Слайдер "Как для Главной" во всю ширину
                            // 369 Слайдер "Как для Главной" с обрезкой по ширине 1140px
                            // 370 Слайдер с произвольной высотой, на всю ширину
                            // 371 Слайдер с произвольной высотой, с обрезкой по ширине 1140px
                            if (isset($json['radio_type_list'][0]['radio_type'])) {
                                $sliderType = $json['radio_type_list'][0]['radio_type'];
                                if ($sliderType == 370 || $sliderType == 371) {
                                    foreach ($json[$sliderType] as $radioTypeFileds) {

                                        foreach ($radioTypeFileds as $sliderHeightVal) {
                                            if ($heightKey == 0) {
                                                $sliderHeight['desktop'] = $sliderHeightVal;
                                            } elseif ($heightKey == 1) {
                                                $sliderHeight['tablet'] = $sliderHeightVal;
                                            } elseif ($heightKey == 2) {
                                                $sliderHeight['mobile'] = $sliderHeightVal;
                                            }
                                            $heightKey ++;
                                        }
                                    }
                                }
                            }
                        }
                        
                        if (!empty($field['list'])) {
                            $id = 'slider-'.$field['id'];
                            $items = [];
                            if (is_array($value) && !empty($value)) {
                                $sortValue = [];
                                $index = 0;
                                foreach ($value as $valueID => $valueItem) {
                                    $fieldSort = isset($valueItem[Content::SORT_KEY]) ? $valueItem[Content::SORT_KEY] : $valueID;
                                    $sortValue[$fieldSort] = $valueItem;
                                    
                                }
                                ksort($sortValue);
                                unset($value);
                                foreach ($sortValue as $valueItem) {
                                    $pageID = 0;
                                    /** @var BlockFieldList $item */
                                    foreach ($field['list'] as $key => $item) {
                                        $val = (is_array($valueItem) && isset($valueItem[$item->id])) ? $valueItem[$item->id] : '';
                                        switch ($item->type) {
                                            case BlockField::TYPE_IMAGE:
                                                if ($item->name === 'Картинка, desktop') {
                                                    $data[$index]['img']['desktop'] = (string)$val;
                                                } elseif ($item->name === 'Картинка, tablet') {
                                                    $data[$index]['img']['tablet'] = (string)$val;
                                                } elseif ($item->name === 'Картинка, mobile') {
                                                    $data[$index]['img']['mobile'] = (string)$val;
                                                }
                                                break;
                                            case BlockField::TYPE_TEXTAREA:
                                                if ($item->name === 'Заголовок') {
                                                    $data[$index]['header'] = (string)$val;
                                                } elseif ($item->name === 'Текст') {
                                                    $data[$index]['text'] = (string) $val;
                                                }
                                                break;
                                            case BlockField::TYPE_PAGE_ID:
                                                if ($item->name === 'Ссылка со слайда') {
                                                    $data[$index]['link'] = (string)$val;
                                                }
                                                break;
                                            case BlockField::TYPE_COLOR:
                                                if ($item->name === 'Цвет заголовка') {
                                                    $data[$index]['header_color'] = (string)$val;
                                                } elseif ($item->name === 'Цвет текста') {
                                                    $data[$index]['text_color'] = (string) $val;
                                                }
                                                break;
                                            case BlockField::TYPE_BOOL:
                                                if ($item->name === 'Оригинальный размер') {
                                                    $data[$index]['fill_image'] = (string)$val;
                                                }
                                                break;
                                        }
                                    }
                                    $index ++;
                                }
                            }
                        }
                        if (!empty($data)) {
                            if (isset($sliderType)) {
                                if (self::getCurrentPage() == 'home' || $sliderType == 368 || $sliderType == 369) {
                                    if (self::getCurrentPage() == 'home') {
                                        $sliderType = 368;
                                    }
                                    $html .= BlockHelper::getSlider($sliderType, $data, $delay);
                                } else {
                                    $html .= BlockHelper::getNewsSlider($sliderType, $sliderHeight, $data, $delay, $isPage);
                                }
                            }
                        }
                    }
                }
                break;
            case Block::GLOBAL_TYPE_FORM_DIALOG_LINK:
                $text = $textColor = '';
                $formID = 0;

                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';

                    switch ($field['type']) {
                        case BlockField::TYPE_COLOR:
                            $textColor = (string) $value;
                            break;
                        case BlockField::TYPE_FORMS:
                            $formID = (int) $value;
                            break;
                        case BlockField::TYPE_TEXT:
                        case BlockField::TYPE_TEXTAREA:
                        case BlockField::TYPE_TEXTAREA_EXT:
                            $text = (string) $value;
                            break;
                    }
                }

                $html .= Html::beginTag('div', ['class' => 'blockk3', 'style' => ['padding-top' => '25px', 'background' => 'none',],]);
                $html .= Html::beginTag('div', ['class' => 'container mycontainer',]);
                $html .= Html::beginTag('div', ['class' => 'row justify-content-center align-items-center',]);

                $modalID = self::MODAL_FORM_PART.$formID;
                $html .= Html::tag('div', Html::a($text, '#', ['class' => 'form_modal_dialog', 'data' => ['id' => $formID, 'modal' => $modalID,], 'style' => ($textColor ? 'color:'.$textColor.';' : ''),]));

                $html .= Html::endTag('div');
                $html .= Html::endTag('div');
                $html .= Html::endTag('div');

                $form = new Form();
                $form->setAttributes($block->attributes());
                $form->data = $block->data;
                $form->content_block_id = $block->content_block_id;
                $form->content_block_type = $block->content_block_type;
                $form->content_block_sort = $block->content_block_sort;
                $form->id = $formID;

                $html .= self::renderForm($form, true);

                break;
            default:
                $html .= '<div class="alert alert-warning" role="alert">Неопознанный тип блока! Требует вмешательства администрации сайта</div>';
                break;
        }

        return $html;
    }

    public static function generateBannerAgreementCookieName($id) : string
    {
        return 'banner-agreement-'.$id;
    }

    /**
     * @param int    $blockID
     * @param string $contentBlockType
     *
     * @return array
     */
    public static function getBlockFields(int $blockID, string $contentBlockType = ContentBlock::TYPE_BLOCK) : array
    {
        $fields = $rows = [];
        if ($contentBlockType === ContentBlock::TYPE_BLOCK) {
            $rows = BlockField::find()->where(['block_id' => $blockID, 'deleted_at' => null,])->orderBy(['sort' => SORT_ASC,])->all();
        } elseif ($contentBlockType === ContentBlock::TYPE_BLOCK_READY) {
            $rows = BlockReadyField::find()->where(['block_id' => $blockID,])->orderBy(['sort' => SORT_ASC,])->all();
        }

        foreach ($rows as $field) {
            if ($field->type === BlockField::TYPE_LIST) {
                $field->list = $field->getBlockFieldLists()->all();
            } elseif ($field->type === BlockField::TYPE_VALUES_LIST) {
                $field->values_list = $field->getBlockFieldValuesLists()->all();
            }

            $fields[] = [
                'id' => $field->id,
                'type' => $field->type,
                'name' => $field->name,
                'list' => !empty($field->list) ? $field->list : [],
                'values_list' => !empty($field->values_list) ? $field->values_list : [],
            ];
        }

        return $fields;
    }

    /**
     * @param int $formID
     *
     * @return FormField[]
     */
    public static function getFormFields(int $formID)
    {
        return FormField::find()->where(['form_id' => $formID, 'deleted_at' => null,])->orderBy(['sort' => SORT_ASC,])->all();
    }

    /**
     * @param $block
     *
     * @return array
     */
    public static function getBlockJson($block) : array
    {
        return !empty($block->data) ? Json::decode($block->data) : [];
    }

    /**
     * @param string $image
     *
     * @return string
     */
    public static function prepareImage(string $image) : string
    {
        $first = substr($image, 0, 1);
        if ($first === '/' || $first === '\\') {
            $image = substr($image, 1);
        }

        $image = str_replace('\\', '/', $image);
        $image = str_replace(' ', '%20', $image);

        return '/img/post/'.$image;
    }

    /**
     * @param Content $content
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public static function renderLastNews(Content $content) : string
    {
        $html = '';

        if ($mainBlock = $content->getNewsAnonsBlock()) {
            $mainBlockImage = $mainBlockHeader = $mainBlockText = '';
            $fields = self::getBlockFields($mainBlock->id);
            $json = self::getBlockJson($mainBlock);

            foreach ($fields as $field) {
                $value = $json[$field['id']] ?? '';
                switch ($field['type']) {
                    case BlockField::TYPE_IMAGE:
                        $mainBlockImage = (string)$value;
                        break;
                    case BlockField::TYPE_TEXTAREA:
                        $mainBlockHeader = AppHelper::truncate($value, 55);
                        break;
                    case BlockField::TYPE_TEXTAREA_EXT:
                        $mainBlockText = $value ? AppHelper::truncate(strip_tags($value), 130, '...') : '';
                        break;
                }
            }

            $html .= Html::beginTag('div', ['class' => 'news-slider__item js-news-slider__item',]);
            $html .= Html::beginTag('div', ['class' => 'news-slider__news-card',]);
            $html .= Html::beginTag('a', ['href' => $content->getContentUrl(),]);

            $html .= Html::beginTag('article', ['class' => 'news-card',]);
            $html .= Html::beginTag('div', ['class' => 'news-card__content',]);
            $html .= Html::img(self::prepareImage($mainBlockImage), ['alt' => '',]);
            $html .= Html::endTag('div');

            $html .= Html::beginTag('div', ['class' => 'news-card__info',]);
            $html .= Html::tag('div', $mainBlockHeader, ['class' => 'news-card__title',]);
            $html .= Html::tag('div', $mainBlockText, ['class' => 'news-card__text',]);
            $html .= Html::endTag('div');
            $html .= Html::endTag('article');

            $html .= Html::endTag('a');
            $html .= Html::endTag('div');
            $html .= Html::endTag('div');
        }

        return $html;
    }

    /**
     * @param Content $content
     *
     * @return string
     */
    public static function renderRelatedContent(Content $content) : string
    {
        $html = '';

        if ($mainBlock = $content->getNewsAnonsBlock()) {
            $mainBlockImage = $mainBlockHeader = $mainBlockText = '';
            $fields = self::getBlockFields($mainBlock->id);
            $json = self::getBlockJson($mainBlock);

            foreach ($fields as $field) {
                $value = $json[$field['id']] ?? '';
                switch ($field['type']) {
                    case BlockField::TYPE_IMAGE:
                        $mainBlockImage = (string)$value;
                        break;
                    case BlockField::TYPE_TEXTAREA:
                        $mainBlockHeader = AppHelper::truncate($value, 55);
                        break;
                    case BlockField::TYPE_TEXTAREA_EXT:
                        $mainBlockText = $value ? AppHelper::truncate(strip_tags($value), 130, '...') : '';
                        break;
                }
            }

            $html .= Html::beginTag('article', ['class' => 'related-news-card',]);
            $html .= Html::beginTag('a', ['href' => $content->getContentUrl(),]);
            $html .= Html::beginTag('div', ['class' => 'related-news-card__content',]);
            $html .= Html::img(self::prepareImage($mainBlockImage), ['alt' => '',]);
            $html .= Html::endTag('div');
            $html .= Html::beginTag('div', ['class' => 'related-news-card__info',]);
            $html .= Html::tag('div', $mainBlockHeader, ['class' => 'related-news-card__title',]);
            $html .= Html::tag('div', $mainBlockText, ['class' => 'related-news-card__text',]);
            $html .= Html::endTag('div');
            $html .= Html::endTag('a');
            $html .= Html::endTag('article');

        }

        return $html;
    }

    /**
     * @param string $text
     * @param bool   $isClean
     *
     * @return string
     */
    public static function parseMacroses(string $text, bool $isClean = false) : string
    {
        $pos = mb_strpos($text, self::MACRO_START);
        if ($pos === false) {
            return $text;
        }
        $pos = 0;

        while (($pos = mb_strpos($text, self::MACRO_START, $pos)) !== false) {
            if (($endIndex = mb_strpos($text, self::MACRO_END, $pos)) !== false) {
                $block = ['vars' => [], 'start' => $pos, 'end' => $endIndex + mb_strlen(self::MACRO_END), 'html' => '',];
                $startIndex = $pos + mb_strlen(self::MACRO_START);
                $macrosContent = mb_substr($text, $startIndex, $endIndex - $startIndex);

                if ($macrosContent) {
                    try {
                        $block['vars'] = current((array) new \SimpleXMLElement("<foo $macrosContent />"));
                        $block['html'] = $isClean ? '' : self::renderButtonMacro($block['vars']);

                        $text = mb_substr($text, 0, $block['start']).$block['html'].mb_substr($text, $block['end']);
                    } catch (\Exception $e) {
                        break;
                    }
                }
            } else {
                break;
            }
        }

        return $text;
    }

    /**
     * @param array $vars
     *
     * @return string
     */
    public static function renderButtonMacro(array $vars) : string
    {
        $options = ['class' => 'news-post__short-btn--buy', 'style' => [
            // 'font-size' => '15px',
            // 'text-transform' => 'uppercase',
            // 'padding' => '10px 24px',
            // 'border-radius' => '3px',
            // 'font-weight' => 'bold',
            // 'text-decoration' => 'none',
            // 'text-align' => 'center',
        ],];
        $url = $vars[self::MACRO_LINK] ?? ($vars[self::MACRO_DIALOG_ID] ? '#' : '#');

        if (empty($vars[self::MACRO_LINK]) && !empty($vars[self::MACRO_DIALOG_ID])) {
            Html::addCssClass($options, ['macros-dlg',]);
            $options += ['data' => ['id' => $vars[self::MACRO_DIALOG_ID],]];
        }
        if (!empty($vars[self::MACRO_BTN_BG_COLOR])) {
            Html::addCssStyle($options, ['background-color' => $vars[self::MACRO_BTN_BG_COLOR],]);
        }
        if (!empty($vars[self::MACRO_TARGET])) {
            $options += [self::MACRO_TARGET => $vars[self::MACRO_TARGET]];
        }
        if (!empty($vars[self::MACRO_BTN_BORDER_COLOR])) {
            Html::addCssStyle($options, ['border' => '1px solid '.$vars[self::MACRO_BTN_BORDER_COLOR],]);
        }
        if (!empty($vars[self::MACRO_BTN_TEXT_COLOR])) {
            Html::addCssStyle($options, ['color' => $vars[self::MACRO_BTN_TEXT_COLOR],]);
        }
        if (!empty($vars[self::MACRO_BTN_FA_CLASS])) {
            $vars[self::MACRO_TEXT] = Html::tag('i', '', ['class' => $vars[self::MACRO_BTN_FA_CLASS],]).' '.$vars[self::MACRO_TEXT];
        }

        return Html::a($vars[self::MACRO_TEXT] ?? 'Кнопка', $url, $options);
    }

    /**
     * @return string
     */
    public static function getImagesRootPath() : string
    {
        return \Yii::getAlias('@backendImages').DIRECTORY_SEPARATOR.Catalog::IMAGES_DIR_POST;
    }

    /**
     * @return string
     */
    public static function getImagesLogoPath() : string
    {
        return \Yii::getAlias('@backendImages');
    }

    /**
     * @param string $flag
     * @param array  $groups
     * @param bool   $isRandom
     * @param int    $limit
     *
     * @return array
     * @throws \ImagickException
     */
    public static function getSpecialOfferData(string $flag, array $groups, bool $isRandom, int $limit = 0) : array
    {
        $query = SpecialOffers::find();
        $query->select([
            SpecialOffers::tableName().'.title',
            SpecialOffers::tableName().'.article_number',
            SpecialOffers::tableName().'.product_name',
            SpecialOffers::tableName().'.product_code',
            SpecialOffers::tableName().'.offer_type',
            SpecialOffers::tableName().'.offer_name',
            new Expression("(SELECT MIN(price) FROM public.".PriceList::tableName()."	WHERE ".PriceList::tableName().".product_code=".SpecialOffers::tableName().".product_code) as price"),
        ]);
        $query->where(['IS NOT', 'product_code', null,]);

        if (!empty($groups) && is_array($groups)) {
            $query->andWhere(['and', ['offer_type' => SpecialOffers::OFFER_TYPE_GROUPING,], ['in', 'offer_name', $groups,],]);
        }
        if ($flag) {
            $query->andWhere(['offer_type' => SpecialOffers::OFFER_TYPE_FLAG, 'offer_name' => $flag,]);
        }

        $query->orderBy(['title' => SORT_ASC,]);
        $query->asArray();
        if ($limit) {
            $query->limit($limit);
        }

        $models = $query->all();

        $isFlag = false;
        foreach ($models as $i => $model) {
            $models[$i]['image'] = CatalogHelper::getSpecialOfferImageUrl($model['article_number']);
            $models[$i]['color'] = '';
            $models[$i]['price'] = (float) $model['price'];

            if ($model['offer_type'] === SpecialOffers::OFFER_TYPE_FLAG) {
                $isFlag = true;
            }
        }

        if ($isFlag) {
            $statuses = ReclamaStatus::find()->select(['type', 'name', 'color',])->where(['type' => ReclamaStatus::TYPE_FLAG,])->asArray()->all();

            foreach ($models as $i => $model) {
                if ($model['offer_type'] === SpecialOffers::OFFER_TYPE_FLAG) {
                    foreach ($statuses as $status) {
                        if ($status['name'] === $model['offer_name'] && !empty($status['color'])) {
                            $models[$i]['color'] = $status['color'];
                        }
                    }
                }
            }
        }

        if ($isRandom) {
            shuffle($models);
        }

        return $models;
    }

    /**
     * @param array $fields
     * @param array $json
     *
     * @return array
     */
    public static function parseSpecialOfferBlock(array $fields, array $json)
    {
        $contentID = 0;
        $header = $headerColor = $flag = '';
        $isRandom = $isShowAllButton = $isSlider = false;
        $groups = [];

        foreach ($fields as $field) {
            $value = $json[$field['id']] ?? '';
            if (is_string($value)) {
                $value = trim($value);
            }

            switch ($field['type']) {
                case BlockField::TYPE_TEXT:
                    $header = (string)$value;
                    break;
                case BlockField::TYPE_COLOR:
                    $headerColor = (string)$value;
                    break;
                case BlockField::TYPE_SPECIAL_GROUP:
                    $groups = is_array($value) ? $value : [];
                    break;
                case BlockField::TYPE_SPECIAL_FLAG:
                    $flag = (string)$value;
                    break;
                case BlockField::TYPE_CONTENT_ID:
                    $contentID = (int)$value;
                    break;
                case BlockField::TYPE_BOOL:
                    if ($field['name'] === 'Random') {
                        $isRandom = (bool)$value;
                    } else {
                        $pos = mb_stripos($field['name'], 'Слайдер', 0, 'utf-8');
                        if ($pos !== false) {
                            $isSlider = (bool)$value;
                        }
                    }
                    break;
            }
        }

        return [
            'header' => $header,
            'headerColor' => $headerColor,
            'flag' => $flag,
            'isRandom' => $isRandom,
            'isShowAllButton' => $isSlider && $contentID,
            'isSlider' => $isSlider,
            'groups' => $groups,
            'contentID' => $contentID,
        ];
    }

    /**
     * @param int $contentID
     *
     * @return string
     */
    public static function getContentUrl(int $contentID) : string
    {
        $model = Content::findOne(['id' => $contentID,]);

        return $model ? $model->getContentUrl() : '/';
    }

    /**
     * @param int $contentID
     * @param string $contentAlias
     *
     * @return string
     */
    public static function getNewsUrl(int $contentID, string $contentAlias) : string
    {
        $model = Content::findOne(['id' => $contentID,]);
        $urlAlias = \Yii::$app->request->get('alias');
        $url = substr($model->getContentUrl(), 1);
        if ($urlAlias == $contentID || $urlAlias == $contentAlias) {
            return false;
        }

        return $url;
    }

    /**
     * @param int $contentID
     *
     * @return array
     */
    public static function getDeparmentLandingPage(int $contentID) : array
    {
        $model = Content::find()->where(['id' => $contentID, 'type' => Content::TYPE_PAGE, 'deleted_at' => null,])->select(['id', 'name',])->asArray()->one();

        return $model ?: [];
    }

    /**
     * @return string
     */
    public static function generatePanelAskButton() : string
    {
        return Html::a('', '#', ['class' => 'single-vendor-description__panel--ask',]);
    }

    /**
     * @return string
     */
    public static function generatePanelShareButton() : string
    {
        return Html::a('', '#', ['class' => 'single-vendor-description__panel--share',]);
    }

    /**
     * @return string
     */
    public static function generatePanelFavoriteButton() : string
    {
        return Html::a('', '#', ['class' => 'single-vendor-description__panel--favorite',]);
    }

    /**
     * @param string $number
     *
     * @return array
     */
    public static function getCrossArticles(string $number) : array
    {
        $articles = [];
        $query = Cross::find()->select([
            Cross::tableName().'.id',
        ])->where([Cross::tableName().'.article' => $number,])
        ->asArray();

        $subQuery = (new Query())
            ->select([
                new Expression("string_agg(cr2.article, ';')"),
            ])
            ->from(Cross::tableName().' AS cr2')
            ->where('cr2.superarticle="'.Cross::tableName().'".superarticle')
            ->limit(2);
        $query->addSelect(['articles' => $subQuery,]);

        foreach ($query->all() as $row) {
            $items = explode(';', $row['articles']);

            foreach ($items as $item) {
                $articles[$item] = $item;
            }
        }

        return !empty($articles) ? array_values($articles) : [$number,];
    }

    /**
     * @param array $numbers
     * @param int   $limit
     *
     * @return array
     */
    public static function getCatalogRubricsByArticles(array $numbers, int  $limit) : array
    {
        $data = [];
        $query = Catalog::find()->select(['code',])->where(['article' => $numbers,])->asArray();

        $codes = [];
        foreach ($query->all() as $item) {
            $codes[$item['code']] = $item['code'];
        }

        if (!empty($codes)) {
            $recomendCats = CatRecomend::find()->select(['recomend_cat',])->where(['cat' => array_values($codes),])->asArray()->column();

            if (!empty($recomendCats)) {
                $query = Catalog::find()->select(['id', 'code', 'name',])->where(['code' => $recomendCats,])->asArray();

                foreach ($query->all() as $item) {
                    $item['count'] = 0;
                    $data[$item['code']] = $item;
                }
            }
        }

        if (count($data) > $limit) {
            $data = array_slice($data, 0, $limit);
        }

        return $data;
    }

    /**
     * @param array $numbers
     * @param int   $limit
     *
     * @return array
     */
    public static function getRelatedContentByArticles(array $numbers, int  $limit) : array
    {
        $data = [];
        $query = Content::find();
        $query->with('contentBlocks');
        $query->where(['type' => [Content::TYPE_NEWS, Content::TYPE_ARTICLE,], 'deleted_at' => null,]);
        $query->andWhere(['IS NOT', 'article_numbers', null]);
        $query->orderBy(['updated_at' => SORT_DESC,]);

        foreach ($query->all() as $row) {
            $articleNumbers = explode(Content::ARTICLE_NUMBERS_SEPARATOR, $row->article_numbers);

            foreach ($numbers as $number) {
                if (in_array($number, $articleNumbers)) {
                    $data[$row->id] = $row;
                }
            }
        }

        if (count($data) > $limit) {
            $data = array_slice($data, 0, $limit);
        }

        return $data;
    }

    /**
     * @param ContentTree $model
     *
     * @return array
     */
    public static function getContentTreeData($model = null) : array
    {
        $rootItem = ['name' => 'Контент', 'id' => 0, 'open' => true, 'url' => '', Catalog::TREE_ITEM_CHILDREN => [],];
        $rootPagesItem = ['name' => ContentTree::getTypeTitle(ContentTree::TYPE_PAGES), 'id' => ContentTree::TYPE_PAGES_ID, 'open' => true, 'url' => '', 'type' => ContentTree::TREE_TYPE_FOLDER, 'contentType' => Content::TYPE_PAGE, Catalog::TREE_ITEM_CHILDREN => [], 'font' => new JsExpression(ContentTree::FOLDER_FONT),];
        $rootArticlesItem = ['name' => ContentTree::getTypeTitle(ContentTree::TYPE_ARTICLES), 'id' => ContentTree::TYPE_ARTICLES_ID, 'open' => true, 'url' => '', 'type' => ContentTree::TREE_TYPE_FOLDER, 'contentType' => Content::TYPE_ARTICLE, Catalog::TREE_ITEM_CHILDREN => [], 'font' => new JsExpression(ContentTree::FOLDER_FONT),];
        $rootNewsItem = ['name' => ContentTree::getTypeTitle(ContentTree::TYPE_NEWS), 'id' => ContentTree::TYPE_NEWS_ID, 'open' => true, 'url' => '', 'type' => ContentTree::TREE_TYPE_FOLDER, 'contentType' => Content::TYPE_NEWS, Catalog::TREE_ITEM_CHILDREN => [], 'font' => new JsExpression(ContentTree::FOLDER_FONT),];

        $topSettings = ContentTree::find()->where(['<', 'parent_id', 0])->orderBy(['sort' => SORT_ASC,])->indexBy('id')->asArray()->all();
        $otherSettings = ContentTree::find()->where(['>', 'parent_id', 0])->orderBy(['parent_id' => SORT_ASC, 'sort' => SORT_ASC,])->indexBy('id')->asArray()->all();

        $tree2content = $contentIDs = [];
        $rows = ContentTreeContent::find()->select(['id', 'content_tree_id', 'content_id',])->orderBy(['content_tree_id' => SORT_ASC, 'sort' => SORT_ASC,])->indexBy('id')->asArray()->all();
        foreach ($rows as $id => $row) {
            $tree2content[$row['content_tree_id']][] = ['content_id' => $row['content_id'],];
            $contentIDs[$row['content_id']] = $row['content_id'];
        }

        $contentRows = Content::find()->select(['id', 'name', 'type',])->where(['deleted_at' => null,])->indexBy('id')->asArray()->all();

        foreach ($tree2content as $contentTreeId => $rows) {
            foreach ($rows as $index => $row) {
                if (isset($contentRows[$row['content_id']])) {
                    $tree2content[$contentTreeId][$index]['name'] = $contentRows[$row['content_id']]['name'];
                    $tree2content[$contentTreeId][$index]['type'] = $contentRows[$row['content_id']]['type'];

                    unset($contentRows[$row['content_id']]);
                }
            }
        }

        foreach ($topSettings as $settingID => $setting) {
            switch ($setting['parent_id']) {
                case ContentTree::TYPE_PAGES_ID:
                    $rootPagesItem[Catalog::TREE_ITEM_CHILDREN][] = [
                        'id' => $settingID,
                        'parent_id' => ContentTree::TYPE_PAGES_ID,
                        'name' => $setting['name'],
                        'url' => '/'.MenuHelper::FIRST_MENU_CONTENT.'/'.MenuHelper::SECOND_MENU_CONTENT_TREE.'/folder?id='.$settingID,
                        'open' => $model && $model->parent_id === $settingID ? true : false,
                        'type' => ContentTree::TREE_TYPE_FOLDER,
                        'contentType' => Content::TYPE_PAGE,
                        'font' => new JsExpression(ContentTree::FOLDER_FONT),
                    ];
                    break;
                case ContentTree::TYPE_NEWS_ID:
                    $rootNewsItem[Catalog::TREE_ITEM_CHILDREN][] = [
                        'id' => $settingID,
                        'parent_id' => ContentTree::TYPE_NEWS_ID,
                        'name' => $setting['name'],
                        'url' => '/'.MenuHelper::FIRST_MENU_CONTENT.'/'.MenuHelper::SECOND_MENU_CONTENT_TREE.'/folder?id='.$settingID,
                        'open' => $model && $model->parent_id === $settingID ? true : false,
                        'type' => ContentTree::TREE_TYPE_FOLDER,
                        'contentType' => Content::TYPE_NEWS,
                        'font' => new JsExpression(ContentTree::FOLDER_FONT),
                    ];
                    break;
                case ContentTree::TYPE_ARTICLES_ID:
                    $rootArticlesItem[Catalog::TREE_ITEM_CHILDREN][] = [
                        'id' => $settingID,
                        'parent_id' => ContentTree::TYPE_ARTICLES_ID,
                        'name' => $setting['name'],
                        'url' => '/'.MenuHelper::FIRST_MENU_CONTENT.'/'.MenuHelper::SECOND_MENU_CONTENT_TREE.'/folder?id='.$settingID,
                        'open' => $model && $model->parent_id === $settingID ? true : false,
                        'type' => ContentTree::TREE_TYPE_FOLDER,
                        'contentType' => Content::TYPE_ARTICLE,
                        'font' => new JsExpression(ContentTree::FOLDER_FONT),
                    ];
                    break;
            }
        }

//        echo '<pre>';

        foreach ($rootPagesItem[Catalog::TREE_ITEM_CHILDREN] as $index => $setting) {
            $rootPagesItem[Catalog::TREE_ITEM_CHILDREN][$index] = self::_processContentTree($setting, $otherSettings, $tree2content, $model);
        }

        foreach ($rootArticlesItem[Catalog::TREE_ITEM_CHILDREN] as $index => $setting) {
            $rootArticlesItem[Catalog::TREE_ITEM_CHILDREN][$index] = self::_processContentTree($setting, $otherSettings, $tree2content, $model);
        }
        foreach ($rootNewsItem[Catalog::TREE_ITEM_CHILDREN] as $index => $setting) {
            $rootNewsItem[Catalog::TREE_ITEM_CHILDREN][$index] = self::_processContentTree($setting, $otherSettings, $tree2content, $model);
        }

        foreach ($contentRows as $contentID => $contentRow) {
            switch ($contentRow['type']) {
                case Content::TYPE_PAGE:
                    $rootPagesItem[Catalog::TREE_ITEM_CHILDREN][] = [
                        'id' => $contentID,
                        'parent_id' => ContentTree::TYPE_PAGES_ID,
                        'name' => self::_getContentTreeContentName($contentRow),
                        'url' => '/'.MenuHelper::FIRST_MENU_CONTENT.'/'.MenuHelper::SECOND_MENU_CONTENT_TREE.'/content?id='.$contentID,
                        'open' => false,
                        'type' => ContentTree::TREE_TYPE_CONTENT,
                        'contentType' => $contentRow['type'],
                        'icon' => self::_getContentTreeContentIcon(['type' => Content::TYPE_PAGE,]),
                    ];
                    break;
                case Content::TYPE_ARTICLE:
                    $rootArticlesItem[Catalog::TREE_ITEM_CHILDREN][] = [
                        'id' => $contentID,
                        'parent_id' => ContentTree::TYPE_ARTICLES_ID,
                        'name' => self::_getContentTreeContentName($contentRow),
                        'url' => '/'.MenuHelper::FIRST_MENU_CONTENT.'/'.MenuHelper::SECOND_MENU_CONTENT_TREE.'/content?id='.$contentID,
                        'open' => false,
                        'type' => ContentTree::TREE_TYPE_CONTENT,
                        'contentType' => $contentRow['type'],
                        'icon' => self::_getContentTreeContentIcon(['type' => Content::TYPE_ARTICLE,]),
                    ];
                    break;
                case Content::TYPE_NEWS:
                    $rootNewsItem[Catalog::TREE_ITEM_CHILDREN][] = [
                        'id' => $contentID,
                        'parent_id' => ContentTree::TYPE_NEWS_ID,
                        'name' => self::_getContentTreeContentName($contentRow),
                        'url' => '/'.MenuHelper::FIRST_MENU_CONTENT.'/'.MenuHelper::SECOND_MENU_CONTENT_TREE.'/content?id='.$contentID,
                        'open' => false,
                        'type' => ContentTree::TREE_TYPE_CONTENT,
                        'contentType' => $contentRow['type'],
                        'icon' => self::_getContentTreeContentIcon(['type' => Content::TYPE_NEWS,]),
                    ];
                    break;
            }
        }

        $rootItem[Catalog::TREE_ITEM_CHILDREN][] = $rootPagesItem;
        $rootItem[Catalog::TREE_ITEM_CHILDREN][] = $rootArticlesItem;
        $rootItem[Catalog::TREE_ITEM_CHILDREN][] = $rootNewsItem;

        return [$rootItem,];
    }

    /**
     * @param array       $setting
     * @param array       $otherSettings
     * @param array       $tree2content
     * @param ContentTree $model
     *
     * @return array
     */
    public static function _processContentTree(array &$setting, array &$otherSettings, array $tree2content, $model = null) : array
    {
        foreach ($otherSettings as $otherID => $other) {
            if ($setting['id'] === $other['parent_id']) {
                unset($otherSettings[$otherID]);

                $contentType = '';
                switch ($other['type']) {
                    case ContentTree::TYPE_PAGES:
                        $contentType = Content::TYPE_PAGE;
                        break;
                    case ContentTree::TYPE_NEWS:
                        $contentType = Content::TYPE_NEWS;
                        break;
                    case ContentTree::TYPE_ARTICLES:
                        $contentType = Content::TYPE_ARTICLE;
                        break;
                }

                $setting[Catalog::TREE_ITEM_CHILDREN][] = [
                    'id' => $otherID,
                    'parent_id' => $other['parent_id'],
                    'name' => $other['name'],
                    'url' => '/'.MenuHelper::FIRST_MENU_CONTENT.'/'.MenuHelper::SECOND_MENU_CONTENT_TREE.'/folder?id='.$otherID,
                    'open' => $model && $model->parent_id === $otherID ? true : false,
                    'type' => ContentTree::TREE_TYPE_FOLDER,
                    'contentType' => $contentType,
                    'font' => new JsExpression(ContentTree::FOLDER_FONT),
                ];
            }
            unset($other);
        }

        if (!empty($setting[Catalog::TREE_ITEM_CHILDREN])) {
            foreach ($setting[Catalog::TREE_ITEM_CHILDREN] as $index => $other) {
                if ($other['type'] === ContentTree::TREE_TYPE_FOLDER) {
                    $setting[Catalog::TREE_ITEM_CHILDREN][$index] = self::_processContentTree($other, $otherSettings, $tree2content, $model);
                }
            }
        }

        if (isset($tree2content[$setting['id']])) {
            foreach ($tree2content[$setting['id']] as $contentData) {
                $contentData['id'] = $contentData['content_id'];

                $setting[Catalog::TREE_ITEM_CHILDREN][] = [
                    'id' => $contentData['content_id'],
                    'parent_id' => $setting['id'],
                    'name' => self::_getContentTreeContentName($contentData),
                    'url' => '/'.MenuHelper::FIRST_MENU_CONTENT.'/'.MenuHelper::SECOND_MENU_CONTENT_TREE.'/content?id='.$contentData['content_id'],
                    'open' => false,
                    'type' => ContentTree::TREE_TYPE_CONTENT,
                    'contentType' => $contentData['type'],
                    'icon' => self::_getContentTreeContentIcon($contentData),
                ];
            }
        }

        return $setting;
    }

    /**
     * @param array $content
     *
     * @return string
     */
    public static function _getContentTreeContentName(array $content) : string
    {
        return /*'['.substr(strtoupper($content['type']), 0, 1).'] / '.$content['id'].' - '.*/$content['name'];
    }

    /**
     * @param array $content
     *
     * @return string
     */
    public static function _getContentTreeContentIcon(array $content) : string
    {
        return '/img/icon_'.$content['type'].'.png';
    }
}