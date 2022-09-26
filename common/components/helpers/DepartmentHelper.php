<?php
namespace common\components\helpers;


use common\models\CarModel;
use common\models\Catalog;
use common\models\Content;
use common\models\ContentFilter;
use common\models\Department;
use common\models\DepartmentMenu;
use common\models\DepartmentMenuTag;
use common\models\DepartmentMenuTagList;
use common\models\DepartmentModel;
use common\models\DepartmentModelList;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

class DepartmentHelper
{
    const TREE_ITEM_TYPE_ITEM = 'item';
    const TREE_ITEM_TYPE_FOLDER = 'folder';

    const TYPE_ROOT = 'root';
    const TYPE_GROUPS = 'groups';
    const TYPE_MODELS = 'models';
    const TYPE_OTHERS = 'others';
    const TYPE_DEPARTMENT = 'department';
    const TYPE_MODEL = 'model';
    const TYPE_MENU = 'menu';
    const TYPE_MENU_TAG = 'menu_tag';

    const DEPARTMENT_MENU_ITEMS_TITLE = 'Товары раздела';
    const DEPARTMENT_MENU_ITEMS_URL = 'shop';

    /**
     * @param string $url
     *
     * @return Department
     * @throws NotFoundHttpException
     */
    public static function getDepartmentByUrl(string $url) : Department
    {
        $model = Department::findOne(['url' => $url, 'is_active' => true,]);

        if ($model) {
            return $model;
        }

        throw new NotFoundHttpException('Сайт не найден по УРЛ '.$url);
    }

    /**
     * @param int    $departmentID
     * @param string $url
     *
     * @return DepartmentMenu
     * @throws NotFoundHttpException
     */
    public static function getDepartmentMenuByUrl(int $departmentID, string $url) : DepartmentMenu
    {
        if ($model = DepartmentMenu::find()->where(['department_id' => $departmentID, 'is_active' => true, 'url' => $url,])->one()) {
            return $model;
        }

        throw new NotFoundHttpException('Пункт меню '.$url.' не найден по УРЛ');
    }

    /**
     * @param int    $departmentMenuID
     * @param string $url
     *
     * @return DepartmentMenuTag
     * @throws NotFoundHttpException
     */
    public static function getDepartmentMenuTagByUrl(int $departmentMenuID, string $url) : DepartmentMenuTag
    {
        if ($model = DepartmentMenuTag::find()->where(['department_menu_id' => $departmentMenuID, 'is_active' => true, 'url' => $url,])->one()) {
            return $model;
        }

        throw new NotFoundHttpException('Пункт меню '.$url.' не найден по УРЛ');
    }

    public static function getCarModelByID(int $id) : array
    {
        $query = CarModel::find();
        $query->where(['id' => $id,]);
        $query->asArray(true);

        if ($row = $query->one()) {
            return $row;
        }

        throw new NotFoundHttpException('Модель не найдена по ID: '.$id);
    }

    /**
     * @param int    $departmentID
     * @param string $url
     *
     * @return array
     * @throws NotFoundHttpException
     */
    public static function getDepartmentModelByUrl(int $departmentID, string $url) : array
    {
        return []; //@TODO переделать на новую таблицу моделей


        $query = DepartmentModel::find();
        $query->select(['id', 'word_1', 'word_2', 'url', 'image',]);
        $query->where(['department_id' => $departmentID, 'is_active' => true, 'url' => $url,]);
        $query->asArray(true);

        if ($row = $query->one()) {
            $row['name'] = $row['word_1'] . ($row['word_2'] ? ' '.$row['word_2'] : '');

            return $row;
        }

        throw new NotFoundHttpException('Модель '.$url.' не найдена по УРЛ');
    }

