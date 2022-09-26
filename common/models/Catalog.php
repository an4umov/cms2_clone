<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\mssql\PDO;

/**
 * This is the model class for table "catalog".
 *
 * @property int    $id
 * @property int    $level
 * @property int    $is_product
 * @property string $parent_code
 * @property int    $order
 * @property string $code
 * @property string $name
 * @property string $full_name
 * @property string $description
 * @property string $title
 * @property string $tags
 * @property string $article
 * @property boolean $is_department
 * @property string $copy_of
 * @property string $link_anchor
 * @property string $link_tag
 * @property string $tag_for_link
 * @property int    $created_at
 * @property int    $updated_at
 *
 * @property Articles[] $articles
 */
class Catalog extends \yii\db\ActiveRecord
{
    const IS_PRODUCT_YES = 1;
    const IS_PRODUCT_NO = 0;
    const IS_PRODUCTS = [self::IS_PRODUCT_YES, self::IS_PRODUCT_NO,];

    const TREE_LEVEL_FIRST = 'first';
    const TREE_LEVEL_SECOND = 'second';
    const TREE_LEVEL_THIRD = 'third';
    const TREE_LEVEL_FOURTH = 'fourth';
    const TREE_LEVEL_FIFTH = 'fifth';
    const TREE_LEVELS = [self::TREE_LEVEL_FIRST, self::TREE_LEVEL_SECOND, self::TREE_LEVEL_THIRD, self::TREE_LEVEL_FOURTH, self::TREE_LEVEL_FIFTH,];

    const TREE_ITEM_PARENT = 'parent';
    const TREE_ITEM_CHILDREN = 'children';
    const TREE_ITEM_CHILDREN_GROUP_COUNT = 'group_count';

    const CARS_CODE = 'KAT0020412';
    const FREIGHT_CODE = 'KAT0020413';
    const ITEM_GROUPS_CODE = 'KAT0020410';
    const ITEM_MODELS_CODE = 'KAT0020411';

    const LEVEL_0 = 0;
    const LEVEL_1 = 1;
    const LEVEL_2 = 2;
    const LEVEL_3 = 3;
    const LEVEL_4 = 4;
    const LEVEL_5 = 5;
    const LEVEL_6 = 6;
    const LEVEL_7 = 7;
    const LEVELS = [self::LEVEL_0, self::LEVEL_1, self::LEVEL_2, self::LEVEL_3, self::LEVEL_4, self::LEVEL_5, self::LEVEL_6, self::LEVEL_7,];

    const IMAGES_DIR1 = 'katalog1';
    const IMAGES_SPECIAL_OFFER = 'special_offer';
    const IMAGES_DIR4 = 'content'.DIRECTORY_SEPARATOR.'category_titles';
    const IMAGES_DIR_LR = 'lr';
    const IMAGES_DIR_POST = 'post';
    const IMAGE_SEPARATOR = '__';
    const TITLE = 'Каталог';

    const IMAGE_NOT_AVAILABLE = 'not-available.png';
    const IMAGE_NOT_AVAILABLE_180 = 'not-available-180.png';
    const IMAGE_NOT_AVAILABLE_BIG = 'not-available-big.png';

    public $tabClass;

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
        return 'catalog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['level', 'is_product', 'order', 'created_at', 'updated_at',],
                'default',
                'value' => null,
            ],

            ['is_product', 'in', 'range' => self::IS_PRODUCTS,],
            [['code'], 'unique'],

            [['level', 'is_product', 'order', 'created_at', 'updated_at',], 'integer',],
            [['is_product', 'order', 'name'], 'required',],
            [['description', 'copy_of', 'link_anchor', 'link_tag', 'tag_for_link',], 'string',],
            [['is_department',], 'boolean'],
            [['is_department',], 'default', 'value' => false,],
            [['parent_code', 'code', 'name', 'full_name', 'title', 'tags', 'article'], 'string', 'max' => 255,],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => 'Уровень иерархии',
            'is_product' => 'Индикатор товара',
            'parent_code' => 'Код раздела родителя',
            'order' => 'Сортировка',
            'code' => 'Код',
            'name' => 'Имя',
            'full_name' => 'Полное имя',
            'description' => 'Описание',
            'title' => 'Название для страницы',
            'tags' => 'Метки',
            'article' => 'Артикул',
            'is_department' => 'Департамент',
            'copy_of' => 'Копия раздела',
            'link_anchor' => 'Ссылка на раздел якоря',
            'link_tag' => 'Ссылка на тег',
            'tag_for_link' => 'Содержит тег',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Articles::class, ['article' => 'number',]);
    }

//    public function getSameArticleCategories()
//    {
//        if (!$this->article) {
//            return [];
//        }
//
//        $article = $this->article;
//        $id = $this->id;
//
//
//            $rows[$k]['p1_url'] = Catalog::findOne([
//                'condition' => 'id = :id',
//                'params' => [
//                    ':id' => $v['p1_id'],
//                ],
//            ])->makeCorrectUrl();
//        }
//
//        return $rows;
//    }

    /**
     * Формирует "корректный" URL для данного узла ИМ
     * @return mixed
     */
    public function makeCorrectUrl()
    {
        $urlManager = Yii::$app->urlManager;
        switch ($this->level) {
            case 1:
            case 2:
                $url = $urlManager->createUrl(['/shop/view/index', ['parent' => $this->parent_code,],]);
                break;
            case 3:
            case 4:
                $url = $urlManager->createUrl(['/shop/view/byModel', ['url' => $this->code,],]);
                break;
            case 5:
            case 6:
                $url = $urlManager->createUrl(['/shop/view/article', ['code' => $this->parent_code,],]);
                break;
            default: // для товара, преимущественно.
                $url = $urlManager->createUrl(['/shop/view/product', ['catalogUrl' => $this->code,],]);
                break;
        }

        return $url;
    }
}
