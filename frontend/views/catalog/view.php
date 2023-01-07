<?php

/**
 * @var \yii\web\View          $this
 * @var array                  $tree
 * @var bool                   $isTree
 * @var bool                   $isFinalItem
 * @var \common\models\Catalog $model
 * @var string                 $activeCode
 * @var array                  $codes
 * @var array                  $filter
 * @var array                  $baseUrlRoute
 * @var bool                   $isArticles
 * @var array                  $rubricTitles
 */

use \common\models\Catalog;
use \common\components\helpers\CatalogHelper;
use yii\helpers\Url;

$this->title = $model->name;
?>
<!--    <pre>-->
        <? //print_r($tree) ?>
        <? //print_r($rubricTitles) ?>

<!--    </pre>-->
<?// exit; ?>
<? if (!empty($isTree)): ?>
    <pre>
        <? print_r($tree) ?>
    </pre>
<? else: ?>
    <!-- MOBILE -->
    <section class="shop-catalog-mobile">
        <div class="shop-catalog-mobile__inner">
            <div class="shop-catalog-mobile__title"><?= $tree[Catalog::TREE_LEVEL_FIRST][Catalog::TREE_ITEM_PARENT]['name'] ?></div>
            <div class="shop-catalog-mobile__item-list">
            <? foreach ($tree[Catalog::TREE_LEVEL_FIRST][Catalog::TREE_ITEM_CHILDREN] as $firstChildrenCode => $firstChildren): ?>
                <div class="shop-catalog-mobile-item">
                    <a href="<?= !empty($firstChildren['link_anchor']) ? Url::to(['catalog/view', 'code' => $firstChildren['link_anchor'],]) : (Url::to(empty($baseUrlRoute) ? ['catalog/view', 'code' => $firstChildrenCode,] : CatalogHelper::getBaseCatalogRoute($baseUrlRoute['department'], $baseUrlRoute['departmentMenu'], $baseUrlRoute['departmentMenuTag'], $firstChildrenCode))) ?>" data-code="<?= $firstChildrenCode ?>" class="<?= empty($tree[Catalog::TREE_LEVEL_SECOND][$firstChildrenCode][Catalog::TREE_ITEM_CHILDREN]) ? 'final-item-mobile' : '' ?><?= !empty($firstChildren['link_anchor']) ? ' link_anchor-mobile' : '' ?>" <?= CatalogHelper::getFilterDataAttrs($filter) ?>>
                        <div class="shop-catalog-mobile-item__picture">
                            <img src="<?= CatalogHelper::getCatalogTopLevelImageUrl($firstChildrenCode) ?>" alt="">
                        </div>
                        <div class="shop-catalog-mobile-item__text<?= isset($codes[$firstChildrenCode]) ? ' shop-catalog-mobile-item__text--active' : '' ?>"><?= $rubricTitles[$firstChildrenCode]['title'] ?></div>
                    </a>
                </div>
            <? endforeach; ?>
            </div>
        </div>

        <!-- Second title/ second items-list-->
        <? if (!empty($tree[Catalog::TREE_LEVEL_SECOND])): ?>
            <? foreach ($tree[Catalog::TREE_LEVEL_SECOND] as $secondChildren): ?>
                <div class="shop-catalog-mobile__inner--second" data-code="<?= $secondChildren[Catalog::TREE_ITEM_PARENT]['code'] ?>">
                <? if (!empty($secondChildren[Catalog::TREE_ITEM_CHILDREN])): ?>
                    <div class="shop-catalog-mobile__title">
                        <?= $secondChildren[Catalog::TREE_ITEM_PARENT]['name'] ?>
                    </div>
                    <div class="shop-catalog-mobile__item-list">
                    <? foreach ($secondChildren[Catalog::TREE_ITEM_CHILDREN] as $secondItem): ?>
                        <div class="shop-catalog-mobile-item--second">
                            <a href="<?= !empty($secondItem['link_anchor']) ? Url::to(['catalog/view', 'code' => $secondItem['link_anchor'],]) : (Url::to(empty($baseUrlRoute) ? ['catalog/view', 'code' => $secondItem['code'],] : CatalogHelper::getBaseCatalogRoute($baseUrlRoute['department'], $baseUrlRoute['departmentMenu'], $baseUrlRoute['departmentMenuTag'], $secondItem['code']))) ?>" data-code="<?= $secondItem['code'] ?>" data-parent_code="<?= $secondItem['parent_code'] ?>" class="<?= empty($tree[Catalog::TREE_LEVEL_THIRD][$secondItem['code']][Catalog::TREE_ITEM_CHILDREN]) ? 'final-item-mobile' : '' ?><?= !empty($secondItem['link_anchor']) ? ' link_anchor-mobile' : '' ?>" <?= CatalogHelper::getFilterDataAttrs($filter) ?>>
                                <div class="shop-catalog-mobile-item__picture">
                                    <img src="<?= CatalogHelper::getCatalogTopLevelImageUrl($secondItem['code']) ?>" alt="">
                                </div>
                                <div class="shop-catalog-mobile-item__text<?= isset($codes[$secondItem['code']]) ? ' shop-catalog-mobile-item__text--active' : '' ?>"><?= $rubricTitles[$secondItem['code']]['title'] ?></div>
                            </a>
                        </div>
                    <? endforeach; ?>
                    </div>
                <? endif; ?>
                </div>
            <? endforeach; ?>
        <? endif; ?>

        <!-- third title/ third items-list-->
        <? if (!empty($tree[Catalog::TREE_LEVEL_THIRD])): ?>
            <? foreach ($tree[Catalog::TREE_LEVEL_THIRD] as $thirdChildren): ?>
                <div class="shop-catalog-mobile__inner--third" data-code="<?= $thirdChildren[Catalog::TREE_ITEM_PARENT]['code'] ?>">
                <? if (!empty($thirdChildren[Catalog::TREE_ITEM_CHILDREN])): ?>
                    <div class="shop-catalog-mobile__title">
                        <?= $thirdChildren[Catalog::TREE_ITEM_PARENT]['name'] ?>
                    </div>
                    <div class="shop-catalog-mobile__item-list">
                    <? foreach ($thirdChildren[Catalog::TREE_ITEM_CHILDREN] as $thirdItem): ?>
                        <div class="shop-catalog-mobile-item--third">
                            <a href="<?= !empty($thirdItem['link_anchor']) ? Url::to(['catalog/view', 'code' => $thirdItem['link_anchor'],]) : ( Url::to(empty($baseUrlRoute) ? ['catalog/view', 'code' => $thirdItem['code'],] : CatalogHelper::getBaseCatalogRoute($baseUrlRoute['department'], $baseUrlRoute['departmentMenu'], $baseUrlRoute['departmentMenuTag'], $thirdItem['code']))) ?>" data-code="<?= $thirdItem['code'] ?>" data-parent_code="<?= $thirdItem['parent_code'] ?>" class="<?= empty($tree[Catalog::TREE_LEVEL_FOURTH][$thirdItem['code']][Catalog::TREE_ITEM_CHILDREN]) ? 'final-item-mobile' : '' ?><?= !empty($thirdItem['link_anchor']) ? ' link_anchor-mobile' : '' ?>" <?= CatalogHelper::getFilterDataAttrs($filter) ?>>
                                <div class="shop-catalog-mobile-item__picture">
                                    <img src="<?= CatalogHelper::getCatalogTopLevelImageUrl($thirdItem['code']) ?>" alt="">
                                </div>
                                <div class="shop-catalog-mobile-item__text<?= isset($codes[$thirdItem['code']]) ? ' shop-catalog-mobile-item__text--active' : '' ?>"><?= $rubricTitles[$thirdItem['code']]['title'] ?></div>
                            </a>
                        </div>
                    <? endforeach; ?>
                    </div>
                <? endif; ?>
                </div>
            <? endforeach; ?>
        <? endif; ?>

        <!-- fourth title/ fourth items-list-->
        <? if (!empty($tree[Catalog::TREE_LEVEL_FOURTH])): ?>
            <? foreach ($tree[Catalog::TREE_LEVEL_FOURTH] as $fourthChildren): ?>
                <div class="shop-catalog-mobile__inner--fourth" data-code="<?= $fourthChildren[Catalog::TREE_ITEM_PARENT]['code'] ?>">
                <? if (!empty($fourthChildren[Catalog::TREE_ITEM_CHILDREN])): ?>
                    <div class="shop-catalog-mobile__title">
                        <?= $fourthChildren[Catalog::TREE_ITEM_PARENT]['name'] ?>
                    </div>
                    <div class="shop-catalog-mobile__item-list">
                    <? foreach ($fourthChildren[Catalog::TREE_ITEM_CHILDREN] as $fourthItem): ?>
                        <div class="shop-catalog-mobile-item--fourth">
                            <a href="<?= !empty($fourthItem['link_anchor']) ? Url::to(['catalog/view', 'code' => $fourthItem['link_anchor'],]) : (Url::to(empty($baseUrlRoute) ? ['catalog/view', 'code' => $fourthItem['code'],] : CatalogHelper::getBaseCatalogRoute($baseUrlRoute['department'], $baseUrlRoute['departmentMenu'], $baseUrlRoute['departmentMenuTag'], $fourthItem['code']))) ?>" class="final-item-mobile<?= !empty($fourthItem['link_anchor']) ? ' link_anchor-mobile' : '' ?>" data-code="<?= $fourthItem['code'] ?>" data-parent_code="<?= $fourthItem['parent_code'] ?>" <?= CatalogHelper::getFilterDataAttrs($filter) ?>>
                                <div class="shop-catalog-mobile-item__picture">
                                    <img src="<?= CatalogHelper::getCatalogTopLevelImageUrl($fourthItem['code']) ?>" alt="">
                                </div>
                                <div class="shop-catalog-mobile-item__text<?= isset($codes[$fourthItem['code']]) ? ' shop-catalog-mobile-item__text--active' : '' ?>"><?= $rubricTitles[$fourthItem['code']]['title'] ?></div>
                            </a>
                        </div>
                    <? endforeach; ?>
                    </div>
                <? endif; ?>
                </div>
            <? endforeach; ?>
        <? endif; ?>
    </section>

    <!-- ------- DESKTOP ------- -->
    <section class="shop-catalog-desktop">
        <!-- First Level of Catalog -->
        <div class="shop-catalog-desktop__inner">
            <div class="shop-catalog-desktop__title">
                <div class="shop-catalog-desktop__title-picture">
                    <img src="<?= CatalogHelper::getCatalogTopLevelImageUrl($tree[Catalog::TREE_LEVEL_FIRST][Catalog::TREE_ITEM_PARENT]['code']) ?>" alt="">
                </div>
                <div class="shop-catalog-desktop__title-arrow"></div>
                <div class="shop-catalog-desktop__title-open"><?= $tree[Catalog::TREE_LEVEL_FIRST][Catalog::TREE_ITEM_PARENT]['name'] ?></div>
                <div class="shop-catalog-desktop__title-close"><?= $tree[Catalog::TREE_LEVEL_FIRST][Catalog::TREE_ITEM_PARENT]['name'] ?></div>
                <div class="shop-catalog-desktop__title-static"><?= $tree[Catalog::TREE_LEVEL_FIRST][Catalog::TREE_ITEM_PARENT]['name'] ?></div>
            </div>
            <? foreach ($tree[Catalog::TREE_LEVEL_FIRST][Catalog::TREE_ITEM_CHILDREN] as $firstChildrenCode => $firstChildren): ?>
                <div class="shop-catalog-desktop__item">
                    <a href="<?= !empty($firstChildren['link_anchor']) ? Url::to(['catalog/view', 'code' => $firstChildren['link_anchor'],]) : (Url::to(empty($baseUrlRoute) ? ['catalog/view', 'code' => $firstChildrenCode,] : CatalogHelper::getBaseCatalogRoute($baseUrlRoute['department'], $baseUrlRoute['departmentMenu'], $baseUrlRoute['departmentMenuTag'], $firstChildrenCode))) ?>" data-code="<?= $firstChildrenCode ?>" class="<?= empty($tree[Catalog::TREE_LEVEL_SECOND][$firstChildrenCode][Catalog::TREE_ITEM_CHILDREN]) ? 'final-item' : '' ?><?= !empty($firstChildren['link_anchor']) ? ' link_anchor' : '' ?>" <?= CatalogHelper::getFilterDataAttrs($filter) ?> <?= !empty($firstChildren['link_anchor']) ? 'target="_blank"' : '' ?>>
                        <div class="shop-catalog-desktop__item-picture">
                            <img src="<?= CatalogHelper::getCatalogTopLevelImageUrl($firstChildrenCode) ?>" alt="">
                        </div>
                        <div class="shop-catalog-desktop__item-text<?= isset($codes[$firstChildrenCode]) ? ' shop-catalog-desktop__item-text--active' : '' ?>"><?= $rubricTitles[$firstChildrenCode]['title'] ?></div>
                    </a>
                </div>
            <? endforeach; ?>
        </div>

        <!-- Second Level of Catalog -->
        <? if (!empty($tree[Catalog::TREE_LEVEL_SECOND])): ?>
            <? foreach ($tree[Catalog::TREE_LEVEL_SECOND] as $secondChildren): ?>
                <? if (!empty($secondChildren[Catalog::TREE_ITEM_CHILDREN])): ?>
                <?
                $styleFlex = '';
                foreach ($codes as $code) {
                    if (isset($secondChildren[Catalog::TREE_ITEM_CHILDREN][$code])) {
                        $styleFlex = 'display:flex;';
                    }
                }
                if (isset($codes[$secondChildren[Catalog::TREE_ITEM_PARENT]['code']])) {
                    $styleFlex = 'display:flex;';
                }
                ?>
                <div class="shop-catalog-desktop__inner--second" data-code="<?= $secondChildren[Catalog::TREE_ITEM_PARENT]['code'] ?>" style="<?= $styleFlex ?>">
                    <div class="shop-catalog-desktop__title--second" style="<?= $styleFlex ?>">
                        <div class="shop-catalog-desktop__title-picture--second">
                            <img src="<?= CatalogHelper::getCatalogTopLevelImageUrl($secondChildren[Catalog::TREE_ITEM_PARENT]['code']) ?>" alt="">
                        </div>
                        <div class="shop-catalog-desktop__title-arrow--second"></div>
                        <div class="shop-catalog-desktop__title-open--second" style="display: none;"><?= $secondChildren[Catalog::TREE_ITEM_PARENT]['name'] ?></div>
                        <div class="shop-catalog-desktop__title-close--second"><?= $secondChildren[Catalog::TREE_ITEM_PARENT]['name'] ?></div>
                        <div class="shop-catalog-desktop__title-static--second" style="display: flex;"><?= $secondChildren[Catalog::TREE_ITEM_PARENT]['name'] ?></div>
                    </div>
                    <? foreach ($secondChildren[Catalog::TREE_ITEM_CHILDREN] as $secondChildrenCode => $secondChildrenItem): ?>
                        <div class="shop-catalog-desktop__item--second">
                            <a href="<?= !empty($secondChildrenItem['link_anchor']) ? Url::to(['catalog/view', 'code' => $secondChildrenItem['link_anchor'],]) : (Url::to(empty($baseUrlRoute) ? ['catalog/view', 'code' => $secondChildrenCode,] : CatalogHelper::getBaseCatalogRoute($baseUrlRoute['department'], $baseUrlRoute['departmentMenu'], $baseUrlRoute['departmentMenuTag'], $secondChildrenCode))) ?>"
                               data-code="<?= $secondChildrenCode ?>" data-parent_code="<?= $secondChildrenItem['parent_code'] ?>"
                               class="<?= empty($tree[Catalog::TREE_LEVEL_THIRD][$secondChildrenCode][Catalog::TREE_ITEM_CHILDREN]) ? 'final-item' : '' ?><?= !empty($secondChildrenItem['link_anchor']) ? ' link_anchor' : '' ?>"
                                <?= CatalogHelper::getFilterDataAttrs($filter) ?> <?= !empty($secondChildrenItem['link_anchor']) ? 'target="_blank"' : '' ?>
                            >
                                <div class="shop-catalog-desktop__item-picture">
                                    <img src="<?= CatalogHelper::getCatalogTopLevelImageUrl($secondChildrenCode) ?>" alt="">
                                </div>
                                <div class="shop-catalog-desktop__item-text<?= isset($codes[$secondChildrenCode]) ? ' shop-catalog-desktop__item-text--active' : '' ?>">
                                    <?= $rubricTitles[$secondChildrenCode]['title'] ?>
                                </div>
                            </a>
                        </div>
                    <? endforeach; ?>
                </div>
                <? endif; ?>
            <? endforeach; ?>
        <? endif; ?>

        <!-- Third Level of Catalog -->
        <? if (!empty($tree[Catalog::TREE_LEVEL_THIRD])): ?>
            <? foreach ($tree[Catalog::TREE_LEVEL_THIRD] as $thirdChildren): ?>
                <? if (!empty($thirdChildren[Catalog::TREE_ITEM_CHILDREN])): ?>
                <?
                $styleFlex = '';
                foreach ($codes as $code) {
                    if (isset($thirdChildren[Catalog::TREE_ITEM_CHILDREN][$code])) {
                        $styleFlex = 'display:flex;';
                    }
                }
                if (isset($codes[$thirdChildren[Catalog::TREE_ITEM_PARENT]['code']])) {
                    $styleFlex = 'display:flex;';
                }
                ?>
                <div class="shop-catalog-desktop__inner--third" data-code="<?= $thirdChildren[Catalog::TREE_ITEM_PARENT]['code'] ?>" style="<?= $styleFlex ?>">
                    <div class="shop-catalog-desktop__title--third" style="<?= $styleFlex ?>">
                        <div class="shop-catalog-desktop__title-picture--third">
                            <img src="<?= CatalogHelper::getCatalogTopLevelImageUrl($thirdChildren[Catalog::TREE_ITEM_PARENT]['code']) ?>" alt="">
                        </div>
                        <div class="shop-catalog-desktop__title-arrow--third"></div>
                        <div class="shop-catalog-desktop__title-open--third" style="display: none;"><?= $thirdChildren[Catalog::TREE_ITEM_PARENT]['name'] ?></div>
                        <div class="shop-catalog-desktop__title-close--third"><?= $thirdChildren[Catalog::TREE_ITEM_PARENT]['name'] ?></div>
                        <div class="shop-catalog-desktop__title-static--third" style="display: flex;"><?= $thirdChildren[Catalog::TREE_ITEM_PARENT]['name'] ?></div>
                    </div>
                    <? foreach ($thirdChildren[Catalog::TREE_ITEM_CHILDREN] as $thirdChildrenCode => $thirdChildrenItem): ?>
                        <div class="shop-catalog-desktop__item--third">
                            <a href="<?= !empty($thirdChildrenItem['link_anchor']) ? Url::to(['catalog/view', 'code' => $thirdChildrenItem['link_anchor'],]) : (Url::to(empty($baseUrlRoute) ? ['catalog/view', 'code' => $thirdChildrenCode,] : CatalogHelper::getBaseCatalogRoute($baseUrlRoute['department'], $baseUrlRoute['departmentMenu'], $baseUrlRoute['departmentMenuTag'], $thirdChildrenCode))) ?>" data-code="<?= $thirdChildrenCode ?>" data-parent_code="<?= $thirdChildrenItem['parent_code'] ?>" class="<?= empty($tree[Catalog::TREE_LEVEL_FOURTH][$thirdChildrenCode][Catalog::TREE_ITEM_CHILDREN]) ? 'final-item' : '' ?><?= !empty($thirdChildrenItem['link_anchor']) ? ' link_anchor' : '' ?>" <?= CatalogHelper::getFilterDataAttrs($filter) ?> <?= !empty($thirdChildrenItem['link_anchor']) ? 'target="_blank"' : '' ?>>
                                <div class="shop-catalog-desktop__item-picture">
                                    <img src="<?= CatalogHelper::getCatalogTopLevelImageUrl($thirdChildrenCode) ?>" alt="">
                                </div>
                                <div class="shop-catalog-desktop__item-text<?= isset($codes[$thirdChildrenCode]) ? ' shop-catalog-desktop__item-text--active' : '' ?>"><?= $rubricTitles[$thirdChildrenCode]['title'] ?></div>
                            </a>
                        </div>
                    <? endforeach; ?>
                </div>
                <? endif; ?>
            <? endforeach; ?>
        <? endif; ?>

        <!-- Fourth Level of Catalog -->
        <? if (!empty($tree[Catalog::TREE_LEVEL_FOURTH])): ?>
            <? foreach ($tree[Catalog::TREE_LEVEL_FOURTH] as $fourthChildren): ?>
                <? if (!empty($fourthChildren[Catalog::TREE_ITEM_CHILDREN])): ?>
                <?
                $styleFlex = '';
                /**/
                foreach ($codes as $code) {
                    if (isset($fourthChildren[Catalog::TREE_ITEM_CHILDREN][$code])) {
                        $styleFlex = 'display:flex;';
                    }
                }
                if (isset($codes[$fourthChildren[Catalog::TREE_ITEM_PARENT]['code']])) {
                    $styleFlex = 'display:flex;';
                }
                ?>
                <div class="shop-catalog-desktop__inner--fourth" data-code="<?= $fourthChildren[Catalog::TREE_ITEM_PARENT]['code'] ?>" style="<?= $styleFlex ?>">
                    <div class="shop-catalog-desktop__title--fourth" style="<?= $styleFlex ?>">
                        <div class="shop-catalog-desktop__title-picture--fourth">
                            <img src="<?= CatalogHelper::getCatalogTopLevelImageUrl($fourthChildren[Catalog::TREE_ITEM_PARENT]['code']) ?>" alt="">
                        </div>
                        <div class="shop-catalog-desktop__title-arrow--fourth"></div>
                        <div class="shop-catalog-desktop__title-open--fourth"><?= $fourthChildren[Catalog::TREE_ITEM_PARENT]['name'] ?></div>
                        <div class="shop-catalog-desktop__title-close--fourth"><?= $fourthChildren[Catalog::TREE_ITEM_PARENT]['name'] ?></div>
                    </div>
                    <? foreach ($fourthChildren[Catalog::TREE_ITEM_CHILDREN] as $fourthChildrenCode => $fourthChildrenItem): ?>
                        <div class="shop-catalog-desktop__item--fourth">
                            <a href="<?= !empty($fourthChildrenItem['link_anchor']) ? Url::to(['catalog/view', 'code' => $fourthChildrenItem['link_anchor'],]) : (Url::to(empty($baseUrlRoute) ? ['catalog/view', 'code' => $fourthChildrenCode,] : CatalogHelper::getBaseCatalogRoute($baseUrlRoute['department'], $baseUrlRoute['departmentMenu'], $baseUrlRoute['departmentMenuTag'], $fourthChildrenCode))) ?>" class="final-item <?= !empty($fourthChildrenItem['link_anchor']) ? ' link_anchor' : '' ?>" data-code="<?= $fourthChildrenCode ?>" data-parent_code="<?= $fourthChildrenItem['parent_code'] ?>" <?= CatalogHelper::getFilterDataAttrs($filter) ?> <?= !empty($fourthChildrenItem['link_anchor']) ? 'target="_blank"' : '' ?>>
                                <div class="shop-catalog-desktop__item-picture">
                                    <img src="<?= CatalogHelper::getCatalogTopLevelImageUrl($fourthChildrenCode) ?>" alt="">
                                </div>
                                <div class="shop-catalog-desktop__item-text<?= isset($codes[$fourthChildrenCode]) ? ' shop-catalog-desktop__item-text--active' : '' ?>"><?= $rubricTitles[$fourthChildrenCode]['title'] ?></div>
                            </a>
                        </div>
                    <? endforeach; ?>
                </div>
                <? endif; ?>
            <? endforeach; ?>
        <? endif; ?>
    </section>

    <section class="offersContainer"></section>

    <div class="scroll-up">
        <svg class="scroll-up__svg" viewBox="-2 -2 52 52">
            <path class="scroll-up__svg-path" d="
                M24,0
                a24,24 0 0,1 0, 48
                a24,24 0 0,1 0, -48
            "/>
        </svg>
    </div>

    <div class="preloader-container">
        <div class="preloader">
            <div class="gear one">
                <svg viewbox="0 0 100 100" fill="#3d4856">
                    <path
                            d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6      c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3      l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9      c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z">
                    </path>
                </svg>
            </div>
            <div class="gear two">
                <svg viewbox="0 0 100 100" fill="#f67b1e">
                    <path
                            d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6      c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3      l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9      c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z">
                    </path>
                </svg>
            </div>
            <div class="gear three">
                <svg viewbox="0 0 100 100" fill="#096b78">
                    <path
                            d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6      c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3      l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9      c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z">
                    </path>
                </svg>
            </div>
            <div class="lil-circle"></div>
            <svg class="blur-circle">
                <filter id="blur">
                    <fegaussianblur in="SourceGraphic" stddeviation="13"></fegaussianblur>
                </filter>
                <circle cx="70" cy="70" r="66" fill="transparent" stroke="white" stroke-width="40"
                        filter="url(#blur)"></circle>
            </svg>
        </div>
        <div class="preloader__text">Загружаем товарные предложения !</div>
    </div>
<?
    $JS = <<<JS
    document.addEventListener("DOMContentLoaded", (event) => {
        let localFinalItems = document.querySelectorAll('.final-item');
        for (let i = 0; i < localFinalItems.length; i++) {
            const finalItem = localFinalItems[i];
            const finalItemCode = finalItem.dataset.code;
    
            if (finalItemCode === '{$activeCode}') {
                console.log('Found final item with code '+'{$activeCode}');
                finalItem.click();
            }
        }
    });
JS;

if ($activeCode && $isFinalItem) {
    $this->registerJs($JS, \yii\web\View::POS_END);
}
?>
<? endif ?>