    /**
     * @param DepartmentMenu|null $departmentMenu
     * @param int                 $active_model_id
     *
     * @return array
     */
    public static function getDepartmentMenuTagList(DepartmentMenu $departmentMenu = null, int $active_model_id = 0) : array
    {
        $defaultMenuItem = [
            'id' => 0,
            'name' => $departmentMenu ? $departmentMenu->name : DepartmentMenu::DEFAULT_TITLE,
            'url' => '',
            'icon' => '',
            'department_menu_tag_id' => 0,
        ];

        if ($departmentMenu) {
            $query = DepartmentMenuTagList::find();
            $query->select([DepartmentMenuTagList::tableName().'.id', DepartmentMenuTagList::tableName().'.name', DepartmentMenuTagList::tableName().'.url', DepartmentMenuTagList::tableName().'.icon', DepartmentMenuTagList::tableName().'.department_menu_tag_id',]);
            $query->innerJoin(
                DepartmentMenuTag::tableName(),
                DepartmentMenuTagList::tableName().'.department_menu_tag_id = '.DepartmentMenuTag::tableName().'.id'
            );
            $query->where([DepartmentMenuTag::tableName().'.department_menu_id' => $departmentMenu->id, DepartmentMenuTag::tableName().'.is_active' => true, DepartmentMenuTagList::tableName().'.is_active' => true,]);
            $query->orderBy([DepartmentMenuTagList::tableName().'.sort' => SORT_ASC,]);
            $query->asArray(true);

            if (!empty($active_model_id)) {
                $query->innerJoin(ContentFilter::tableName(), DepartmentMenuTagList::tableName().'.id = '.ContentFilter::tableName().'.list_id AND '.ContentFilter::tableName().'.type = :type1', [':type1' => ContentFilter::TYPE_TAG,]);
                $query->innerJoin(ContentFilter::tableName().' AS cfm', ContentFilter::tableName().'.content_id = cfm.content_id AND cfm.type = :type2', [':type2' => ContentFilter::TYPE_MODEL,]);
                $query->andWhere(['cfm.list_id' => $active_model_id,]);
            }
            $query->indexBy('id');
            $query->groupBy(DepartmentMenuTagList::tableName().'.id');
            $rows = $query->all();

            return ArrayHelper::merge([$defaultMenuItem,], $rows);
        }

        return [$defaultMenuItem,];
    }

    /**
     * @return array
     */
    public static function getCarModels() : array
    {
        return CarModel::find()->orderBy(['name' => SORT_ASC,])->all();
    }

    /**
     * @return array
     */
    public static function getCarModelOptions() : array
    {
        $options = $models = $generations = $configurations = $complectations = [];

        $brands = CarModel::find()->select(['id', 'name'])->where(['level' => CarModel::LEVEL_BRAND,])->orderBy(['name' => SORT_ASC,])->asArray()->all();

        $list = CarModel::find()->select(['id', 'name', 'parent_id',])->where(['level' => CarModel::LEVEL_MODEL,])->orderBy(['name' => SORT_ASC,])->asArray()->all();
        foreach ($list as $item) {
            $models[$item['parent_id']][$item['id']] = $item['name'];
        }
        $list = CarModel::find()->select(['id', 'name', 'parent_id',])->where(['level' => CarModel::LEVEL_GENERATION,])->orderBy(['parent_id' => SORT_ASC, 'name' => SORT_ASC,])->asArray()->all();
        foreach ($list as $item) {
            $generations[$item['parent_id']][$item['id']] = $item['name'];
        }
        $list = CarModel::find()->select(['id', 'name', 'parent_id',])->where(['level' => CarModel::LEVEL_CONFIGURATION,])->orderBy(['parent_id' => SORT_ASC, 'name' => SORT_ASC,])->asArray()->all();
        foreach ($list as $item) {
            $configurations[$item['parent_id']][$item['id']] = $item['name'];
        }

        foreach ($brands as $brand) {
            if (!empty($models[$brand['id']])) {
                foreach ($models[$brand['id']] as $modelID => $modelName) {
                    if (!empty($generations[$modelID])) {
                        foreach ($generations[$modelID] as $generationID => $generationName) {
                            if (!empty($configurations[$generationID])) {
                                foreach ($configurations[$generationID] as $configurationID => $configurationName) {
                                    $options[$configurationID] = $brand['name'].' '.$modelName.' '.$generationName.' '.$configurationName;
                                }
                            } else {
                                $options[$generationID] = $brand['name'].' '.$modelName.' '.$generationName;
                            }
                        }
                    } else {
                        $options[$modelID] = $brand['name'].' '.$modelName;
                    }
                }
            } else {
                $options[$brand['id']] = $brand['name'];
            }
        }

        return $options;
    }

