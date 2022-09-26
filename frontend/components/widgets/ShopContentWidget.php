<?php

namespace frontend\components\widgets;

use common\components\helpers\CatalogHelper;
use common\components\helpers\DepartmentHelper;
use common\models\Catalog;
use common\models\Content;
use common\models\Department;
use common\models\DepartmentMenu;
use frontend\models\search\CatalogTreeSearch;
use yii\base\Widget;
use yii\web\NotFoundHttpException;

class ShopContentWidget extends Widget
{
    const PAGE_TITLE_HIDDEN_ID = 'page-title-hidden';

    public $filter; // array

    /**
     * @var $department Department
     */
    public $department; // Department
    public $carModelID; // int
    public $departmentMenu; // string
    public $departmentMenuTag; // string
    public $catalogCode; // string
    public $pjaxId; // string
    public $group; // string

    public function init()
    {
        parent::init();

        if (is_null($this->filter)) {
            $this->filter = [];
        }

        $this->filter['department_id'] = 0;
        $this->filter['model_id'] = 0;
        $this->filter['menu_id'] = 0;
        $this->filter['tag_id'] = 0;
        $this->filter['content_id'] = 0;
    }

    public function run()
    {
        $modelMenu = null;
        if (!empty($this->department)) {
            if (!empty($this->department->landing_page_id)) {
                $this->filter['content_id'] = $this->department->landing_page_id;
            }
            if (!empty($this->department->id)) {
                $this->filter['department_id'] = (int) $this->department->id;
            }
        }

        if (!empty($this->carModelID)) {
            $this->filter['model_id'] = (int) $this->carModelID;
        }

        $modelMenu = null;
        if (!empty($this->filter['department_id']) && !empty($this->departmentMenu)) {
            $modelMenu = DepartmentHelper::getDepartmentMenuByUrl($this->filter['department_id'], $this->departmentMenu);

            $this->filter['menu_id'] = (int) $modelMenu->id;
        }

        if (!empty($this->filter['menu_id']) && !empty($this->departmentMenuTag)) {
            $modelMenuTag = DepartmentHelper::getDepartmentMenuTagByUrl($this->filter['menu_id'], $this->departmentMenuTag);

            if (empty($modelMenuTag->landing_page_id)) {
                throw new NotFoundHttpException('Не указана посадочная страница для тематики');
            }

            $this->filter['tag_id'] = (int) $modelMenuTag->id;
            $this->filter['content_id'] = $modelMenuTag->landing_page_id;
        } elseif (!empty($modelMenu) && empty($this->catalogCode)) {
            switch ($modelMenu->landing_page_type) {
                case DepartmentMenu::LANDING_PAGE_TYPE_CATALOG:
                    if (!empty($modelMenu->is_all_products)) {
                        if (!empty($this->department->catalog_code)) {
                            $this->filter['content_code'] = $this->department->catalog_code;
                        } else {
                            throw new NotFoundHttpException('Не указан код для департамента');
                        }
                    } else {
                        if (empty($modelMenu->landing_page_catalog)) {
                            throw new NotFoundHttpException('Не указана посадочная страница для меню');
                        }
                        $this->filter['content_code'] = $modelMenu->landing_page_catalog;
                    }

                    break;
                case DepartmentMenu::LANDING_PAGE_TYPE_PAGE:
                    if (empty($modelMenu->landing_page_id)) {
                        throw new NotFoundHttpException('Не указана посадочная страница для меню');
                    }
                    $this->filter['content_id'] = $modelMenu->landing_page_id;

                    break;
                default:
                    throw new NotFoundHttpException('Не настроено меню');

                    break;
            }

            $this->filter['menu_id'] = (int) $modelMenu->id;
        }

        if (!empty($this->catalogCode)) {
            $this->filter['content_code'] = $this->catalogCode;
        }


/*
        $contentFilterType = ContentFilter::TYPE_DEPARTMENT;
        $contentFilterListID = $this->filter['department_id'];
        $tableName = Department::tableName();
        if (!empty($this->filter['tag_id'])) {
            $contentFilterType = ContentFilter::TYPE_TAG;
            $contentFilterListID = $this->filter['tag_id'];
            $tableName = DepartmentMenuTag::tableName();
        } elseif (!empty($this->filter['menu_id'])) {
            $contentFilterType = ContentFilter::TYPE_MENU;
            $contentFilterListID = $this->filter['menu_id'];
            $tableName = DepartmentMenu::tableName();
//        } elseif (!empty($this->filter['model_id'])) {
//            $contentFilterType = ContentFilter::TYPE_MODEL;
//            $contentFilterListID = $this->filter['model_id'];
//            $tableName = CarModel::tableName();
        }

        $contentID = Content::find()
            ->select([Content::tableName().'.id',])
            ->innerJoin($tableName, $tableName.'.landing_page_id = '.Content::tableName().'.id')
            ->where([
                Content::tableName() . '.type' => Content::TYPE_PAGE,
                Content::tableName() . '.deleted_at' => null,
                $tableName . '.is_active' => true,
            ])->scalar();

        if ($contentID) {
            $this->filter['content_id'] = $contentID;
        }

        $contentID = 0;

        if (!empty($this->filter['model_id'])) {
            $contentIDs = Content::find()
                ->select([Content::tableName().'.id',])
                ->innerJoin(ContentFilterCarModel::tableName(), ContentFilterCarModel::tableName().'.content_id = '.Content::tableName().'.id')
                ->where([
                    Content::tableName() . '.type' => [Content::TYPE_NEWS, Content::TYPE_ARTICLE,],
                    Content::tableName() . '.deleted_at' => null,
                    ContentFilterCarModel::tableName() . '.car_model_id' => $this->filter['model_id'],
                ])->column();

            if ($contentIDs) {
                if ($contentID) {
                    $this->filter['content_id'] = array_merge([$contentID,], $contentIDs);
                } else {
                    $this->filter['content_id'] = $contentIDs;
                }
            }
        }
        */
/*
        if (empty($this->filter['tag_id']) && empty($this->filter['model_id']) && $this->departmentModelMenu) {
            $tags = DepartmentMenuTag::find()->select([
                    DepartmentMenuTag::tableName().'.id',
                ])
                ->innerJoin(DepartmentMenuTag::tableName(), DepartmentMenuTag::tableName().'.department_menu_tag_id = '.DepartmentMenuTag::tableName().'.id')
                ->innerJoin(DepartmentMenu::tableName(), DepartmentMenuTag::tableName().'.department_menu_id = '.DepartmentMenu::tableName().'.id')
                ->innerJoin(Department::tableName(), DepartmentMenu::tableName().'.department_id = '.Department::tableName().'.id')
                ->where([
                    DepartmentMenuTag::tableName().'.is_active' => true,
                    DepartmentMenu::tableName().'.is_active' => true,
                    Department::tableName().'.is_active' => true,
                    DepartmentMenu::tableName().'.id' => $this->departmentModelMenu->id,
                ])
                ->orderBy([DepartmentMenuTag::tableName() . '.department_menu_tag_id' => SORT_ASC, DepartmentMenuTag::tableName() . '.sort' => SORT_ASC,])
                ->asArray()->column();

            if ($tags) {
                $contentTagIDs = ContentFilter::find()
                    ->select([ContentFilter::tableName() . '.content_id',])->distinct(true)
                    ->innerJoin(Content::tableName(),
                        Content::tableName() . '.id = ' . ContentFilter::tableName() . '.content_id')
                    ->where([
                        ContentFilter::tableName() . '.type' => ContentFilter::TYPE_TAG,
                        ContentFilter::tableName() . '.list_id' => $tags,
                        Content::tableName() . '.type' => [Content::TYPE_ARTICLE, Content::TYPE_NEWS,],
                        Content::tableName() . '.deleted_at' => null,
                    ])->asArray()
                    ->column();

                $this->filter['content_ids'] = $contentTagIDs;
            }

            $models = DepartmentModelList::find()->select([
                    DepartmentModelList::tableName().'.id',
                ])
                ->innerJoin(DepartmentModel::tableName(), DepartmentModelList::tableName().'.department_model_id = '.DepartmentModel::tableName().'.id')
                ->innerJoin(Department::tableName(), DepartmentModel::tableName().'.department_id = '.Department::tableName().'.id')
                ->where([
                    DepartmentModelList::tableName().'.is_active' => true,
                    Department::tableName().'.is_active' => true,
                    Department::tableName().'.id' => $this->departmentModelMenu->department_model_id,
                ])
                ->orderBy([DepartmentModelList::tableName() . '.sort' => SORT_ASC,])
                ->asArray()->column();

            if ($models) {
                $contentModelIDs = ContentFilter::find()
                    ->select([ContentFilter::tableName().'.content_id',])->distinct(true)
                    ->innerJoin(Content::tableName(), Content::tableName().'.id = '.ContentFilter::tableName().'.content_id')
                    ->where([
                        ContentFilter::tableName().'.type' => ContentFilter::TYPE_MODEL,
                        ContentFilter::tableName().'.list_id' => $models,
                        Content::tableName().'.type' => [Content::TYPE_ARTICLE, Content::TYPE_NEWS,],
                        Content::tableName().'.deleted_at' => null,])->asArray()
                    ->column();

                $this->filter['content_ids'] = array_unique(ArrayHelper::merge($this->filter['content_ids'], $contentModelIDs));
            }
        }
*/
        if (!empty($this->filter['content_code'])) {
            $oldModel = null;
            $model = CatalogHelper::getCatalogModelByCode($this->filter['content_code']);

            // Раздел "Копия - Мастер"
//            if (!empty($model->copy_of)) {
//                $oldModel = clone $model;
//                $model = CatalogHelper::getCatalogModelByCode($model->copy_of);
//            }

            $topLevelModelData = (new CatalogTreeSearch())->findTopLevelModel($model);

//                    echo '<pre>';print_r($topLevelModelData);exit;

            if (!empty($topLevelModelData['model'])) {
                $treeModel = $model;
                $isFinalItem = Catalog::find()->where(['parent_code' => $this->filter['content_code'], 'is_product' => Catalog::IS_PRODUCT_YES,])->exists();
                    if ($isFinalItem) {
                    $departmentTreeItem = Catalog::find()->where(['code' => $topLevelModelData['codes'], 'is_department' => true,])->one();

                    if ($departmentTreeItem) {
                        $treeModel = $departmentTreeItem;
                    }
                }

                $tree = CatalogHelper::getCatalogTreeData($treeModel);

                if ($oldModel) {
                    $tree[Catalog::TREE_LEVEL_FIRST][Catalog::TREE_ITEM_PARENT] = $oldModel->attributes;
                }

                // Подсчет кол-ва "разделы-цели" для "ссылка-цель"
                if (!empty($this->group)) {
                    $structureData = CatalogHelper::getCatalogStructureData();
                    if (isset($structureData[$this->group])) {
                        $groupTitle = isset($structureData[$this->group]) ? $structureData[$this->group]['link_tag'] : '';
                        if (!empty($groupTitle)) {
                            $trees = [Catalog::CARS_CODE => $tree,];
                            CatalogHelper::calculateTagForLink($trees, $groupTitle);
                            $tree = $trees[Catalog::CARS_CODE];
                            unset($trees);
                        }
                    }
                }
            } else {
                throw new NotFoundHttpException('Код указан не верно');
            }

            $isArticles = false;

            return $this->render('//catalog/view', [
                'tree' => $tree,
                'isTree' => false,
                'model' => $model,
                'isArticles' => $isArticles,
                'isFinalItem' => $isFinalItem,
                'activeCode' => $this->filter['content_code'],
                'codes' => $topLevelModelData['codes'],
                'filter' => [
                    'stock' => false,
                ],
                'baseUrlRoute' => [
                    'department' => $this->department,
                    'departmentMenu' => $this->departmentMenu,
                    'departmentMenuTag' => $this->departmentMenuTag,
                ],
                'rubricTitles' => CatalogHelper::getRubricTitles($tree, $this->filter['content_code']),
            ]);
        } else {
            if (!empty($this->filter['type'])) {
                $pageIndexType = '';
                switch ($this->filter['type']) {
                    case Content::TYPE_PAGE:
                        $pageIndexType = Content::PAGE_INDEX_TYPE_PAGES;
                        break;
                    case Content::TYPE_NEWS:
                        $pageIndexType = Content::PAGE_INDEX_TYPE_NEWS;
                        break;
                    case Content::TYPE_ARTICLE:
                        $pageIndexType = Content::PAGE_INDEX_TYPE_ARTICLES;
                        break;
                }

                if ($pageIndexType) {
                    $query = Content::find();
                    $query->where(['deleted_at' => null, 'type' => Content::TYPE_PAGE, 'page_index_type' => $pageIndexType,]);
                    $pageModel = $query->one();

                    if ($pageModel) {
                        $pageModel->incViewsCount();

                        return \frontend\components\widgets\ContentWidget::widget(['model' => $pageModel, 'department' => $this->department, 'isPage' => true, 'custom_tag_id' => null,]);
                    }
                }
            } else {
                $query = Content::find();
                $query->where(['deleted_at' => null, 'id' => $this->filter['content_id'], 'type' => Content::TYPE_PAGE,]);
                $pageModel = $query->one();

                if ($pageModel) {
                    $pageModel->incViewsCount();

                    return \frontend\components\widgets\ContentWidget::widget(['model' => $pageModel, 'department' => $this->department, 'isPage' => true, 'custom_tag_id' => null,]);
                }
            }
        }

        throw new NotFoundHttpException('Страница контента не найдена');
    }
}
