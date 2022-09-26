<?php

namespace common\models;

use yii\db\Expression;
use yii\helpers\Url;
use yii\web\UploadedFile;
use common\components\helpers\CatalogHelper;
use common\components\helpers\ParserHelper;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "parser_lrparts_rubrics".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $url
 * @property string $path
 * @property string $parent_url
 * @property bool $is_last
 * @property bool $is_active
 * @property string $catalog_codes
 * @property int $sort_field
 * @property string $title
 * @property string $page_header
 * @property string $description
 * @property string $description_bottom
 * @property string $image
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ParserLrpartsRubrics[] $children
 */
class ParserLrpartsRubrics extends \yii\db\ActiveRecord
{
    public $content_blocks_list;
    public $serverImage;
    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parser_lrparts_rubrics';
    }

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
            [['parent_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['parent_id', 'created_at', 'updated_at', 'sort_field',], 'integer'],
            [['name', 'page_header',], 'required'],
            [['path', 'catalog_codes', 'description', 'description_bottom',], 'string'],
            [['is_last', 'is_active',], 'boolean'],
            [['name', 'url', 'parent_url', 'title', 'page_header', 'image',], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg',],
            [['url', 'parent_url'], 'unique', 'targetAttribute' => ['url', 'parent_url']],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Родитель ID',
            'name' => 'Наименование',
            'url' => 'Url',
            'path' => 'Путь',
            'parent_url' => 'Родительский Url',
            'is_last' => 'Is Last',
            'is_active' => 'Активен',
            'sort_field' => 'Сортировка',
            'title' => 'Title',
            'page_header' => 'Заголовок на странице',
            'description' => 'Текст SEO верхний',
            'description_bottom' => 'Текст SEO нижний',
            'image' => 'Изображение',
            'serverImage' => 'Изображение',
            'imageFile' => 'Изображение',
            'catalog_codes' => 'Сопутствующие разделы каталога LR.RU',
            'created_at' => 'Создано',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return array
     */
    public function getCatalogCodesList(): array
    {
        $codes = [];

        if (!empty($this->catalog_codes)) {
            $items = explode(',', $this->catalog_codes);

            foreach ($items as $item) {
                $codes[] = trim($item);
            }
        }

        return $codes;
    }

    /**
     * @param bool $isBackend
     *
     * @return string
     */
    public function getImageSrc(bool $isBackend = false) : string
    {
        if (!empty($this->image)) {
            $basePath = ($isBackend ? \Yii::getAlias('@backendImages') : \Yii::getAlias('@frontendImages')).DIRECTORY_SEPARATOR;
            $path = $basePath.'Parsing'.DIRECTORY_SEPARATOR.'lrparts.ru'.DIRECTORY_SEPARATOR.$this->image;

            $src = file_exists($path) ? ParserHelper::IMAGES_PATH_LRPARTS.$this->image : ParserHelper::getLrPartsDefaultImageUrl();
        } else {
            $src = $this->id ? ParserHelper::getLrPartsImageUrl($this->id, true) : ParserHelper::getLrPartsDefaultImageUrl();
        }

        return 'https://final.lr.ru'.$src;
    }

    /**
     * @return string|null
     */
    public function upload() : ?string
    {
        if (!empty($this->imageFile) && $this->validate()) {
            $path = \Yii::getAlias('@backendImages').DIRECTORY_SEPARATOR.'Parsing'.DIRECTORY_SEPARATOR.'lrparts.ru'.DIRECTORY_SEPARATOR;
            $name = $this->id.'_'.time().'.'.$this->imageFile->extension;
            $this->imageFile->saveAs($path.$name, false);

            return $name;
        } else {
            return null;
        }
    }

    /**
     * @return array
     */
    public function getBlocksData(int $rubricID) : array
    {
        $blockQuery = Block::find()
            ->select([
                Block::tableName().'.id',
                Block::tableName().'.name',
                Block::tableName().'.description',
                Block::tableName().'.type',
                Block::tableName().'.global_type',
                ParserLrpartsRubricsBlockField::tableName().'.data',
                ParserLrpartsRubricsBlock::tableName().'.id AS content_block_id',
                new Expression("'".ContentBlock::TYPE_BLOCK."' AS content_block_type"),
                ParserLrpartsRubricsBlock::tableName().'.is_active AS content_block_is_active',
                new Expression("NULL AS color"),
                new Expression("NULL AS color_bg"),
                new Expression("NULL AS emails"),
                new Expression("NULL AS result"),
            ])
            ->innerJoin(ParserLrpartsRubricsBlock::tableName(), ParserLrpartsRubricsBlock::tableName().'.block_id = '.Block::tableName().'.id')
            ->leftJoin(ParserLrpartsRubricsBlockField::tableName(), ParserLrpartsRubricsBlock::tableName().'.id = '.ParserLrpartsRubricsBlockField::tableName().'.parser_lrparts_rubrics_block_id')
            ->where([
                ParserLrpartsRubricsBlock::tableName().'.rubric_id' => $rubricID,
                Block::tableName().'.deleted_at' => null,
            ])
            ->asArray()
            ->orderBy([ParserLrpartsRubricsBlock::tableName().'.sort' => SORT_ASC,])
            ->indexBy('content_block_id');

        return $blockQuery->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getLrpartsRubricsBlocks()
    {
        return $this->hasMany(ParserLrpartsRubricsBlock::class, ['rubric_id' => 'id',])->orderBy([ParserLrpartsRubricsBlock::tableName().'.sort' => SORT_ASC,]);
    }

    /**
     * @param $runValidation
     * @param $attributeNames
     *
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $isSaved = parent::save($runValidation, $attributeNames);

        if ($isSaved && !empty($this->content_blocks_list) && is_array($this->content_blocks_list)) { // //rubric[content_blocks_list][103][blocks_list][19][fields][233]
            $rubricBlocks = $this->getLrpartsRubricsBlocks()->with('rubricsBlockField')->all();

            foreach ($this->content_blocks_list as $rubricBlockID => $rubricBlockData) {
                foreach ($rubricBlockData['blocks_list'] as $blockID => $blocksListData) {
                    $data = [];

                    if (!empty($blocksListData['sort']) || isset($blocksListData['is_active'])) {
                        if ($rubricBlock = ParserLrpartsRubricsBlock::findOne(['id' => $rubricBlockID,])) {
                            if (!empty($blocksListData['sort'])) {
                                $rubricBlock->sort = (int)$blocksListData['sort'];
                            }
                            $rubricBlock->is_active = (boolean)$blocksListData['is_active'];
                            $rubricBlock->save();
                        }
                    }

                    if (!empty($blocksListData['fields'])) {
                        foreach ($blocksListData['fields'] as $fieldID => $fieldData) { //[264] => [list][1][44]   [348] => [g_color][left]
                            if (is_array($fieldData)) {
                                if (!empty($fieldData[BlockField::TYPE_LIST])) { //список полей
                                    $index = 0;
                                    foreach ($fieldData[BlockField::TYPE_LIST] as $fieldListData) {
                                        foreach ($fieldListData as $fieldListID => $value) {
                                            $data[$fieldID][$index][$fieldListID] = $value;
                                        }
                                        $index++;
                                    }
                                } elseif (!empty($fieldData[BlockField::TYPE_GRADIENT_COLOR])) { //град. цвет
                                    $data[$fieldID][BlockField::GRADIENT_COLOR_LEFT] = !empty($fieldData[BlockField::TYPE_GRADIENT_COLOR][BlockField::GRADIENT_COLOR_LEFT]) ? $fieldData[BlockField::TYPE_GRADIENT_COLOR][BlockField::GRADIENT_COLOR_LEFT] : '';
                                    $data[$fieldID][BlockField::GRADIENT_COLOR_CENTER] = !empty($fieldData[BlockField::TYPE_GRADIENT_COLOR][BlockField::GRADIENT_COLOR_CENTER]) ? $fieldData[BlockField::TYPE_GRADIENT_COLOR][BlockField::GRADIENT_COLOR_CENTER] : '';
                                    $data[$fieldID][BlockField::GRADIENT_COLOR_RIGHT] = !empty($fieldData[BlockField::TYPE_GRADIENT_COLOR][BlockField::GRADIENT_COLOR_RIGHT]) ? $fieldData[BlockField::TYPE_GRADIENT_COLOR][BlockField::GRADIENT_COLOR_RIGHT] : '';
                                } elseif (!empty($fieldData[BlockField::TYPE_STRUCTURE_ID])) { //структуры департаментов
                                    if (!empty($fieldData[BlockField::TYPE_STRUCTURE_ID][ContentFilter::TYPE_DEPARTMENT])) {
                                        $data[$fieldID][ContentFilter::TYPE_DEPARTMENT] = [];
                                        foreach ($fieldData[BlockField::TYPE_STRUCTURE_ID][ContentFilter::TYPE_DEPARTMENT] as $id => $value) {
                                            if (!empty($value)) {
                                                $data[$fieldID][ContentFilter::TYPE_DEPARTMENT][] = $id;
                                            }
                                        }
                                    }
                                    if (!empty($fieldData[BlockField::TYPE_STRUCTURE_ID][ContentFilter::TYPE_MENU])) {
                                        $data[$fieldID][ContentFilter::TYPE_MENU] = [];
                                        foreach ($fieldData[BlockField::TYPE_STRUCTURE_ID][ContentFilter::TYPE_MENU] as $id => $value) {
                                            if (!empty($value)) {
                                                $data[$fieldID][ContentFilter::TYPE_MENU][] = $id;
                                            }
                                        }
                                    }
                                    if (!empty($fieldData[BlockField::TYPE_STRUCTURE_ID][ContentFilter::TYPE_TAG])) {
                                        $data[$fieldID][ContentFilter::TYPE_TAG] = [];
                                        foreach ($fieldData[BlockField::TYPE_STRUCTURE_ID][ContentFilter::TYPE_TAG] as $id => $value) {
                                            if (!empty($value)) {
                                                $data[$fieldID][ContentFilter::TYPE_TAG][] = $id;
                                            }
                                        }
                                    }
                                }
                            } else { //не массив
                                $data[$fieldID] = $fieldData;
                            }
                        }
                    }

                    /**
                     * @var $rubricBlock ParserLrpartsRubricsBlock
                     */
                    foreach ($rubricBlocks as $rubricBlock) {
                        if ($rubricBlock->id == $rubricBlockID) {
                            $rubricsBlockField = $rubricBlock->rubricsBlockField;

                            if (empty($rubricsBlockField)) {
                                $rubricsBlockField = new ParserLrpartsRubricsBlockField();
                                $rubricsBlockField->parser_lrparts_rubrics_block_id = $rubricBlock->id;
                            }
                            $rubricsBlockField->setData($data);
                            $rubricsBlockField->save();

                            break;
                        }
                    }
                }
            }
        }

        return $isSaved;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(ParserLrpartsRubrics::class, ['parent_id' => 'id',])->where(['is_active' => true,])->orderBy(['sort_field' => SORT_ASC,]);
    }

    /**
     * @return string
     */
    public function getRubricTitle() : string
    {
        return !empty($this->title) ? $this->title : $this->name;
    }

    /**
     * @return string
     */
    public function getUrl() : string
    {
        return \Yii::$app->params['frontendUrl'].'/epc/'.$this->id;
    }
}