    /**
     * @param DepartmentMenu $departmentMenu
     * @param string         $theme
     *
     * @return int|null
     */
    public static function getTagIDByUrl(DepartmentMenu $departmentMenu, string $theme) : ?int
    {
        return DepartmentMenuTagList::find()->select(DepartmentMenuTagList::tableName().'.id')
            ->innerJoin(
                DepartmentMenuTag::tableName(),
                DepartmentMenuTagList::tableName().'.department_menu_tag_id = '.DepartmentMenuTag::tableName().'.id'
            )
            ->where([
                DepartmentMenuTag::tableName().'.department_menu_id' => $departmentMenu->id,
                DepartmentMenuTag::tableName().'.is_active' => true,
                DepartmentMenuTagList::tableName().'.is_active' => true,
                DepartmentMenuTagList::tableName().'.url' => $theme,
            ])->scalar();
    }

    /**
     * @param Department $department
     * @param string     $model
     *
     * @return int|null
     */
    public static function getModelIDByUrl(Department $department, string $model) : ?int
    {
        return 0; //@TODO переделать на новую таблицу моделей

        return DepartmentModelList::find()->select(DepartmentModelList::tableName().'.id')
            ->innerJoin(DepartmentModel::tableName(), DepartmentModelList::tableName().'.department_model_id = '.DepartmentModel::tableName().'.id')
            ->innerJoin(Department::tableName(), DepartmentModel::tableName().'.department_id = '.Department::tableName().'.id')
            ->where([
                Department::tableName().'.id' => $department->id,
                DepartmentModelList::tableName().'.is_active' => true,
                DepartmentModelList::tableName().'.url' => $model,
            ])->scalar();
    }

