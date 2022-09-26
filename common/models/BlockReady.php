<?php

namespace common\models;

use common\components\helpers\AppHelper;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "block_ready".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $global_type
 * @property bool $is_active
 * @property string $data JSON
 * @property integer $block_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property BlockReadyField[] $blockReadyFields
 * @property ContentBlock[] $contentBlocks
 * @property Content[]      $contents
 */
class BlockReady extends BlockCommon
{
    public $content_blocks_list;

    /**
     * @param string $type
     *
     * @return string
     */
    public function getTypeTitle(string $type) : string
    {
        return (new Block())->getTypeTitle($type);
    }

    /**
     * @return array
     */
    public function getGlobalTypeOptions() : array
    {
        return (new Block())->getGlobalTypeOptions();
    }

    /**
     * @param string $globalType
     *
     * @return string
     */
    public function getGlobalTypeTitle(string $globalType) : string
    {
        return $this->getGlobalTypeOptions()[$globalType];
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
    public static function tableName()
    {
        return 'block_ready';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'block_id',], 'required'],
            [['description', 'global_type', 'data'], 'string'],
            [['is_active'], 'boolean'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'block_id',], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['content_blocks_list',], 'safe',],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $labels = (new Block())->attributeLabels();
        $labels['block_id'] = $labels['global_type'];
        $labels['is_active'] = 'Активен';

        return $labels;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlockReadyFields()
    {
        return $this->hasMany(BlockReadyField::class, ['block_id' => 'id',]);
    }

    /**
     * @return int
     */
    public function getBlockReadyFieldsCount() : int
    {
        return $this->getBlockReadyFields()->count('*');
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getContentBlocks()
    {
        return $this->hasMany(ContentBlock::class, ['block_id' => 'id',])->where([ContentBlock::tableName().'.type' => ContentBlock::TYPE_BLOCK_READY,]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContents()
    {
        return $this->hasMany(Content::class, ['id' => 'content_id',])
            ->via('contentBlocks');
    }

    /**
     * @return int
     */
    public function getUsedCount() : int
    {
        return $this->getContents()->count();
    }

    /**
     * @return array
     */
    public function getExistsGlobalTypeOptions() : array
    {
        $options = [];
        $globalTypeOptions = (new Block())->getGlobalTypeOptions();
        $rows = Block::find()
            ->select(['id', 'global_type',])
            ->where(['deleted_at' => null,])
            ->asArray()
            ->all();

        foreach ($rows as $row) {
            if (!empty($row['global_type']) && isset($globalTypeOptions[$row['global_type']])) {
                $options[$row['id']] = $globalTypeOptions[$row['global_type']];
            }
        }

        return $options;
    }

    /**
     * @return array
     */
    public function getFilterGlobalTypeOptions() : array
    {
       return (new Block())->getGlobalTypeOptions();
    }

    public function saveModel($runValidation = true, $attributeNames = null)
    {
        $isSaved = false;
        $isNewRecord = $this->isNewRecord;
        if ($block = Block::findOne(['id' => $this->block_id,])) {
            $this->global_type = $block ? $block->global_type : Block::TYPE_TEXT;
            $oldBlockID = $this->getOldAttribute('block_id');

            $data = [];
            if (!empty($this->content_blocks_list) && is_array($this->content_blocks_list)) {
                foreach ($this->content_blocks_list as $contentBlockData) {
                    foreach ($contentBlockData['blocks_list'] as $blockID => $blocksListData) {
                        foreach ($blocksListData['fields'] as $fieldID => $fieldData) {
                            if (is_array($fieldData) && !empty($fieldData[BlockField::TYPE_LIST])) { //список полей
                                $index = 0;
                                foreach ($fieldData[BlockField::TYPE_LIST] as $fieldListData) {
                                    foreach ($fieldListData as $fieldListID => $value) {
                                        $data[$fieldID][$index][$fieldListID] = $value;
                                    }
                                    $index++;
                                }
                            } else { //не список полей
                                $data[$fieldID] = $fieldData;
                            }
                        }
                    }
                }
            }
            $this->setData($data);

            $isSaved = parent::save($runValidation, $attributeNames);
            if ($isSaved && ($isNewRecord || $this->block_id != $oldBlockID)) {
                if (!$isNewRecord) { //очистка предыдущих записей
                    $fields = BlockReadyField::find()->where(['block_id' => $this->block_id,])->asArray()->select('id')->all();

                    if ($fields) {
                        BlockReadyField::deleteAll(['block_id' => $this->block_id,]);
                        foreach ($fields as $field) {
                            BlockReadyFieldList::deleteAll(['field_id' => $field['id'],]);
                            BlockReadyFieldValuesList::deleteAll(['field_id' => $field['id'],]);
                        }
                    }
                }

                $blockFields = BlockField::find()->where(['block_id' => $block->id, 'deleted_at' => null,])->orderBy(['sort' => SORT_ASC,])->asArray()->all();

                foreach ($blockFields as $blockField) {
                    $newBlockReadyField = new BlockReadyField();
                    $newBlockReadyField->setAttributes($blockField);
                    $newBlockReadyField->block_id = $this->id;
                    $newBlockReadyField->save(false);

                    if ($blockField['type'] == BlockField::TYPE_LIST) {
                        $blockFieldLists = BlockFieldList::find()->where(['field_id' => $blockField['id'], 'deleted_at' => null,])->orderBy(['sort' => SORT_ASC,])->asArray()->all();

                        foreach ($blockFieldLists as $blockFieldList) {
                            $newBlockReadyFieldList = new BlockReadyFieldList();
                            $newBlockReadyFieldList->setAttributes($blockFieldList);
                            $newBlockReadyFieldList->field_id = $newBlockReadyField->id;
                            $newBlockReadyFieldList->save(false);
                        }
                    } elseif ($blockField['type'] == BlockField::TYPE_VALUES_LIST) {
                        $blockFieldValuesList = BlockFieldValuesList::find()->where(['field_id' => $blockField['id'], 'deleted_at' => null,])->orderBy(['sort' => SORT_ASC,])->asArray()->all();

                        foreach ($blockFieldValuesList as $blockFieldValuesListItem) {
                            $newBlockReadyFieldValuesList = new BlockReadyFieldValuesList();
                            $newBlockReadyFieldValuesList->setAttributes($blockFieldValuesListItem);
                            $newBlockReadyFieldValuesList->field_id = $newBlockReadyField->id;
                            $newBlockReadyFieldValuesList->save(false);
                        }
                    }
                }
            }
        }

        return $isSaved;
    }

    public function getBlockData() : array
    {
        $blockReadyQuery = BlockReady::find()
            ->select([
                BlockReady::tableName().'.id',
                BlockReady::tableName().'.name',
                BlockReady::tableName().'.description',
                BlockReady::tableName().'.data',
                ContentBlock::tableName().'.id AS content_block_id',
                ContentBlock::tableName().'.type AS content_block_type',
            ])
            ->leftJoin(
                ContentBlock::tableName(),
                ContentBlock::tableName().'.block_id = '.BlockReady::tableName().'.id AND '.ContentBlock::tableName().'.type = :type AND '.ContentBlock::tableName().'.content_id = :id',
                [':type' => ContentBlock::TYPE_BLOCK_READY, ':id' => $this->id,]
            )
            ->where([
                BlockReady::tableName().'.id' => $this->id,
            ])
            ->asArray();

        $row = $blockReadyQuery->one();

        if (empty($row['content_block_id'])) {
            $row['content_block_id'] = 0;
        }
        if (empty($row['content_block_type'])) {
            $row['content_block_type'] = ContentBlock::TYPE_BLOCK_READY;
        }
        $row['type'] = ContentBlock::TYPE_BLOCK_READY;

        return $row;
    }

    /**
     * @return array
     */
    public function getData() : array
    {
        return !empty($this->data) ? Json::decode($this->data) : [];
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = Json::encode($data);
    }

    /**
     * @param string $data
     */
    public function setRawData(string $data)
    {
        $this->data = $data;
    }
}
