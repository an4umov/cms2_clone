<?php
namespace cabinet\components\helpers;

use yii;
use yii\bootstrap\Nav;

class MenuHelper
{
    const FIRST_MENU_HOME_PAGE = 'home';
    const MENU_CATALOG = 'catalog';
    const MENU_CHAT = 'chat';
    const MENU_FAVOTITE = 'favotite';

    /**
     * @param string $activeMenu
     *
     * @return string
     * @throws \Exception
     */
    public static function menuLevel(string $activeMenu) : string
    {
        if (!Yii::$app->user->isGuest) {
            $items = [
                ['label' => '<span class="nk-menu-text">Каталог</span>', 'url' => ['/'.self::MENU_CATALOG], 'active' => $activeMenu === self::MENU_CATALOG, 'options' => ['class' => 'nk-menu-item',], 'linkOptions' => ['class' => 'nk-menu-link',],],
                ['label' => '<span class="nk-menu-text">Чат</span>', 'url' => ['/'.self::MENU_CHAT], 'active' => $activeMenu === self::MENU_CHAT, 'options' => ['class' => 'nk-menu-item',], 'linkOptions' => ['class' => 'nk-menu-link',],],
                ['label' => '<span class="nk-menu-text">Избранное</span>', 'url' => ['/'.self::MENU_FAVOTITE], 'active' => $activeMenu === self::MENU_FAVOTITE, 'options' => ['class' => 'nk-menu-item',], 'linkOptions' => ['class' => 'nk-menu-link',],],
            ];

            return Nav::widget([
                'options' => ['class' => 'nk-menu nk-menu-main ui-s2',],
                'items' => $items,
                'encodeLabels' => false,
            ]);
        }

        return '';
    }
}
