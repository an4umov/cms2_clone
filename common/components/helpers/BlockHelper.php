<?php
namespace common\components\helpers;

use backend\components\widgets\ImageGalleryWidget;
use common\models\Block;
use common\models\BlockField;
use common\models\BlockFieldList;
use common\models\BlockFieldValuesList;
use common\models\BlockReady;
use common\models\Catalog;
use common\models\Content;
use common\models\ContentFilter;
use common\models\ContentFilterPage;
use common\models\CustomTag;
use common\models\Department;
use common\models\DepartmentMenu;
use common\models\DepartmentMenuTag;
use yii\web\JsExpression;
use common\models\Form;
use common\models\FullPrice;
use common\models\GreenMenu;
use common\models\SpecialOffers;
use kartik\checkbox\CheckboxX;
use kartik\color\ColorInput;
use kartik\daterange\DateRangePicker;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use zxbodya\yii2\tinymce\TinyMce;

class BlockHelper
{
    /**
     * @param string $type
     *
     * @return string
     */
    public static function getBlockTypeTitle(string $type) : string
    {
        return (new Block())->getTypeTitle($type);
    }

    /**
     * @param int   $contentBlockID
     * @param array $block
     * @param       $field
     * @param array $data
     * @param int   $listSort
     * @param null  $content
     *
     * @throws \Exception
     */
    public static function generateBlockField(int $contentBlockID, array $block, $field, array $data, int $listSort = 0, $content = null)
    {
        /** @var BlockField $field */
        $html = '';
        $blockID = $block['id'];
        $fieldData = !empty($data[$field->id]) ? $data[$field->id] : null;
        $modelName = $field instanceof BlockField || $field instanceof BlockFieldList ? 'Content' : 'BlockReady';
        $name = $modelName.'[content_blocks_list]['.$contentBlockID.'][blocks_list]['.$blockID.'][fields]';
        if ($field instanceof BlockFieldList) {
            $name .= '['.$field->field_id.']['.BlockField::TYPE_LIST.']['.$listSort.']['.$field->id.']';
            $idPart = $contentBlockID.'-'.$blockID.'-'.$field->field_id.'-'.$field->id.'-'.$listSort;
        } else {
            $name .= '['.$field->id.']';
            $idPart = $contentBlockID.'-'.$blockID.'-'.$field->id;
        }
        $value = $fieldData ?: '';
        $options = ['id' => 'block-field-'.$idPart, 'class' => 'form-control', 'aria-required' => 'true', 'checked' => true,];
        switch ($field->type) {
            case BlockField::TYPE_TEXT:
                $html = Html::textInput($name, $value, $options + ['placeholder' => $field->getTypeTitle($field->type),]);
                break;
            case BlockField::TYPE_TEXTAREA:
                $html = Html::textarea($name, $value, $options + ['rows' => 5, 'placeholder' => $field->getTypeTitle($field->type),]);
                break;
            case BlockField::TYPE_TEXTAREA_EXT:
                $settings = [
                    'height' => 150,
                    'plugins' => [
                        "advlist lists hr pagebreak preview",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime nonbreaking save table contextmenu directionality",
                        "template paste textcolor code link wordcount",
                    ],
                    'content_css' => ['/css/tinymce.css', 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap'],
                    "toolbar" => "undo redo | styleselect | br p removeformat | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent link | forecolor backcolor | preview code | mybutton",
                    'selector' => 'textarea#editable',
                    'menubar' => false,

                    'style_formats' => [
                        [ 'title' => 'H1 uppercase', 'block' => 'h1', 'styles' => [ 'text-transform' => 'uppercase', 'font-family' => 'Open Sans, sans-serif', 'font-size' => '30px' ] ],
                        [ 'title' => 'H2 uppercase', 'block' => 'h2', 'styles' => [ 'text-transform' => 'uppercase', 'font-family' => 'Open Sans, sans-serif', 'font-size' => '20px' ] ],
                        [ 'title' => 'H3 uppercase', 'block' => 'h3', 'styles' => [ 'text-transform' => 'uppercase', 'font-family' => 'Open Sans, sans-serif', 'font-size' => '1.17em' ] ],
                        [ 'title' => 'H1 none', 'block' => 'h1', 'styles' => [ 'font-family' => 'Open Sans, sans-serif', 'font-size' => '30px' ], 'text-transform' => 'none' ],
                        [ 'title' => 'H2 none', 'block' => 'h2', 'styles' => [ 'font-family' => 'Open Sans, sans-serif', 'font-size' => '20px' ], 'text-transform' => 'none' ],
                        [ 'title' => 'H3 none', 'block' => 'h3', 'styles' => [ 'font-family' => 'Open Sans, sans-serif', 'font-size' => '18px' ], 'text-transform' => 'none' ],
                        [ 'title' => 'Увеличенный текст', 'block' => 'span', 'styles' => [ 'font-family' => 'Open Sans, sans-serif', 'font-size' => '19px', 'text-transform' => 'none' ] ],
                        [ 'title' => 'Основной текст', 'block' => 'span', 'styles' => [ 'font-family' => 'Open Sans, sans-serif', 'font-size' => '16px', 'text-transform' => 'none' ] ],
                        [ 'title' => 'Уменьшенный текст', 'block' => 'span', 'styles' => [ 'font-family' => 'Open Sans, sans-serif', 'font-size' => '14px', 'text-transform' => 'none' ] ],
                    ],
                    'setup' => new JsExpression("function (editor) {
                        editor.addButton('mybutton', {
                          text: 'Кнопка \"Купить\"',
                          icon: false,
                          onclick: function () {
                            editor.insertContent('<a class=\"news-post__short-btn--buy\" href=\"#\" target=\"_blank\">Купить в интернет-магазине</a>');
                          }
                        });
                        editor.addButton('br', {
                            text: '<br>',
                            icon: false,
                            onclick: function () {
                              editor.insertContent('<br>');
                            }
                        });
                        editor.addButton('p', {
                            text: '<p>',
                            icon: false,
                            onclick: function () {
                                var text = editor.selection.getContent({
                                    'format': 'html'
                                });
                                if (text && text.length > 0) {
                                    editor.execCommand('mceInsertContent', false,
                                        '<p>' + text + '</p>');
                                }
                            }
                        });
                    }"),
                ];

                /* @var $content Content */
                if (!empty($content) && $content->type === Content::TYPE_NEWS && $block['global_type'] === Block::GLOBAL_TYPE_TEXT_NEWS_ANONS) {
                    $settings['plugins'] = ["paste link preview wordcount",];
                    $settings['toolbar'] = 'undo redo | bold p link | removeformat | preview code';
                }

                $html = TinyMce::widget([
                    'settings' => $settings,
                    'name' => $name,
                    'value' => $value,
                    'id' => 'tinymce-widget-'.$idPart,
                    'class' => 'form-control',
                    'language' => 'ru',

                ]);//.'<pre>'.print_r($block, true).'</pre>';
                break;
            case BlockField::TYPE_IMAGE:
                //$html = Html::textInput($name, $value, $options + ['placeholder' => $field->getTypeTitle($field->type), 'id' => 'file-input-widget-'.$idPart,]);
                $html = ImageGalleryWidget::widget([
                    'id' => 'image-gallery-widget-'.$idPart,
                    'initdir' => ContentHelper::getImagesRootPath(),
                    'dir' => ContentHelper::getImagesRootPath(),
                    'filename' => $value ? substr($value, strrpos($value, DIRECTORY_SEPARATOR) + 1) : '',
                    'filepath' => $value,
                    'name' => $name,
                ]);
                break;
            case BlockField::TYPE_DIGIT:
                $html = NumberControl::widget([
                    'id' => 'number-control-widget-'.$idPart,
                    'name' => $name,
                    'value' => $value,
                    'displayOptions' => [
                        'class' => 'form-control kv-monospace',
                        'placeholder' => 'Введите число...',
                    ],
                    'saveInputContainer' => ['style' => 'display:none',],
                    'maskedInputOptions' => [
                        'groupSeparator' => '',
                        'radixPoint' => ',',
                    ],
                ]);
                break;
            case BlockField::TYPE_BOOL:
                $html = CheckboxX::widget([
                    'id' => 'checkbox-x-widget-'.$idPart,
                    'name' => $name,
                    'value' => !empty($fieldData),
                    'options' => $options,
                    'pluginOptions' => ['threeState' => false,],
                ]);
                break;
            case BlockField::TYPE_DATE:
                $html = '<div class="input-group drp-container">'.DateRangePicker::widget([
                        'id' => 'date-range-widget-'.$idPart,
                        'name' => $name,
                        'value' => $value,
                        'useWithAddon' => true,
                        'pluginOptions' => [
                            'singleDatePicker' => true,
                            'showDropdowns' => true,
                        ],
                    ]) . '<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span></div>';
                break;
            case BlockField::TYPE_COLOR:
                $html = ColorInput::widget([
                    'id' => 'color-input-widget-'.$idPart,
                    'name' => $name,
                    'value' => $value,
                    'options' => ['placeholder' => 'Выберите цвет...',],
                ]);
                break;
            case BlockField::TYPE_GRADIENT_COLOR:
                $leftColor = $centerColor = $rightColor = '';
                if (is_array($value)) {
                    if (!empty($value[BlockField::GRADIENT_COLOR_LEFT])) {
                        $leftColor = $value[BlockField::GRADIENT_COLOR_LEFT];
                    }
                    if (!empty($value[BlockField::GRADIENT_COLOR_CENTER])) {
                        $centerColor = $value[BlockField::GRADIENT_COLOR_CENTER];
                    }
                    if (!empty($value[BlockField::GRADIENT_COLOR_RIGHT])) {
                        $rightColor = $value[BlockField::GRADIENT_COLOR_RIGHT];
                    }
                }
                $html = '<div class="row">
                    <div class="col-lg-1">Левый край</div>
                    <div class="col-lg-3">'.ColorInput::widget([
                        'id' => 'gradient_color_'.BlockField::GRADIENT_COLOR_LEFT.'-input-widget-'.$idPart,
                        'name' => $name.'['.BlockField::TYPE_GRADIENT_COLOR.']'.'['.BlockField::GRADIENT_COLOR_LEFT.']',
                        'value' => $leftColor,
                        'options' => ['placeholder' => 'Выберите цвет...',],
                    ])
                    .'</div>
                    <div class="col-lg-1">Центр</div>
                    <div class="col-lg-3">'.ColorInput::widget([
                        'id' => 'gradient_color_'.BlockField::GRADIENT_COLOR_CENTER.'-input-widget-'.$idPart,
                        'name' => $name.'['.BlockField::TYPE_GRADIENT_COLOR.']'.'['.BlockField::GRADIENT_COLOR_CENTER.']',
                        'value' => $centerColor,
                        'options' => ['placeholder' => 'Выберите цвет...',],
                    ])
                    .'</div>
                    <div class="col-lg-1">Правый край</div>
                    <div class="col-lg-3">'.ColorInput::widget([
                        'id' => 'gradient_color_'.BlockField::GRADIENT_COLOR_RIGHT.'-input-widget-'.$idPart,
                        'name' => $name.'['.BlockField::TYPE_GRADIENT_COLOR.']'.'['.BlockField::GRADIENT_COLOR_RIGHT.']',
                        'value' => $rightColor,
                        'options' => ['placeholder' => 'Выберите цвет...',],
                    ])
                    .'</div>
                </div>';
                break;
            case BlockField::TYPE_ARTICLE_ID:
                $html = Html::textInput($name, $value, $options + ['placeholder' => 'Введите ID статьи',]);
                break;
            case BlockField::TYPE_PAGE_ID:
                $html = Html::textInput($name, $value, $options + ['placeholder' => 'Введите ID страницы',]);
                break;
            case BlockField::TYPE_LIST:
                if (!empty($field->list)) {
                    $html = '<div class="panel panel-warning">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-lg-11"><h5 class="panel-title" style="font-size: 14px;">'.$field->name.' <span class="badge">Список полей Повторитель</span></h5></div>
                                <div class="col-lg-1">'.
                                    Html::a('<i class="fas fa-plus-circle"></i>', ['#',], ['title' => 'Добавить блок', 'class' => 'pull-right', 'data' => ['content_block_id' => $contentBlockID, 'block_id' => $blockID, 'field_id' => $field->id,], 'id' => 'block-field-list-add-btn',]).'
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                    ';

                    if (is_array($value)) {
                        $sortArray = [];
                        foreach ($value as $sort => $itemValue) {
                            if (isset($itemValue[Content::SORT_KEY])) {
                                $key = $itemValue[Content::SORT_KEY];
                                if (isset($sortArray[$key])) {
                                    $key++;
                                }

                                $sortArray[$key] = $itemValue;
                            } else {
                                $sortArray[$sort] = $itemValue;
                            }
                        }

                        ksort($sortArray); //сортировка по ключам содержимого JSON
                        foreach ($sortArray as $sort => $itemValue) {
//                                $modelName = $field instanceof BlockField || $field instanceof BlockFieldList ? 'Content' : 'BlockReady';
//                                $name = $modelName.'[content_blocks_list]['.$contentBlockID.'][blocks_list]['.$blockID.'][fields]';
//                                $name .= '['.$field->id.']['.BlockField::TYPE_LIST.']['.$sort.']['.Content::SORT_KEY.']';
//                                $html .= '<div class="form-group block-field-sort"><label class="control-label" for="block-field-'.$listSort.'">Сортировка набора поля</label><input type="number" id="block-field-sort-'.$listSort.'" class="form-control" name="'.$name.'" value="'.$sort.'" aria-required="true" placeholder="Сортировка"></div>';

                            $html .= self::getBlockFieldList($contentBlockID, $blockID, $field->list, $itemValue, $sort);
                        }
                    }

                    $html .= '</div></div>';
                } else {
                    $html = '<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-circle" title=""></span> Отсутствует список полей в таблице '.BlockFieldList::tableName().' для записи '.$field->id.'</div>';
                }
                break;
            case BlockField::TYPE_RADIO:
                $radio_type = '';
                $radioTabsHtml = [];
                $radioTabsList = [];
                $radioTabsHtml['nav'] = '';
                $radioTabsHtml['content'] = '';

                if (isset($data['radio_type_list'])) {
                    $radio_type = $data['radio_type_list'][0]['radio_type'];
                }
                if (in_array($field->type, [BlockField::TYPE_RADIO])) {
                    if (BlockHelper::currentTabCheck($radio_type, $field->id) == 1) {
                        $checked = 'checked="true"';
                        $is_active = 'is-active';
                    } else {
                        $checked = $is_active = '';
                    }
                    $radioTabsHtml['nav'] = '
                        <label class="radio-tab radio-tab__'.$block['content_block_id'].'_'.$field->id.' '.$is_active.'" data-tab-name="radio-tab_'.$block['content_block_id'].'_'.$field->id.'">
                            <input type="radio" name="Content[content_blocks_list]['.$block['content_block_id'].'][blocks_list]['.$block['id'].'][fields][radio_type_list][list][0][radio_type]" value="'.$field->id.'" '.$checked.' />
                            <span>'.$field->name.'</span>
                        </label>
                    ';
                }
                
                if (in_array($field->type, [BlockField::TYPE_RADIO])) {
                    if (BlockHelper::currentTabCheck($radio_type, $field->id) == 1) {
                        $is_active = 'is-active';
                    } else {
                        $is_active = '';
                    }
                    $radioTabsHtml['content'] = '
                        <div class="radio-tab-content radio-tab_'.$block['content_block_id'].'_'.$field->id.' '.$is_active.'">
                            <div class="radio-tab-content_left">
                                <div class="radio-tabs-descr"><i>'.$field->description.'</i></div>
                                <div class="radio-tabs-info">'.$field->info.'</div>
                            </div>
                            <div class="radio-tab-content_right">
                    ';
                    $key = 0;
                    foreach ($field->list as $tabsList) {
                        if ($tabsList->type == 'digit') {
                            $radioTabsList = [$field->id => $tabsList];
                            $inputField = $radioTabsList[$tabsList->field_id];
                            $inputFieldValue = $inputFieldP = '';

                            if (isset($data[$field->id][$key][$inputField->id])) {
                                $inputFieldValue = $data[$field->id][$key][$inputField->id];
                            }
                            if (empty($inputFieldValue)) {
                                if ($key == 0) {
                                    $inputFieldP = 500;
                                } elseif ($key == 1) {
                                    $inputFieldP = 350;
                                } elseif ($key == 2) {
                                    $inputFieldP = 200;
                                }
                            }

                            $radioTabsHtml['content'] .= '
                            <label class="radio-tab-input">
                                <span>'.$inputField->name.'</span>
                                <input type="number" class="form-control" name="Content[content_blocks_list]['.$block['content_block_id'].'][blocks_list]['.$block['id'].'][fields]['.$field->id.'][list]['.$key.']['.$inputField->id.']" placeholder="'.$inputFieldP.'" value="'.$inputFieldValue.'" />
                            </label>
                            ';
                        }
                        $key++;
                    }
                    $radioTabsHtml['content'] .= '
                            </div>
                        </div>
                    ';
                }
                break;
            case BlockField::TYPE_VALUES_LIST:
                $html = Html::dropDownList($name, $value, $field->getBlockFieldValuesOptions(),$options + ['prompt' => 'Выберите значение...',]);
                break;
            case BlockField::TYPE_TAGS:
                $html = Select2::widget([
                    'id' => 'tags-select-widget-'.$idPart,
                    'name' => $name,
                    'value' => $value, // initial value
                    'data' => ArrayHelper::map(self::getContentTagList(), 'id', 'name'),
                    'maintainOrder' => true,
                    'toggleAllSettings' => [
                        'selectLabel' => '<i class="fas fa-ok-circle"></i> Выбрать все',
                        'unselectLabel' => '<i class="fas fa-remove-circle"></i> Отменить выбор',
                        'selectOptions' => ['class' => 'text-success'],
                        'unselectOptions' => ['class' => 'text-danger'],
                    ],
                    'options' => ['placeholder' => 'Выберите теги...', 'multiple' => true, 'style' => 'width:100%;',],
                    'pluginOptions' => ['tags' => true, 'allowClear' => true,],
                    'hideSearch' => true,
                ]);
                break;
            case BlockField::TYPE_FORMS:
                $html = Select2::widget([
                    'id' => 'form-select-widget-'.$idPart,
                    'name' => $name,
                    'value' => $value,
                    'data' => ArrayHelper::map(self::getContentFormList(), 'id', 'name'),
                    'options' => [
                        'placeholder' => 'Выберите форму...',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'hideSearch' => true,
                ]);
                break;
            case BlockField::TYPE_DEPARTMENTS:
                $html = Select2::widget([
                    'id' => 'department-select-widget-'.$idPart,
                    'name' => $name,
                    'value' => $value,
                    'data' => ArrayHelper::map(self::getContentDepartmentList(), 'id', 'name'),
                    'options' => [
                        'placeholder' => 'Выберите департамент...',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                    ],
                    'hideSearch' => true,
                ]);
                break;
            case BlockField::TYPE_MANUFACTURERS:
                $html = Select2::widget([
                    'id' => 'manufacturers-select-widget-'.$idPart,
                    'name' => $name,
                    'value' => $value,
                    'data' => self::getContentManufacturersList(),
                    'options' => [
                        'placeholder' => 'Выберите производителей...',
                        'multiple' => true,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'hideSearch' => true,
                ]);
                break;
            case BlockField::TYPE_FULL_PRICE_TAGS:
                $html = Select2::widget([
                    'id' => 'full_price_tags-select-widget-'.$idPart,
                    'name' => $name,
                    'value' => $value, // initial value
                    'data' => ArrayHelper::map(self::getContentFullPriceTagsList(), 'id', 'name'),
                    'maintainOrder' => true,
                    'toggleAllSettings' => [
                        'selectLabel' => '<i class="fas fa-ok-circle"></i> Выбрать все',
                        'unselectLabel' => '<i class="fas fa-remove-circle"></i> Отменить выбор',
                        'selectOptions' => ['class' => 'text-success'],
                        'unselectOptions' => ['class' => 'text-danger'],
                    ],
                    'options' => ['placeholder' => 'Выберите товарные теги...', 'multiple' => true, 'style' => 'width:100%;',],
                    'pluginOptions' => ['tags' => true, 'allowClear' => true,],
                    'hideSearch' => true,
                ]);
                break;
            case BlockField::TYPE_SPECIAL_GROUP:
                $html = Select2::widget([
                    'id' => BlockField::TYPE_SPECIAL_GROUP.'-select-widget-'.$idPart,
                    'name' => $name,
                    'value' => $value, // initial value
                    'data' => self::getContentSpecialGroupList(),
                    'maintainOrder' => true,
                    'toggleAllSettings' => [
                        'selectLabel' => '<i class="fas fa-ok-circle"></i> Выбрать все',
                        'unselectLabel' => '<i class="fas fa-remove-circle"></i> Отменить выбор',
                        'selectOptions' => ['class' => 'text-success'],
                        'unselectOptions' => ['class' => 'text-danger'],
                    ],
                    'options' => ['placeholder' => 'Выберите группы спецпредложений...', 'multiple' => true, 'style' => 'width:100%;',],
                    'pluginOptions' => ['tags' => true, 'allowClear' => true,],
                    'hideSearch' => true,
                ]);
                break;
            case BlockField::TYPE_SPECIAL_FLAG:
                $html = Select2::widget([
                    'id' => 'manufacturers-select-widget-'.$idPart,
                    'name' => $name,
                    'value' => $value,
                    'data' => self::getContentSpecialFlagList(),
                    'options' => [
                        'placeholder' => 'Выберите флаг спецпредложений...',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'hideSearch' => true,
                ]);
                break;
            case BlockField::TYPE_CONTENT_ID:
                $html = Select2::widget([
                    'id' => 'content-select-widget-'.$idPart,
                    'name' => $name,
                    'value' => $value,
                    'data' => ArrayHelper::map(self::getContentList(), 'id', 'name', 'type'),
                    'options' => [
                        'placeholder' => 'Выберите ссылку контента...',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'hideSearch' => true,
                ]);
                break;
            case BlockField::TYPE_STRUCTURE_ID:
                $filters = self::getContentFilterList();
                if (!is_array($value)) {
                    $value = [];
                }

                $html = '
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Привязка к фильтрам
                            <span class="tools pull-right">
                            <a class="fa fa-chevron-up" href="javascript:;"></a>
                        </span>
                        </h3>
                    </div>
                    <div class="panel-body tasks-widget content-form-filter-list" style="display: none;">

                        <div class="task-content">
                            <ul class="task-list ui-sortable">
                                <li class="list-danger">
                                    <div class="task-title" style="margin-right: 0;">
                                        <span class="task-title-sp"><strong class="text-danger">ДЕПАРТАМЕНТЫ</strong></span>
                                    </div>
                                </li>';
                                foreach ($filters[ContentFilter::TYPE_DEPARTMENT] as $filter) {
                                    $html .= '<li class="list-danger">
                                        <div class="task-title" style="margin-right: 0;">
                                        <span class="task-title-sp">
                                            '.$filter['name'].'
                                        </span>
                                            <div class="pull-right">'.
                                                CheckboxX::widget([
                                                    'name' => $name.'['.BlockField::TYPE_STRUCTURE_ID.']['.ContentFilter::TYPE_DEPARTMENT.']['.$filter['id'].']', //Content[content_blocks_list][103][blocks_list][19][fields][233]
                                                    'value' => BlockHelper::isContentStructureFilterChecked($value, $filter),
                                                    'options' => ['id' => 'filter-'.ContentFilter::TYPE_DEPARTMENT.'-'.$idPart.'-'.$filter['id'], 'class' => 'form-control',],
                                                    'pluginOptions' => ['threeState' => false,],
                                                ]).'
                                            </div>
                                        </div>
                                    </li>';
                                }

                                $html .= '<li class="list-info">
                                    <div class="task-title" style="margin-right: 0;">
                                        <span class="task-title-sp"><strong class="text-primary">МЕНЮ</strong></span>
                                    </div>
                                </li>';
                                foreach ($filters[ContentFilter::TYPE_MENU] as $filter) {
                                    $html .= '<li class="list-info">
                                    <div class="task-title" style="margin-right: 0;">
                                        <span class="task-title-sp">
                                            <strong>'.$filter['department_name'].'</strong> <i class="fa fa-arrow-right"></i> '.$filter['name'].'
                                        </span>
                                        <div class="pull-right">
                                            '.CheckboxX::widget([
                                                'name' => $name.'['.BlockField::TYPE_STRUCTURE_ID.']['.ContentFilter::TYPE_MENU.']['.$filter['id'].']',
                                                'value' => BlockHelper::isContentStructureFilterChecked($value, $filter),
                                                'options' => ['id' => 'filter-'.ContentFilter::TYPE_MENU.'-'.$idPart.'-'.$filter['id'], 'class' => 'form-control',],
                                                'pluginOptions' => ['threeState' => false,],
                                            ]).'
                                            </div>
                                        </div>
                                    </li>';
                                }

                                $html .= '<li class="list-warning">
                                    <div class="task-title" style="margin-right: 0;">
                                        <span class="task-title-sp"><strong class="text-warning">ТЕМАТИКИ</strong></span>
                                    </div>
                                </li>';
                                foreach ($filters[ContentFilter::TYPE_TAG] as $filter) {
                                    $html .= '<li class="list-warning">
                                    <div class="task-title" style="margin-right: 0;">
                                        <span class="task-title-sp">
                                            <strong>'.$filter['department_name'].'</strong> <i class="fa fa-arrow-right"></i> '.$filter['department_menu_name'].' <i class="fa fa-arrow-right"></i> '.$filter['name'].'
                                        </span>
                                        <div class="pull-right">
                                            '.CheckboxX::widget([
                                                'name' => $name.'['.BlockField::TYPE_STRUCTURE_ID.']['.ContentFilter::TYPE_TAG.']['.$filter['id'].']',
                                                'value' => BlockHelper::isContentStructureFilterChecked($value, $filter),
                                                'options' => ['id' => 'filter-'.ContentFilter::TYPE_TAG.'-'.$idPart.'-'.$filter['id'], 'class' => 'form-control',],
                                                'pluginOptions' => ['threeState' => false,],
                                            ]).'
                                        </div>
                                    </div>
                                </li>';
                                }
                        $html .= '</ul>
                                </div>
                            </div>
                        </div>'.PHP_EOL;
                break;
        }

        $i = '';
        if (($field instanceof BlockField || $field instanceof BlockFieldList) && !empty($field->description)) {
            $i = ' <a tabindex="0" class="popover-dismiss" role="button" data-toggle="popover" data-trigger="focus" title="Подсказка к полю" data-content="'.Html::encode($field->description).'">';
            $i .= '<i class="fas fa-info-circle text-primary"></i>';
            $i .= '</a>';
        }
        if ($field->type == BlockField::TYPE_RADIO) {
            return $radioTabsHtml;
        } else {
            return $field->type === BlockField::TYPE_LIST ? $html : '<div class="form-group block-field-'.$idPart.' block-type-'.$field->type.'">
            <label class="control-label" for="block-field-'.$idPart.'" style="display: block;">'.$field->name.$i.'</label>'.$html.'</div>';
        }
    }

    // ckecing active radio tab

    public static function currentTabCheck($radio_type, $name_id)
    {
        $res = false;
        if ($name_id == $radio_type) {
            $res = true;
        }
        return $res;
    }

    /**
     * @param int   $blockID
     * @param       $field
     * @param array $data
     *
     * @return string
     */
    public static function renderBlockField(int $blockID, $field, array $data) : string
    {
        $html = '';
        $value = !empty($data[$field->id]) ? $data[$field->id] : '';

        switch ($field->type) {
            case BlockField::TYPE_TEXT:
            case BlockField::TYPE_TEXTAREA:
            case BlockField::TYPE_TEXTAREA_EXT:
                $html = !empty($value) ? Html::tag('p', $value) : '';
                break;
            case BlockField::TYPE_IMAGE:
                $url = '/img/'.Catalog::IMAGE_NOT_AVAILABLE;
                if (!empty($value)) {
                    $basePath = \Yii::getAlias('@frontendImages').DIRECTORY_SEPARATOR;
                    $path = $basePath.Catalog::IMAGES_DIR_LR.DIRECTORY_SEPARATOR.$value;

                    if (file_exists($path)) {
                        $url = '/img/'.Catalog::IMAGES_DIR_LR.'/'.$value;
                    }
                }
                $html = Html::tag('p', Html::img($url, ['alt' => $field->name, 'class' => 'image-fluid',]));
                break;
            case BlockField::TYPE_DIGIT:
                $html = Html::tag('p', $field->name.': '.Html::tag('strong', $value));
                break;
            case BlockField::TYPE_DATE:
                $html = Html::tag('div', $field->name.': <i class="fas fa-calendar-alt"></i> '.$value, ['class' => 'date',]);
                break;
            case BlockField::TYPE_BOOL:
                $html = Html::tag('p', $field->name.': '.(!empty($value) ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-minus-circle"></i>'));
                break;
            case BlockField::TYPE_COLOR:
            case BlockField::TYPE_GRADIENT_COLOR:
                $html = '';
                break;
            case BlockField::TYPE_ARTICLE_ID:
                if (!empty($value)) {
                    $model = Content::find()->where(['id' => $value, 'type' => Content::TYPE_ARTICLE, 'deleted_at' => null,])->one();
                    if ($model) {
                        $html = Html::tag('p', Html::a($model->name, ['/articles/'.$model->id]));
                    }
                }
                break;
            case BlockField::TYPE_PAGE_ID:
                if (!empty($value)) {
                    $model = Content::find()->where(['id' => $value, 'type' => Content::TYPE_PAGE, 'deleted_at' => null,])->one();
                    if ($model) {
                        $html = Html::tag('p', Html::a($model->name, ['/pages/'.$model->id]));
                    }
                }
                break;
            case BlockField::TYPE_LIST:
                if (!empty($field->list)) {
                    $list = [];
                    $html = '<div class="blockk5"><div class="wrapper center-block">
                    <div class="panel-group" id="accordion'.$field->id.'" role="tablist" aria-multiselectable="true">';
                    $index = 1;
                    foreach ($field->list as $item) {
                        $d = [];
                        if (is_array($value)) {
                            $d = isset($value[$item->id]) ? [$item->id => $value[$item->id],] : [];
                        }

                        $tabID = 'heading'.$field->id.'-'.$index++;
                        $tabContentID = 'collapse'.$field->id.'-'.$index++;
                        $list[] = '
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="'.$tabID.'">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion'.$field->id.'" href="#'.$tabContentID.'" aria-expanded="false" aria-controls="'.$tabContentID.'">
                                        '.$item->name.'
                                    </a>
                                </h4>
                            </div>
                            <div id="'.$tabContentID.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="'.$tabID.'">
                                <div class="panel-body">'.self::renderBlockField($blockID, $item, $d).'</div>
                            </div>
                        </div>';
                    }
                    $html .= implode('', $list);
                    $html .= '</div></div></div>';
                }
                break;
            case BlockField::TYPE_TAGS:
                $names = '';
                if (is_array($value)) {
                    $rows = CustomTag::find()->select('name')->where(['is_active' => true, 'id' => $value,])->orderBy(['name' => SORT_ASC,])->asArray()->column();
                    $names = implode(', ', $rows);
                }

                $html = Html::tag('p', $field->name.': '.Html::tag('strong', $names));
                break;
            case BlockField::TYPE_FORMS:
                if (!empty($value)) {
                    $model = Form::find()->where(['id' => $value, 'deleted_at' => null,])->one();
                    if ($model) {
                        $html = Html::tag('p', Html::a($model->name, ['/form/form/update?id='.$model->id,]));
                    }
                }
                break;
            case BlockField::TYPE_DEPARTMENTS:
                if (!empty($value)) {
                    if ($model = Department::find()->where(['id' => $value,])->one()) {
                        $html = Html::tag('p', Html::a($model->name, ['department/department/update?id='.$model->id,]));
                    }
                }
                break;
        }

        return $html;
    }

    /**
     * @param BlockFieldList $model
     *
     * @return string
     */
    public static function getBlockFieldListItem(BlockFieldList $model) : string
    {
        $class = $model->isNewRecord ? 'danger' : 'success';

        return '<li class="list-'.$class.'">
            <div class="task-title">
                <div class="row">
                    '. Html::hiddenInput('BlockField['.BlockField::TYPE_LIST.'][id][]', $model->id) .'
                    <div class="col-lg-5">
                        '. Html::textInput('BlockField['.BlockField::TYPE_LIST.'][name][]', $model->name, ['class' => 'form-control', 'placeholder' => 'Название поля', 'readonly' => !$model->isNewRecord,]) .'
                    </div>
                    <div class="col-lg-3">
                        '. Html::textInput('BlockField['.BlockField::TYPE_LIST.'][description][]', $model->description, ['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('description'),]) .'
                    </div>
                    <div class="col-lg-3">
                        '. Html::dropDownList('BlockField['.BlockField::TYPE_LIST.'][type][]', $model->type, $model->getTypeOptions(), ['prompt' => 'Выбрать...', 'class' => 'form-control',]) .'
                    </div>
                    <div class="col-lg-1">
                        <div class="pull-right" style="margin-top: 7px;">
                            <button class="btn btn-danger btn-xs fas fa-trash-alt block-form-field-list-delete" data-id="'.$model->id.'" data-field_id="'.$model->field_id.'"></button>
                        </div>
                    </div>
                </div>
            </div>
        </li>';
    }

    /**
     * @param int   $contentBlockID
     * @param int   $blockID
     * @param array $rows
     * @param array $itemValue
     * @param int   $listSort
     *
     * @return string
     * @throws \Exception
     */
    public static function getBlockFieldList(int $contentBlockID, int $blockID, array $rows, array $itemValue = [], int $listSort = 0) : string
    {
        $class = empty($itemValue) ? 'danger' : 'default';
        $html = '<div class="panel panel-'.$class.'" '.(empty($itemValue) ? 'style="border-style: dashed;"' : '').'><div class="panel-body">';

        $field = current($rows);
        $modelName = $field instanceof BlockField || $field instanceof BlockFieldList ? 'Content' : 'BlockReady';
        $name = $modelName.'[content_blocks_list]['.$contentBlockID.'][blocks_list]['.$blockID.'][fields]';
        $name .= '['.$field->field_id.']['.BlockField::TYPE_LIST.']['.$listSort.']['.Content::SORT_KEY.']';

        $block = Block::find()->where(['id' => $blockID,])->asArray()->one();

        $colsHtml = $rowHtml = [];
        $colsHtml[] = '<div class="form-group block-field-sort"><label class="control-label" for="block-field-'.$listSort.'">Сортировка набора поля</label><input type="number" id="block-field-sort-'.$listSort.'" class="form-control" name="'.$name.'" value="'.$listSort.'" aria-required="true" style="width: 140px;" placeholder="Сортировка"></div>';

        foreach ($rows as $item) {
            $d = [];
            if (is_array($itemValue)) {
                $d = isset($itemValue[$item->id]) ? [$item->id => $itemValue[$item->id],] : [];
            }
            $rendered = self::generateBlockField($contentBlockID, $block, $item, $d, $listSort);
            if (in_array($item->type, [BlockField::TYPE_TEXTAREA, BlockField::TYPE_TEXTAREA_EXT, BlockField::TYPE_GRADIENT_COLOR, BlockField::TYPE_LIST, BlockField::TYPE_RADIO])) {
                $rowHtml[] = $rendered;
            } elseif (in_array($item->type, [BlockField::TYPE_IMAGE])) {
                $imagesHtml[] = $rendered;
            } else {
                $colsHtml[] = $rendered;
            }
        }

        $index = 0;
        $colsCount = count($colsHtml);
        while ($index < $colsCount) {
            $items = array_slice($colsHtml, $index, $colsCount);
            
            $html .= '<div class="row cols cols-'.$colsCount.'">'.PHP_EOL;
            foreach ($items as $item) {
                $html .= '<div class="col">'.$item.'</div>'.PHP_EOL;
            }
            $html .= '</div>'.PHP_EOL;

            $index += count($colsHtml);
        }
        $html .= '<div class="block-type-image_row">'.PHP_EOL;
        foreach ($imagesHtml as $item) {
            $html .= $item;
        }
        $html .= '</div>'.PHP_EOL;

        foreach ($rowHtml as $item) {
            $html .= $item;
        }

        $html .= '<div class="form-group" style="margin-bottom: 0;">'.Html::button('<i class="fas fa-ban"></i> Удалить набор полей', ['class' => 'btn btn-warning btn-sm content-block-field-list-delete-btn',]).'</div>';
        $html .= '</div></div>';

        return $html;
    }

    /**
     * @return Content|null
     */
    public static function getIndexPage() : ?Content
    {
        return Content::findOne(['is_index_page' => true, 'deleted_at' => null, 'type' => Content::TYPE_PAGE,]);
    }

    /**
     * @param Content $model
     *
     * @return bool
     */
    public static function isDisableIndexPageCheckbox(Content $model) : bool
    {
        $isDisable = true;

        if ($model->type === Content::TYPE_PAGE) {
            if ($model->is_index_page) {
                return false;
            }

            $indexPage = self::getIndexPage();

            if (!$indexPage) {
                return false;
            }

            if ($model->id === $indexPage->id) {
                $isDisable = false;
            }
        } elseif ($model->type === Content::TYPE_NEWS) {
            return false;
        }

        return $isDisable;
    }

    /**
     * @param BlockFieldValuesList $model
     *
     * @return string
     */
    public static function getBlockFieldValuesListItem(BlockFieldValuesList $model) : string
    {
        $class = $model->isNewRecord ? 'danger' : 'success';

        return '<li class="list-'.$class.'">
            <div class="task-title">
                <div class="row">
                    '. Html::hiddenInput('BlockField['.BlockField::TYPE_VALUES_LIST.'][id][]', $model->id) .'
                    <div class="col-lg-11">
                        '. Html::textInput('BlockField['.BlockField::TYPE_VALUES_LIST.'][value][]', $model->value, ['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('value'),]) .'
                    </div>
                    <div class="col-lg-1">
                        <div class="pull-right" style="margin-top: 7px;">
                            <button class="btn btn-danger btn-xs fas fa-trash-alt block-form-field-values-list-delete" data-id="'.$model->id.'" data-field_id="'.$model->field_id.'"></button>
                        </div>
                    </div>
                </div>
            </div>
        </li>';
    }

    /**
     * @param array $excludedBlockIDs
     *
     * @return array
     */
    public static function getBlocks(array $excludedBlockIDs = []) : array
    {
        $blocks = [Block::TYPE_GALLERY => [], Block::TYPE_TEXT => [], Block::TYPE_FILTER => [], Block::TYPE_SLIDER => [], Block::TYPE_BANNER => [], Block::TYPE_BLOCK_READY => [], Block::TYPE_FORM => [],];

        $query = Block::find()->where(['deleted_at' => null,])->orderBy(['type' => SORT_ASC, 'name' => SORT_ASC,])->asArray();
        $query->andFilterWhere(['not in', 'id', $excludedBlockIDs]);
        foreach ($query->all() as $row) {
            $blocks[$row['type']][$row['id']] = $row['name'];
        }

        $query = BlockReady::find()->where(['is_active' => true,])->orderBy(['global_type' => SORT_ASC, 'name' => SORT_ASC,])->asArray();
        foreach ($query->all() as $row) {
            $blocks[Block::TYPE_BLOCK_READY][$row['id']] = $row['name'];
        }

        $query = Form::find()->where(['deleted_at' => null,])->orderBy(['name' => SORT_ASC,])->asArray();
        foreach ($query->all() as $row) {
            $blocks[Block::TYPE_FORM][$row['id']] = $row['name'];
        }

        return $blocks;
    }

    /**
     * @return array
     */
    public static function getSettingBlocksOptions() : array
    {
        $query = Block::find()->where(['deleted_at' => null,])->orderBy(['name' => SORT_ASC,])->asArray();
        $query->where(['type' => Block::TYPE_SETTING,]);

        return ArrayHelper::map($query->all(), 'id', 'name');
    }

    /**
     * @param array $blocks
     * @param bool  $isOnlyBlocks
     *
     * @return array
     */
    public static function getAddBlockOptions(array $blocks, bool $isOnlyBlocks = false) : array
    {
        $types = (new Block())->getTypeOptions();

        unset($types[Block::TYPE_SETTING]);

        if ($isOnlyBlocks) {
            unset($types[Block::TYPE_BLOCK_READY]);
            unset($types[Block::TYPE_FORM]);
        }

        foreach ($types as $type => $title) {
            $types[$type] = $title . ' ('.(isset($blocks[$type]) ? count($blocks[$type]) : 0).')';
        }

        return $types;
    }

    /**
     * @param Content $content
     *
     * @return array
     */
    public static function getContentBlocksData(Content $content) : array
    {
        $data = [];
        $blocks = $content->getBlocksData();

        foreach ($blocks as $block) {
            $fields = BlockField::find()->where(['block_id' => $block['id'], 'deleted_at' => null,])->orderBy(['sort' => SORT_ASC,])->all();

            foreach ($fields as $field) {
                if ($field->type === BlockField::TYPE_LIST || $field->type === BlockField::TYPE_RADIO) {
                    $field->list = $field->getBlockFieldLists()->all();
                }

                $json = !empty($block['data']) ? Json::decode($block['data']) : [];
                $data[] = self::renderBlockField($block['id'], $field, $json);
            }
        }

        return $data;
    }

    /**
     * @return array
     */
    public static function getContentFilterList() : array
    {
        $queryDepartments = Department::find()->select([
                'id',
                'name',
                new Expression("'".ContentFilter::TYPE_DEPARTMENT."' AS type"),
            ])
            ->where([
                'is_active' => true,
            ])
            ->orderBy(['sort' => SORT_ASC,])
            ->indexBy('id')
            ->asArray();

        $queryMenus = DepartmentMenu::find()->select([
            DepartmentMenu::tableName().'.id',
            DepartmentMenu::tableName().'.name',
            Department::tableName().'.id AS department_id',
            Department::tableName().'.name AS department_name',
            new Expression("'".ContentFilter::TYPE_MENU."' AS type"),
        ])
            ->innerJoin(Department::tableName(), DepartmentMenu::tableName().'.department_id = '.Department::tableName().'.id')
            ->where([
                DepartmentMenu::tableName().'.is_active' => true,
                Department::tableName().'.is_active' => true,
            ])
            ->orderBy([DepartmentMenu::tableName().'.sort' => SORT_ASC,])
            ->indexBy('id')
            ->asArray();

        $queryTags = DepartmentMenuTag::find()->select([
            DepartmentMenuTag::tableName().'.id',
            DepartmentMenuTag::tableName().'.name',
            DepartmentMenuTag::tableName().'.url',
            DepartmentMenuTag::tableName().'.image',
            DepartmentMenu::tableName().'.id AS department_menu_id',
            DepartmentMenu::tableName().'.name AS department_menu_name',
            Department::tableName().'.name AS department_name',
            new Expression("'".ContentFilter::TYPE_TAG."' AS type"),
        ])
            ->innerJoin(DepartmentMenu::tableName(), DepartmentMenuTag::tableName().'.department_menu_id = '.DepartmentMenu::tableName().'.id')
            ->innerJoin(Department::tableName(), DepartmentMenu::tableName().'.department_id = '.Department::tableName().'.id')
            ->where([
                DepartmentMenuTag::tableName().'.is_active' => true,
                DepartmentMenu::tableName().'.is_active' => true,
                Department::tableName().'.is_active' => true,
            ])
            ->orderBy([DepartmentMenuTag::tableName().'.sort' => SORT_ASC,])
            ->indexBy('id')
            ->asArray();

//        $queryPages = Department::find()->select([
//            Department::tableName().'.id AS department_id',
//            Department::tableName().'.name AS department_name',
//            DepartmentMenu::tableName().'.id AS department_menu_id',
//            DepartmentMenu::tableName().'.name AS department_menu_name',
//        ])
//            ->leftJoin(DepartmentMenu::tableName(), DepartmentMenu::tableName().'.department_id = '.Department::tableName().'.id AND '.DepartmentMenu::tableName().'.is_active = true')
//            ->where([
//                Department::tableName().'.is_active' => true,
//            ])
//            ->orderBy([Department::tableName().'.sort' => SORT_ASC, DepartmentMenu::tableName().'.sort' => SORT_ASC,])
//            ->asArray();

//        $pages = [];
//        $rows = $queryPages->all();
//        foreach ($rows as $row) {
//            if (!isset($pages[$row['department_id']])) {
//                $pages[$row['department_id']] = ['name' => $row['department_name'], ContentFilterPage::TYPE_DEPARTMENT_MENU => [],];
//            }
//            if (!empty($row['department_menu_id']) && !isset($pages[$row['department_id']][ContentFilterPage::TYPE_DEPARTMENT_MENU][$row['department_menu_id']])) {
//                $pages[$row['department_id']][ContentFilterPage::TYPE_DEPARTMENT_MENU][$row['department_menu_id']] = $row['department_menu_name'];
//            }
//        }

        return [
            ContentFilter::TYPE_DEPARTMENT => $queryDepartments->all(),
            ContentFilter::TYPE_MODEL => [], //@TODO переделать на новую таблицу моделей
            ContentFilter::TYPE_MENU => $queryMenus->all(),
            ContentFilter::TYPE_TAG => $queryTags->all(),
//            ContentFilter::TYPE_PAGES => $pages,
        ];
    }

    /**
     * @return array
     */
    public static function getContentTagList() : array
    {
        return CustomTag::find()->where(['is_active' => true,])
            ->orderBy(['name' => SORT_ASC,])
            ->asArray()
            ->all();
    }

    /**
     * @return array
     */
    public static function getContentFormList() : array
    {
        return Form::find()->where(['deleted_at' => null,])
            ->orderBy(['name' => SORT_ASC,])
            ->asArray()
            ->all();
    }

    /**
     * @return array
     */
    public static function getContentDepartmentList() : array
    {
        return Department::find()->select(['id', 'name',])->where(['is_active' => true, 'is_default' => false,])
            ->orderBy(['sort' => SORT_ASC,])
            ->asArray()
            ->all();
    }

    /**
     * @return array
     */
    public static function getContentList() : array
    {
        $rows = Content::find()->select(['id', 'name', 'type',])->where(['deleted_at' => null, 'type' => [Content::TYPE_ARTICLE, Content::TYPE_NEWS, Content::TYPE_PAGE,],])
            ->orderBy(['type' => SORT_ASC, 'name' => SORT_ASC,])
            ->asArray()
            ->all();

        $model = new Content();
        foreach ($rows as $i => $row) {
            $rows[$i]['type'] = $model->getTypeTitle($row['type']);
        }

        return $rows;
    }

    /**
     * @return array
     */
    public static function getContentManufacturersList() : array
    {
        return FullPrice::find()->select(['manufacturer',])->distinct(true)->where(['!=', 'manufacturer', '',])
            ->orderBy(['manufacturer' => SORT_ASC,])
            ->indexBy('manufacturer')
            ->asArray()
            ->column();
    }

    /**
     * @return array
     */
    public static function getContentFullPriceTagsList() : array
    {
        return [];
    }

    /**
     * @return array
     */
    public static function getContentSpecialGroupList() : array
    {
        return SpecialOffers::find()->select(['offer_name',])->distinct(true)->where(['offer_type' => SpecialOffers::OFFER_TYPE_GROUPING,])
            ->orderBy(['offer_name' => SORT_ASC,])
            ->indexBy('offer_name')
            ->asArray()
            ->column();
    }

    /**
     * @return array
     */
    public static function getContentSpecialFlagList() : array
    {
        return SpecialOffers::find()->select(['offer_name',])->distinct(true)->where(['offer_type' => SpecialOffers::OFFER_TYPE_FLAG,])
            ->orderBy(['offer_name' => SORT_ASC,])
            ->indexBy('offer_name')
            ->asArray()
            ->column();
    }

    /**
     * @param array $contentFilters
     * @param array $filter
     *
     * @return bool
     */
    public static function isContentFilterChecked(array $contentFilters, array $filter) : bool
    {
        $isChecked = false;

        /** @var $contentFilter ContentFilter */
        foreach ($contentFilters as $contentFilter) {
            if ($contentFilter->type === $filter['type'] && $contentFilter->list_id == $filter['id']) {
                $isChecked = true;

                break;
            }
        }

        return $isChecked;
    }

    /**
     * @param array $contentFilters
     * @param array $filter
     *
     * @return bool
     */
    public static function isContentStructureFilterChecked(array $contentFilters, array $filter) : bool
    {
        $isChecked = false;

        if (!empty($contentFilters[$filter['type']]) && in_array($filter['id'], $contentFilters[$filter['type']])) {
            $isChecked = true;
        }

        return $isChecked;
    }

    /**
     * @param array  $contentFilterPages
     * @param string $type
     * @param int    $id
     *
     * @return bool
     */
    public static function isContentFilterPageChecked(array $contentFilterPages, string $type, int $id) : bool
    {
        $isChecked = false;

        /** @var $contentFilterPage ContentFilterPage */
        foreach ($contentFilterPages as $contentFilterPage) {
            if ($contentFilterPage->type === $type && $contentFilterPage->department_content_id == $id) {
                $isChecked = true;

                break;
            }
        }

        return $isChecked;
    }

    /**
     * @param int    $contentID
     * @param array  $contentFilterPages
     * @param string $type
     * @param int    $id
     *
     * @return bool
     */
    public static function isContentFilterPageDisabled(int $contentID, array $contentFilterPages, string $type, int $id) : bool
    {
        $isDisabled = false;

        foreach ($contentFilterPages as $contentFilterPage) {
            if ($contentFilterPage['type'] === $type && $contentFilterPage['department_content_id'] == $id) {
                if ($contentID != $contentFilterPage['content_id']) {
                    $isDisabled = true;

                    break;
                }
            }
        }

        return $isDisabled;
    }

    /**
     * @param string $shop
     * @param array  $menu
     *
     * @return array
     */
    public static function getGreenMenuLinkUrl(string $shop, array $menu) : string
    {
        if ($menu['landing_page_type'] === DepartmentMenu::LANDING_PAGE_TYPE_CATALOG && !empty($menu['landing_page_catalog'])) {
            return Html::a($menu['name'], ['catalog/view', 'code' => $menu['landing_page_catalog'],]);
        }

        return Html::a($menu['name'], ['shop/shop', 'shop' => $shop, 'menu' => $menu['url'],]);
    }

    /**
     * @param string $shop
     * @param string $menu
     * @param array  $tag
     *
     * @return string
     */
    public static function getGreenMenuTagLinkUrl(string $shop, string $menu, array $tag) : string
    {
        return Html::a($tag['name'], ['shop/shop', 'shop' => $shop, 'menu' => $menu, 'tag' => $tag['url'],]);
    }

    /**
     * @param Content $pageModel
     *
     * @return string
     */
    public static function getGreenMenuNewLinkUrl(Content $pageModel) : string
    {
        return Html::a($pageModel->title, ['content/'.ContentFilter::TYPE_PAGES.'-alias', 'alias' => $pageModel->alias,]);
    }

    public static function getGreenMenuNewGreenMenuLinkUrl(GreenMenu $greenMenu) : string
    {
        return Html::a($greenMenu->title, ['content/'.ContentFilter::TYPE_PAGES.'-alias', 'alias' => $greenMenu->landingPage->alias,]);
    }

    /**
     * @param array $contentTags
     * @param array $tag
     *
     * @return bool
     */
    public static function isContentTagChecked(array $contentTags, array $tag) : bool
    {
        $isChecked = false;

        /** @var $contentTag ContentFilter */
        foreach ($contentTags as $contentTag) {
            if ($contentTag->custom_tag_id == $tag['id']) {
                $isChecked = true;
                break;
            }
        }

        return $isChecked;
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
     * @param     $data
     *
     * @return string
     */
    public static function getNewsCarousel($data) : string
    {
        $data = !is_array($data) ? [$data,] : $data;

        $html = '';

        if (empty($data)) {
            return $html;
        }

        $html .= Html::beginTag('div', ['class' => 'news-post__full-slider',]);
        $html .= Html::beginTag('div', ['class' => 'news-post__full-slider-wrapper',]);
        $html .= Html::beginTag('div', ['class' => 'news-post__full-slides',]);

        foreach ($data as $key => $value) {
            $html .= Html::beginTag('span', ['class' => 'news-post__full-slide',]);
            $imgCover = 'object-fit: contain;';
            if (empty($value['fill_image'])) {
                $imgCover = 'object-fit: cover;';
            }
            if (isset($value['image'])) {
                $pos = mb_stripos($value['image'], 'youtube.com', 0, 'utf-8');
                if ($pos !== false) {
                    $getArray = [];
                    $urlParams = parse_url($value['image'], PHP_URL_QUERY);
                    parse_str($urlParams, $getArray);
                    
                    if (!empty($getArray['v'])) {
                        $html .= Html::beginTag('div', ['class' => 'news-post__full-video',]);
                        $html .= Html::beginTag('a', ['class' => 'news-post__full-video-link', 'href' => '#',]);
                        $html .= Html::img('https://i.ytimg.com/vi/'.$getArray['v'].'/maxresdefault.jpg', ['class' => 'news-post__full-video-media', 'alt' => '',]);

                        $html .= Html::beginTag('div', ['class' => 'news-post__full-video-button',]);
                            $html .= Html::beginTag('svg', ['width' => 68, 'height' => 50, 'viewBox' => '0 0 68 50',]);
                                $html .= Html::tag('path', '', ['class' => 'news-post__full-button-shape', 'd' => 'M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z',]);
                                $html .= Html::tag('path', '', ['class' => 'news-post__full-button-icon', 'd' => 'M 45,24 27,14 27,34',]);
                            $html .= Html::endTag('svg');
                        $html .= Html::endTag('div');

                        $html .= Html::endTag('a');
                        $html .= Html::endTag('div').PHP_EOL;
                    }
                } else {
                    $html .= Html::img($value['image'], ['alt' => '', 'style' => $imgCover]).PHP_EOL;
                }
            }

            $html .= Html::endTag('span');
        }

        $html .= Html::endTag('div'); //news-post__full-slides
        $html .= Html::endTag('div'); //news-post__full-slider-wrapper

        $html .= Html::beginTag('div', ['class' => 'news-post__full-slider-control',]);
        $html .= Html::a('', '#', ['class' => 'news-post__full-slider-control-prev',]);
        $html .= Html::a('', '#', ['class' => 'news-post__full-slider-control-next',]);
        $html .= Html::endTag('div'); //news-post__full-slider-control

        $html .= Html::endTag('div'); //news-post__full-slider

        return $html;
    }

    /**
     * @param        $data
     * @param        $delay
     * @param array  $sliderHeight
     * @return string
     */
    public static function getNewsSlider($sliderType = '', $sliderHeight, $data, $delay = 0, $isPage) : string
    {
        if (empty($sliderHeight)) {
            $sliderHeight = array('desktop' => 500, 'tablet' => 350, 'mobile' => 200);
        }
        if (empty($sliderHeight['desktop'])) {
            $sliderHeight['desktop'] = 500;
        } 
        if (empty($sliderHeight['tablet'])) {
            $sliderHeight['tablet'] = 350;
        } 
        if (empty($sliderHeight['mobile'])) {
            $sliderHeight['mobile'] = 200;
        }

        if ($sliderType == 369 || $sliderType == 371) {
            $maxWidth = 'max-width: 1140px;';
        } else {
            $maxWidth = 'max-width: 100%;';
        }

        $data = !is_array($data) ? [$data,] : $data;
        
        $html = '';

        if (empty($data)) {
            return $html;
        }
        if ($isPage) {
            $html .= Html::beginTag('div', ['class' => 'single-universal-slider', 'style' => ''.$maxWidth.' margin: 0 auto;', 'data-timer' => $delay, 'data-height-desktop' => $sliderHeight['desktop'], 'data-height-tablet' => $sliderHeight['tablet'], 'data-height-mobile' => $sliderHeight['mobile']]);
        }
        $html .= Html::beginTag('div', ['class' => 'news-post__full-slider',]);
        $html .= Html::beginTag('div', ['class' => 'news-post__full-slider-wrapper',]);
        $html .= Html::beginTag('div', ['class' => 'news-post__full-slides',]);

        foreach ($data as $key => $value) {

            $html .= Html::beginTag('span', ['class' => 'news-post__full-slide',]);
            if (isset($value['img'])) {
            $pos = mb_stripos($value['img']['desktop'], 'youtube.com', 0, 'utf-8');
                if ($pos !== false) {
                    $getArray = [];
                    $urlParams = parse_url($value['img']['desktop'], PHP_URL_QUERY);
                    parse_str($urlParams, $getArray);

                    if (!empty($getArray['v'])) {
                        $html .= Html::beginTag('div', ['class' => 'universal-slider__video',]);
                        $html .= Html::beginTag('a', ['class' => 'universal-slider__video-link', 'href' => '#',]);
                        $html .= Html::img('https://i.ytimg.com/vi/'.$getArray['v'].'/maxresdefault.jpg', ['class' => 'universal-slider__video-media', 'alt' => '',]);

                        $html .= Html::beginTag('div', ['class' => 'universal-slider__video-button',]);
                            $html .= Html::beginTag('svg', ['width' => 68, 'height' => 50, 'viewBox' => '0 0 68 50',]);
                                $html .= Html::tag('path', '', ['class' => 'universal-slider__button-shape', 'd' => 'M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z',]);
                                $html .= Html::tag('path', '', ['class' => 'universal-slider__button-icon', 'd' => 'M 45,24 27,14 27,34',]);
                            $html .= Html::endTag('svg');
                        $html .= Html::endTag('div');

                        $html .= Html::endTag('a');
                        $html .= Html::endTag('div').PHP_EOL;
                    }
                } else {
                    $html .= Html::beginTag('picture');
                        if (!empty($value['img']['tablet'])) {
                            $img = self::prepareImage($value['img']['tablet']);
                            $html .= Html::beginTag('source', ['media' => '(min-width: 1140px)', 'srcset' => $img]);
                            $html .= Html::endTag('source').PHP_EOL;
                        } elseif (!empty($value['img']['desktop'])) {
                            $img = self::prepareImage($value['img']['desktop']);
                            $html .= Html::beginTag('source', ['media' => '(min-width: 768px)', 'srcset' => $img]);
                            $html .= Html::endTag('source').PHP_EOL;
                        } else {
                            $img = self::prepareImage($value['img']['mobile']);
                        }
                        $html .= Html::img($img, ['alt' => '']);
                    $html .= Html::endTag('picture').PHP_EOL;
                }
            } else {
                $html .= Html::img($value, ['alt' => '']).PHP_EOL;
            }

            $html .= Html::endTag('span'); // niversal-slider__slide
        }

        $html .= Html::endTag('div'); //universal-slider__slides
        $html .= Html::endTag('div'); //universal-slider__slider-wrapper
        
        $html .= Html::beginTag('div', ['class' => 'news-post__full-slider-control',]);
        $html .= Html::a('', '#', ['class' => 'news-post__full-slider-control-prev',]);
        $html .= Html::a('', '#', ['class' => 'news-post__full-slider-control-next',]);
        $html .= Html::endTag('div'); //news-post__full-slider-control
        
        $html .= Html::endTag('div'); //universal-slider__slider
        if ($isPage) {
        $html .= Html::endTag('div'); //single-universal-slider
        }

        return $html;
    }

    /**
     * @param        $data
     * @param string $delay
     *
     * @return string
     */
    public static function getSlider($sliderType, $data, $delay) : string
    {
        $data = !is_array($data) ? [$data,] : $data;

        $html = '';

        if (empty($data)) {
            return $html;
        }
        if ($sliderType == 369 || $sliderType == 371) {
            $maxWidth = 'max-width: 1140px; margin: 0 auto;';
        } else {
            $maxWidth = 'max-width: 100%;';
        }

        $html .= Html::beginTag('div', ['class' => 'slider', 'style' => $maxWidth, 'data-timer' => $delay]);
        $html .= Html::beginTag('div', ['class' => 'slider__wrap',]);

        foreach ($data as $key => $value) {
            $html .= Html::beginTag('div', ['class' => 'slider__item fade',]);
                    $html .= Html::beginTag('picture');
                        if (isset($value['img']['mobile']) || isset($value['img']['tablet']) || isset($value['img']['desktop'])) {
                            $imageTablet = $value['img']['tablet'];
                            $imageDesktop = $value['img']['desktop'];
                            $imageMobile = $value['img']['mobile'];
                            if (!empty($imageTablet)) {
                                $imageTablet = self::prepareImage($imageTablet);
                            } elseif (!empty($imageDesktop)) {
                                $imageDesktop = self::prepareImage($imageDesktop);
                            } else {
                                $imageMobile = self::prepareImage($imageMobile);
                            }
                        }
                        $html .= Html::beginTag('source', ['media' => '(min-width: 1140px)', 'srcset' => $imageTablet]);
                        $html .= Html::endTag('source').PHP_EOL;
                        $html .= Html::beginTag('source', ['media' => '(min-width: 768px)', 'srcset' => $imageDesktop]);
                        $html .= Html::endTag('source').PHP_EOL;
                        $html .= Html::img($imageMobile, ['alt' => '']);
                    $html .= Html::endTag('picture').PHP_EOL;
                if ($value['header'] || $value['text']) {
                $html .= Html::beginTag('div', ['class' => 'slider__item-info',]);
                    $html .= Html::beginTag('a', ['href' => $value['link'],]);
                        $html .= Html::beginTag('div', ['class' => 'slider-title', 'style' => 'color:'.$value['header_color']]);
                            $html .= $value['header'];
                        $html .= Html::endTag('div').PHP_EOL;
                        $html .= Html::beginTag('p', ['class' => 'slider-text', 'style' => 'color:'.$value['text_color'],]);
                            $html .= $value['text'];
                        $html .= Html::endTag('p').PHP_EOL;
                    $html .= Html::endTag('a').PHP_EOL;
                $html .= Html::endTag('div').PHP_EOL;
                }
            $html .= Html::endTag('div').PHP_EOL;
        }

        $html .= Html::endTag('div'); //slider__wrap

        $html .= Html::beginTag('div', ['class' => 'slider__dots',]);
        for ($i=0; $i < count($data); $i++) { 
            $html .= Html::beginTag('div', ['class' => 'dot',]);
            $html .= Html::endTag('div'); //dot
        }
        $html .= Html::endTag('div'); //slider__dots

        $html .= Html::endTag('div'); //slider

        return $html;
    }

    /**
     * @param Content $model
     * @param null    $selectedID
     *
     * @return string
     */
    public static function getContentCustomTags(Content $model, $selectedID = null) : string
    {
        $html = '';
        $customTags = $model->customTags;

        if ($customTags) {
            $html .= Html::beginTag('nav', ['class' => 'tags',]);

            foreach ($customTags as $customTag) {
                $html .= Html::a($customTag->name, ['/content/search', 'tag' => $customTag->name,], ['class' => 'tag'.(!empty($selectedID) && $selectedID === $customTag->id ? ' active' : ''),]);
            }

            $html .= Html::endTag('nav');
        }

        return $html;
    }

    /**
     * @param string $globalType
     *
     * @return string
     */
    public static function generateBlockReadyFieldsByGlobalType(string $globalType) : string
    {
        $html = '';

        return $html;
    }
}