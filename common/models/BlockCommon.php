<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the parent model class for table "block" & "block_ready".
 *
 * @property int            $id
 * @property string         $name
 * @property string         $description
 * @property string         $type
 * @property string         $global_type
 * @property bool           $is_active
 * @property string         $data JSON
 * @property integer        $block_id
 * @property int            $created_at
 * @property int            $updated_at
 * @property int            $deleted_at
 *
 * @property BlockField[]   $blockFields
 * @property BlockReadyField[] $blockReadyFields
 * @property ContentBlock[] $contentBlocks
 * @property Content[]      $contents
 */
class BlockCommon extends \yii\db\ActiveRecord
{
//    public $id;
//    public $name;
//    public $description;
//    public $type;
//    public $global_type;
//    public $is_active;
//    public $data;
    public $content_block_id;
    public $content_block_type;
    public $content_block_sort;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'block';
    }
}
