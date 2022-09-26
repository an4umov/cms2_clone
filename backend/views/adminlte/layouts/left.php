<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="https://ui-avatars.com/api/?name=<?php echo \Yii::$app->user->identity->username ?>"
                     class="img-circle" alt="<?php echo \Yii::$app->user->identity->username ?>">
            </div>
            <div class="pull-left info">
                <p><?php echo \Yii::$app->user->identity->username ?></p>

                <? if ( ! \Yii::$app->user->isGuest ): ?>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                <? endif; ?>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?php echo dmstr\widgets\Menu::widget(
            [
                'options' => [ 'class' => 'sidebar-menu tree', 'data-widget' => 'tree' ],
                'items' => [
                    [ 'label' => 'CMS', 'options' => [ 'class' => 'header' ] ],
                    [ 'label' => 'Меню', 'icon' => 'sitemap', 'url' => [ '/menu' ] ],
                    [ 'label' => 'Новости (JSON)', 'icon' => 'file', 'url' => [ '/news' ] ],
                    [ 'label' => 'Страницы', 'icon' => 'file', 'url' => [ '/material' ] ],
                    [ 'label' => 'Системные материалы', 'icon' => 'list-ul', 'url' => [ '/material/system' ] ],
                    [ 'label' => 'Теги', 'icon' => 'tags', 'url' => [ '/tag/tree' ] ],
                    [ 'label' => 'Шаблоны', 'icon' => 'book', 'url' => [ '/templates' ] ],

                    [
                        'label' => 'Виджеты',
                        'icon' => 'eye',
                        'items' => [
                            [ 'label' => 'Слайдеры', 'icon' => 'picture-o', 'url' => [ '/gallery' ] ],
                            [ 'label' => 'Низкий баннер', 'icon' => 'tags', 'url' => [ '/low-banner' ] ],
                            [ 'label' => 'Баннер 4/2', 'icon' => 'tags', 'url' => [ '/shop-banner' ] ],
                            [ 'label' => 'Баннер 4/2/2-2', 'icon' => 'tags', 'url' => [ '/info-block' ] ],

                            [ 'label' => 'Виджет аккордеон/вкладки', 'icon' => 'tags', 'url' => [ '/composite' ] ],
                            [ 'label' => 'Виджет плитка', 'icon' => 'clone', 'url' => [ '/tile' ] ],
                            [ 'label' => 'Виджет слайдер-плитка', 'icon' => 'clone', 'url' => [ '/slider-tile' ] ],

                            [ 'label' => 'Виджет плитка изображений (текст слева)', 'icon' => 'clone', 'url' => [ '/widget', 'type' => common\models\Widget::TYPE_IMAGES_TILE_LEFT_TEXT] ],
                            [ 'label' => 'Виджет плитка изображений с заголовком', 'icon' => 'clone', 'url' => [ '/widget', 'type' => common\models\Widget::TYPE_IMAGES_TILE_ONLY_TITLE_1] ],
                            [ 'label' => 'Виджет плитка изображений с заголовком (с группировкой)', 'icon' => 'clone', 'url' => [ '/widget', 'type' => common\models\Widget::TYPE_IMAGES_TILE_ONLY_TITLE_2] ],
                        ]
                    ],
                    [ 'label' => 'Контент для виджетов', 'icon' => 'tags', 'url' => [ '/content-item' ] ],
                    [ 'label' => 'Пользователи', 'icon' => 'users', 'url' => [ '/users/index' ], 'visible' => Yii::$app->user->can("admin") ],

                    [ 'label' => 'Товарная часть', 'icon' => 'shopping-basket', 'url' => [ '#' ] ],
                    [ 'label' => 'Картинки и файлы', 'icon' => 'file-archive-o', 'url' => [ '/imagemanager' ] ],
                    [ 'label' => 'Обмен', 'icon' => 'arrows-h', 'url' => [ '#' ] ],
                    [ 'label' => 'Опции', 'icon' => 'toggle-on', 'url' => [ '#' ] ],
                    [
                        'label' => 'Настройки',
                        'icon' => 'cogs',
                        'items' => [
                            [ 'label' => 'Каталог (плитка)', 'icon' => 'clone', 'url' => [ '/catalog-tree-setting', ], ],
                        ],
                    ],

                    [ 'label' => 'Login', 'url' => [ 'site/login' ], 'visible' => Yii::$app->user->isGuest ],
                ],
            ]
        ) ?>

    </section>

</aside>
