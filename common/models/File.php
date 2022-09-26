<?php

namespace common\models;

use core\FileAccessInterface;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property string $title
 * @property string $name
 * @property string $path
 * @property string $description
 * @property string $img_alt
 * @property int $updated_at
 * @property int $created_at
 *
 * @property GalleriesFiles[] $galleriesFiles
 */
class File extends \yii\db\ActiveRecord implements FileAccessInterface
{
    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['title', 'name', 'path'], 'string', 'max' => 255],
            [['description', 'img_alt'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'name' => 'Name',
            'path' => 'Path',
            'description' => 'Description',
            'img_alt' => 'Img Alt',
            'created_at' => 'Date Create',
            'updated_at' => 'Date Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGalleriesFiles()
    {
        return $this->hasMany(GalleriesFiles::class, ['file_id' => 'id']);
    }

    public function getFullPath()
    {
        return '';
    }
}