    /**
     * @param Department|null $model
     * @param int             $oid
     * @param string          $otype
     *
     * @return array
     */
    public static function getDepartmentsTreeData(Department $model = null, int $oid = 0, string $otype = '') : array
    {
        $rootItem = ['name' => 'Структура', 'id' => 0, 'url' => '', 'open' => true, 'type' => self::TYPE_ROOT, Catalog::TREE_ITEM_CHILDREN => [
            self::TYPE_GROUPS => [
                'name' => 'Группы товаров',
                'id' => -1,
                'url' => '',
                'type' => self::TYPE_GROUPS,
                'font' => '',
                Catalog::TREE_ITEM_CHILDREN => [],
            ],
            self::TYPE_MODELS => [
                'name' => 'Модели',
                'id' => -2,
                'url' => '',
                'type' => self::TYPE_MODELS,
                'font' => '',
                Catalog::TREE_ITEM_CHILDREN => [],
            ],
            self::TYPE_OTHERS => [
                'name' => 'Другие',
                'id' => -3,
                'url' => '',
                'type' => self::TYPE_OTHERS,
                'font' => ['color' => '#2684ff',],
                Catalog::TREE_ITEM_CHILDREN => [],
            ],
        ]];

        $others = [];
        $departments = Department::find()->select(['id', 'name', 'is_active', 'landing_page_id', 'catalog_code',])->orderBy(['sort' => SORT_ASC,])->asArray()->all();

        foreach ($departments as $department) {
            $departmentID = (int) $department['id'];
            $landingPage = [];
            if ($department['landing_page_id']) {
                $landingPage = ContentHelper::getDeparmentLandingPage($department['landing_page_id']);
            }

            $others[$departmentID] = [
                'name' => $department['name'].' [Департамент]'.self::getDepartmentTreeActions(['department-id' => $departmentID,]),
                'id' => $departmentID,
                'url' => '/department/department/update?id='.$departmentID,
                'type' => self::TYPE_DEPARTMENT,
                'font' => $department['is_active'] ? '' : ['color' => 'red',],
                'landing_page_id' => $department['landing_page_id'] ?: 0,
                'landing_page_name' => $landingPage ? $landingPage['name'] : '',
                'catalog_code' => $department['catalog_code'],
            ];
            if ($model && $departmentID === $model->id && $otype === self::TYPE_DEPARTMENT) {
                $others[$departmentID]['open'] = true;
            }

            $departmentMenus = DepartmentMenu::find()->select(['id', 'name', 'image', 'is_active', 'landing_page_type', 'landing_page_id', 'landing_page_catalog',])->where(['department_id' => $departmentID,])->orderBy(['sort' => SORT_ASC, 'name' => SORT_ASC,])->asArray()->all();
            if ($departmentMenus) {
                $others[$departmentID][Catalog::TREE_ITEM_CHILDREN] = [];
            }

            foreach ($departmentMenus as $departmentMenu) {
                $departmentMenuID = (int) $departmentMenu['id'];
                $landingPage = [];
                if ($departmentMenu['landing_page_type'] === DepartmentMenu::LANDING_PAGE_TYPE_PAGE && !empty($departmentMenu['landing_page_id'])) {
                    $landingPage = ContentHelper::getDeparmentLandingPage($departmentMenu['landing_page_id']);
                }

                $others[$departmentID][Catalog::TREE_ITEM_CHILDREN][$departmentMenuID] = [
                    'name' => $departmentMenu['name'].' [Меню]'.self::getDepartmentTreeActions(['department-id' => $departmentID, 'department-menu-id' => $departmentMenuID,]),
                    'id' => $departmentMenuID,
                    'url' => '/department/department-menu/update?id='.$departmentMenuID,
                    'type' => self::TYPE_MENU,
                    'font' => $departmentMenu['is_active'] ? '' : ['color' => 'red',],
                    'landing_page_id' => $departmentMenu['landing_page_id'] ?: 0,
                    'landing_page_name' => $landingPage ? $landingPage['name'] : '',
                    'landing_page_catalog' => $departmentMenu['landing_page_type'] === DepartmentMenu::LANDING_PAGE_TYPE_CATALOG ? $departmentMenu['landing_page_catalog'] : '',
                ];

                if ($oid === $departmentMenuID && $otype === self::TYPE_MENU) {
                    $others[$departmentID][Catalog::TREE_ITEM_CHILDREN][$departmentMenuID]['open'] = true;
                }

                $departmentMenuTags = DepartmentMenuTag::find()->select(['id', 'url', 'name', 'is_active', 'landing_page_id',])->where(['department_menu_id' => $departmentMenuID,])->orderBy(['sort' => SORT_ASC,])->asArray()->all();
                if ($departmentMenuTags) {
                    $others[$departmentID][Catalog::TREE_ITEM_CHILDREN][$departmentMenuID][Catalog::TREE_ITEM_CHILDREN] = [];
                }

                foreach ($departmentMenuTags as $departmentMenuTag) {
                    $departmentMenuTagID = (int) $departmentMenuTag['id'];
                    $landingPage = [];
                    if ($departmentMenuTag['landing_page_id']) {
                        $landingPage = ContentHelper::getDeparmentLandingPage($departmentMenuTag['landing_page_id']);
                    }

                    $others[$departmentID][Catalog::TREE_ITEM_CHILDREN][$departmentMenuID][Catalog::TREE_ITEM_CHILDREN][$departmentMenuTagID] = [
                        'name' => $departmentMenuTag['name'].' [Тематика]'.self::getDepartmentTreeActions(['department-id' => $departmentID, 'department-menu-id' => $departmentMenuID, 'department-menu-tag-id' => $departmentMenuTagID,]),
                        'id' => $departmentMenuTagID,
                        'url' => '/department/department-menu/update-tag?id='.$departmentMenuTagID,
                        'type' => self::TYPE_MENU_TAG,
                        'font' => $departmentMenuTag['is_active'] ? '' : ['color' => 'red',],
                        'landing_page_id' => $departmentMenuTag['landing_page_id'] ?: 0,
                        'landing_page_name' => $landingPage ? $landingPage['name'] : '',
                    ];

                    if ($oid === $departmentMenuTagID && $otype === self::TYPE_MENU_TAG) {
                        $others[$departmentID][Catalog::TREE_ITEM_CHILDREN][$departmentMenuID][Catalog::TREE_ITEM_CHILDREN][$departmentMenuTagID]['open'] = true;
                    }
                }
            }
        }

        // Группы товаров
        $itemGroups = Catalog::find()->where(['parent_code' => Catalog::ITEM_GROUPS_CODE, 'is_department' => true,])->asArray()->orderBy(['order' => SORT_ASC,])->all();
        foreach ($itemGroups as $itemGroup) {
            foreach ($others as $departmentID => $other) {
                if (!empty($other['catalog_code']) && $other['catalog_code'] === $itemGroup['code']) {
                    $other['font'] = ['color' => 'green',];

                    $rootItem[Catalog::TREE_ITEM_CHILDREN][self::TYPE_GROUPS][Catalog::TREE_ITEM_CHILDREN][$departmentID] = $other;

                    unset($others[$departmentID]);
                }
            }
        }

        // Модели
        $types = Catalog::find()->where(['level' => Catalog::LEVEL_3, 'is_product' => Catalog::IS_PRODUCT_NO, 'is_department' => false,])->asArray(false)->all();

        $trees = [];
        foreach ($types as $type) {
            $trees[$type->code] = CatalogHelper::getCatalogTreeData($type);

            if ($type->code === Catalog::CARS_CODE) {
                $type->tabClass = 'model-auto__brand--cars';
            } else {
                $type->tabClass = 'model-auto__brand--trucks';
            }
        }

        foreach ($types as $type) {
            //Тип
            $rootItem[Catalog::TREE_ITEM_CHILDREN][self::TYPE_MODELS][Catalog::TREE_ITEM_CHILDREN][$type->id] = [
                'name' => $type->name.' [Тип]',
                'id' => $type->id,
                'url' => '',
                'type' => self::TYPE_MODELS,
                'font' => ['color' => 'darkgray',],
                Catalog::TREE_ITEM_CHILDREN => [],
            ];

            foreach ($trees[$type->code][Catalog::TREE_LEVEL_FIRST][Catalog::TREE_ITEM_CHILDREN] as $firstChildrenCode => $firstChildren) {
                // Бренд
                $rootItem[Catalog::TREE_ITEM_CHILDREN][self::TYPE_MODELS][Catalog::TREE_ITEM_CHILDREN][$type->id][Catalog::TREE_ITEM_CHILDREN][$firstChildrenCode] = [
                    'name' => $firstChildren['name'].' [Бренд]',
                    'id' => $firstChildren['id'],
                    'url' => '',
                    'type' => self::TYPE_MODELS,
                    'font' => ['color' => 'darkgray',],
                    Catalog::TREE_ITEM_CHILDREN => [],
                ];

                foreach ($trees[$type->code][Catalog::TREE_LEVEL_SECOND][$firstChildrenCode][Catalog::TREE_ITEM_CHILDREN] as $secondChildrenCode => $secondChildren) {
                    // Модель
                    $rootItem[Catalog::TREE_ITEM_CHILDREN][self::TYPE_MODELS][Catalog::TREE_ITEM_CHILDREN][$type->id][Catalog::TREE_ITEM_CHILDREN][$firstChildrenCode][Catalog::TREE_ITEM_CHILDREN][$secondChildrenCode] = [
                        'name' => $secondChildren['name'].' [Модель]',
                        'id' => $secondChildren['id'],
                        'url' => '',
                        'type' => self::TYPE_MODELS,
                        'font' => ['color' => 'darkgray',],
                        Catalog::TREE_ITEM_CHILDREN => [],
                    ];

                    foreach ($trees[$type->code][Catalog::TREE_LEVEL_THIRD][$secondChildrenCode][Catalog::TREE_ITEM_CHILDREN] as $thirdChildrenCode => $thirdChildren) {
                        // Поколение
                        $rootItem[Catalog::TREE_ITEM_CHILDREN][self::TYPE_MODELS][Catalog::TREE_ITEM_CHILDREN][$type->id][Catalog::TREE_ITEM_CHILDREN][$firstChildrenCode][Catalog::TREE_ITEM_CHILDREN][$secondChildrenCode][Catalog::TREE_ITEM_CHILDREN][$thirdChildren['id']] = [
                            'name' => $thirdChildren['name'].' [Пок-е]'.' / '.$thirdChildrenCode,
                            'id' => $thirdChildren['id'],
                            'url' => '',
                            'type' => self::TYPE_MODELS,
                            'font' => ['color' => 'darkgray',],
                        ];

                        foreach ($others as $departmentID => $other) {
                            if (!empty($other['catalog_code']) && $other['catalog_code'] === $thirdChildrenCode) {
                                $other['font'] = ['color' => 'green',];

                                $rootItem[Catalog::TREE_ITEM_CHILDREN][self::TYPE_MODELS][Catalog::TREE_ITEM_CHILDREN][$type->id][Catalog::TREE_ITEM_CHILDREN][$firstChildrenCode][Catalog::TREE_ITEM_CHILDREN][$secondChildrenCode][Catalog::TREE_ITEM_CHILDREN][$thirdChildren['id']][Catalog::TREE_ITEM_CHILDREN][$departmentID] = $other;

                                unset($others[$departmentID]);
                            }
                        }
                    }
                }
            }
        }

        // Другие
        foreach ($others as $departmentID => $other) {
            $rootItem[Catalog::TREE_ITEM_CHILDREN][self::TYPE_OTHERS][Catalog::TREE_ITEM_CHILDREN][$departmentID] = $other;
        }

        return [$rootItem,];
    }

