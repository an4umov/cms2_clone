<?php

namespace common\models;

use frontend\behaviors\ContentServiceAttributes;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "material".
 *
 * @property int $id
 * @property string $title
 * @property string $alias
 * @property string $content
 * @property int $type_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $parentId
 *
 * @property MenuMaterial[] $menuMaterials
 * @property Menu[] $menus
 * @property TagMaterial[] $tagMaterials
 * @property Tag[] $tags
 * @property string $preview
 * @property int $is_main [smallint]
 */
class Material extends \yii\db\ActiveRecord
{

    public $materialPreview;
    public $readMoreText;
    private $readmoreLength = 200;

    const TYPE_NEWS = 1;
    const TYPE_ARTICLE = 2;
    const TYPE_ACTION = 3;

    const STATUS_PUBLISHED = 1;
    const STATUS_UNPUBLISHED = 0;

    public static $types = [
        self::TYPE_ACTION => 'Акция',
        self::TYPE_ARTICLE => 'Статья',
        self::TYPE_NEWS => 'Новость'
    ];

    public static $statuses = [
        self::STATUS_PUBLISHED => 'Опубликован',
        self::STATUS_UNPUBLISHED => 'Не опубликован'
    ];

    public $parentId;

    /**
     * @return array
     */
    public static function getStatuses()
    {
        return self::$statuses;
    }

    /**
     * @param $statusId
     * @return mixed
     */
    public static function getStatus($statusId)
    {
        return self::$statuses[$statusId];
    }

    public $materialTags = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'material';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class
            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'slugAttribute' => 'alias',
            ],
            'slug' => [
                'class' => 'common\behaviors\Slug',
                'in_attribute' => 'title',
                'out_attribute' => 'alias',
                'translit' => true
            ],
//            [
//                'class' => ContentServiceAttributes::class,
//                'property' => 'content'
//            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'/*, 'alias'*/], 'required'],
            [['content', 'preview'], 'string'],
            ['materialTags', 'each', 'rule' => ['string']],
            [['type_id', 'status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['type_id', 'status', 'created_at', 'updated_at', 'is_main'], 'integer'],
            [['title', 'alias'], 'string', 'max' => 256],
            [['alias'], 'unique'],
            [['materialPreview'], 'file']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'alias' => 'Алиас',
            'content' => 'Контент',
            'type_id' => 'Тип',
            'status' => 'Опубликован',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'materialTags' => 'Теги',
            'preview' => 'Изображение превью',
            'materialPreview' => 'Загрузить изображение',
            'is_main' => 'Вывести на главной странице'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['id' => 'menu_id'])->viaTable('menu_material', ['material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('tag_material', ['material_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\MaterialQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\MaterialQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        return self::$types;
    }

    /**
     * @param $typeId
     * @return mixed
     */
    public static function getType($typeId)
    {
        return self::$types[$typeId];
    }

    public function afterFind()
    {
        $this->materialTags = ArrayHelper::map($this->tags, 'name', 'name');

        $string = strip_tags($this->content);
        if (strlen($string) > $this->readmoreLength) {
            $stringCut = substr($string, 0, $this->readmoreLength);
            $endPoint = strrpos($stringCut, ' ');
            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $this->readMoreText = $string;
        }

        parent::afterFind();
    }

    /**
     * @param $parentId
     * @return string
     */
    public function frontUrl($parentId)
    {
        $parent = Menu::findOne(['id' => intval($parentId)]);

        if (!empty($parent)) {
            $parents = array_merge($parent->parents()->all(), [$parent]);

            $urlAttributes = [];
            foreach ($parents as $item) {
                $urlAttributes[] = $item->alias;
            }
            $urlAttributes[] = $this->alias;
            return Yii::$app->params['frontendUrl'] . "/" . implode('/', $urlAttributes);
        }

        return "";
    }
}
