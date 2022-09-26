<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "catalog_tree_setting".
 *
 * @property int $id
 * @property int $row_count_desktop
 * @property int $row_count_laptop
 * @property int $row_count_mobile
 * @property int $header_font_size
 * @property int $grid_height
 * @property int $created_at
 * @property int $updated_at
 */
class CatalogTreeSetting extends \yii\db\ActiveRecord
{
    const DEFAULT_ROW_COUNT_DESKTOP = 6;
    const DEFAULT_ROW_COUNT_LAPTOP = 4;
    const DEFAULT_ROW_COUNT_MOBILE = 3;
    const DEFAULT_HEADER_FONT_SIZE = 22;
    const DEFAULT_GRID_HEIGHT = 206;

    const ROW_COUNT = [self::DEFAULT_ROW_COUNT_MOBILE, self::DEFAULT_ROW_COUNT_LAPTOP, self::DEFAULT_ROW_COUNT_DESKTOP,];

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
        return 'catalog_tree_setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['row_count_desktop', 'row_count_laptop', 'row_count_mobile', 'header_font_size', 'grid_height'], 'required'],
            [['row_count_desktop', 'row_count_laptop', 'row_count_mobile',], 'in', 'range' => self::ROW_COUNT,],
            [['header_font_size', 'grid_height', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['row_count_desktop', 'row_count_laptop', 'row_count_mobile', 'header_font_size', 'grid_height', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'row_count_desktop' => 'Количество плиток для десктопа',
            'row_count_laptop' => 'Количество плиток для планшета',
            'row_count_mobile' => 'Количество плиток для мобильного',
            'header_font_size' => 'Высота заголовка (px)',
            'grid_height' => 'Высота плитки (px)',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
        ];
    }

    /**
     * @return array
     */
    public function getRowCountOptions() : array
    {
        $options = [];

        foreach (self::ROW_COUNT as $count) {
            $options[$count] = $count;
        }

        return $options;
    }

    /**
     * @return string
     */
    public function getRowCountClass() : string
    {
        $class = '';
        switch ($this->row_count_desktop) {
            case self::DEFAULT_ROW_COUNT_DESKTOP:
                $class = 'col-6 col-sm-6 col-md-3 col-lg-2 col-xl-2';
                break;
            case self::DEFAULT_ROW_COUNT_LAPTOP:
                $class = 'col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3';
                break;
            case self::DEFAULT_ROW_COUNT_MOBILE:
                $class = 'col-6 col-sm-6 col-md-6 col-lg-4 col-xl-4';
                break;
        }

        return $class;
    }
}