    /**
     * @param Department $department
     *
     * @return array
     */
    public static function getSimpleDepartmentsTreeData(Department $department) : array
    {
        $tree = [];
        $departmentMenus = DepartmentMenu::find()->select(['id', 'name', 'image', 'url',])->where(['department_id' => $department->id, 'is_active' => true,])->orderBy(['sort' => SORT_ASC, 'name' => SORT_ASC,])->asArray()->all();

        foreach ($departmentMenus as $departmentMenu) {
            $departmentMenu['children'] = [];
            $tree[$departmentMenu['id']] = $departmentMenu;

            $departmentMenuTags = DepartmentMenuTag::find()->select(['id', 'name', 'image', 'url',])->where(['department_menu_id' => $departmentMenu['id'], 'is_active' => true,])->orderBy(['sort' => SORT_ASC,])->asArray()->all();

            foreach ($departmentMenuTags as $departmentMenuTag) {
                $tree[$departmentMenu['id']]['children'][$departmentMenuTag['id']] = $departmentMenuTag;
            }
        }

        return $tree;
    }

    /**
     * @param array $array
     *
     * @return array
     */
    public static function clearArrayKeys(array $array) : array
    {
        $array = array_shift($array);
        $list = ['name' => $array['name'], 'id' => $array['id'], 'url' => $array['url'], 'type' => $array['type'], 'open' => $array['open'] ?? false,];
        if (!empty($array['children'])) {
            $list['children'] = array_values($array['children']);
            $list['children'] = self::findNodebyName($list['children']);
        }

        return $list;
    }

