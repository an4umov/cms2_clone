<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "galleries_files".
 *
 * @property int $id
 * @property int $gallery_id
 * @property int $file_id
 *
 * @property File $file
 * @property Gallery $gallery
 */
class GalleriesFiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'galleries_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gallery_id', 'file_id'], 'default', 'value' => null],
            [['gallery_id', 'file_id'], 'integer'],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['file_id' => 'id']],
            [['gallery_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gallery::class, 'targetAttribute' => ['gallery_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gallery_id' => 'Gallery ID',
            'file_id' => 'File ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGallery()
    {
        return $this->hasOne(Gallery::className(), ['id' => 'gallery_id']);
    }
}