    /**
     * @param array $tree
     *
     * @return array
     */
    public static function findNodebyName(array &$tree) {
        $nodes = [&$tree];
        $i = 0;

        while($i < count($nodes)) {
            foreach($nodes[$i] as &$node) {
                if(!empty($node['children'])) {
                    $node['children'] = array_values($node['children']);

                    $nodes[] = &$node['children'];
                }
            }

            $i++;
        }

        return $tree;
    }

    /**
     * @param array $data
     *
     * @return string
     */
    public static function getDepartmentTreeActions(array $data) : string
    {
        return '';

        return Html::tag('div', Html::a(Html::tag('span', '', ['class' => 'fas fa-plus',]), '#', ['data' => $data,]), ['class' => 'tree-actions',]);
    }


    /**
     * @param $excludeID
     *
     * @return array
     */
    public static function getLandingPageOptions($excludeID = null) : array
    {
        $ids = [];
        $departmentIds = Department::find()->select(['landing_page_id',])->where(['>', 'landing_page_id', 0])->asArray()->column();
//        $departmentModelIds = DepartmentModel::find()->select(['landing_page_id',])->where(['>', 'landing_page_id', 0])->asArray()->column();
        $departmentMenuIds = DepartmentMenu::find()->select(['landing_page_id',])->where(['>', 'landing_page_id', 0])->asArray()->column();
        $departmentMenuTagIds = DepartmentMenuTag::find()->select(['landing_page_id',])->where(['>', 'landing_page_id', 0])->asArray()->column();

        if (!empty($departmentIds)) {
            $ids = $departmentIds;
        }
//        if (!empty($departmentModelIds)) {
//            $ids = ArrayHelper::merge($ids, $departmentModelIds);
//        }
        if (!empty($departmentMenuIds)) {
            $ids = ArrayHelper::merge($ids, $departmentMenuIds);
        }
        if (!empty($departmentMenuTagIds)) {
            $ids = ArrayHelper::merge($ids, $departmentMenuTagIds);
        }

        $query = Content::find()->select(['id', 'name',])->where(['type' => Content::TYPE_PAGE, 'deleted_at' => null, 'is_index_page' => false,])->orderBy(['name' => SORT_ASC,])->asArray();

        if (!empty($ids)) {
            if (!empty($excludeID)) {
                foreach ($ids as $i => $id) {
                    if ($excludeID == $id) {
                        unset($ids[$i]);
                        break;
                    }
                }
            }
            $query->andWhere(['not in', 'id', $ids]);
        }

        return ArrayHelper::map($query->all(), 'id', 'name');
    }

    /**
     * @param int $departmentID
     *
     * @return array
     */
    public static function getDefaultMenuOptions(int $departmentID) : array
    {
        $options = [];
        $rows = DepartmentMenu::find()->where(['department_id' => $departmentID, 'is_active' => true,])->orderBy(['name' => SORT_ASC,])->asArray()->all();
        foreach ($rows as $row) {
            if (!empty($row['is_all_products'])) {
                $row['name'] .= ' (*)';
            }

            $options[$row['id']] = $row['name'];
        }

        return $options;
    }

    /**
     * @return array
     */
    public static function getLandingPageCatalogOptions() : array
    {
        $list = [];
        $rows = Catalog::find()->where(['is_department' => true,])->orderBy(['name' => SORT_ASC,])->asArray()->all();

        foreach ($rows as $row) {
            $list[$row['code']] = $row['name'].' / '.$row['code'];
        }

        return $list;
    }

    /**
     * @param int $departmentID
     *
     * @return bool|DepartmentMenu|null
     */
    public static function addDefaultDepartmentMenu(int $departmentID)
    {
        $isExist = DepartmentMenu::find()->where(['department_id' => $departmentID, 'is_all_products' => true, 'is_active' => true,])->exists();

        if (!$isExist) {
            $model = new DepartmentMenu();
            $model->department_id = $departmentID;
            $model->name = self::DEPARTMENT_MENU_ITEMS_TITLE;
            $model->url = self::DEPARTMENT_MENU_ITEMS_URL;
            $model->sort = 1;
            $model->is_active = true;
            $model->landing_page_type = DepartmentMenu::LANDING_PAGE_TYPE_CATALOG;
            $model->is_all_products = true;
            if ($model->save()) {
                DepartmentMenu::updateAll(['is_all_products' => false,], 'id != :id AND department_id = :department_id', [':id' => $model->id, ':department_id' => $model->department_id,]);

                $department = Department::findOne(['id' => $departmentID,]);
                $department->default_menu_id = $model->id;
                $department->save(false);

                return $model;
            }

            return null;
        }

        return false;
    }

    /**
     * @param array $zNodes
     */
    public static function buildTreeView(array $zNodes) : void
    {
        echo '<ul>';
        echo '<li><strong>'.$zNodes['name'].'</strong>';
        echo '<ul>';

        if (!empty($zNodes['children'])) {
            echo '<ul>';
            foreach ($zNodes['children'] as $model) {
                echo '<li><strong>' . $model['name'] . '</strong> / ' . (!empty($model['landing_page_name']) ? Html::a($model['landing_page_name'],
                        ['/content/pages/update', 'id' => $model['landing_page_id'],],
                        ['blank' => '_target',]) : Html::tag('span', 'Не задано'));

                self::buildTreeView($model);
            }
            echo '</ul>';
        }

        echo '</ul>';
        echo '</ul>';
    }
}