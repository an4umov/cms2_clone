<?php


namespace console\controllers;

use common\models\Articles;
use common\models\Catalog;
use common\models\ParserBritautoProcessed;
use common\models\ParserJaguarlandroverclassicRubrics;
use common\models\ParserJaguarlandroverclassicRubricsProcessed;
use common\models\ParserLandspiritProcessed;
use PHPHtmlParser\Dom;
use common\components\helpers\ConsoleHelper;
use common\components\helpers\ParserHelper;
use common\models\Parser;
use common\models\ParserAutoventuri;
use common\models\ParserDaliavto;
use common\models\ParserLrpartsItems;
use common\models\ParserLrpartsRubrics;
use common\models\ParserLrpartsRubricsProcessed;
use common\models\ParserProverkacheka;
use common\models\ParserTriabc;
use PHPHtmlParser\Dom\Node\AbstractNode;
use Symfony\Component\DomCrawler\Crawler;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Connection;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class ParserController extends Controller
{
    const AUTOVENTURI_RU_URL = 'https://www.autoventuri.ru';
    const TRIABC_RU_URL = 'https://triabc.ru';
    const DALIAVTO_RU_URL = 'http://www.dali-avto.ru';
    const RIVALAUTO_RU_URL = 'https://rivalauto.ru';
    const AUTOVENTURI_RU_CATALOG_URL = 'https://www.autoventuri.ru/catalog/';
    const TRIABC_RU_CATALOG_URL = 'https://triabc.ru/catalog/';
    const DALIAVTO_RU_CATALOG_URL = 'http://www.dali-avto.ru/';
    const RIVALAUTO_RU_CATALOG_URL = 'https://rivalauto.ru/catalog';
    const PROVERKACHEKA_RU_CHECK_URL = 'https://proverkacheka.com/check&p=';
    const PROVERKACHEKA_RU_URL = 'https://proverkacheka.com';
    const LRPARTS_RU_URL = 'https://lrparts.ru';
    const LRPARTS_RU_CATALOG_URL = 'https://lrparts.ru/katalog';
    const BRITAUTO_RU_CATALOG_URL = 'https://www.britauto.ru/land_rover_zapchasti';
    const BRITAUTO_RU_URL = 'https://www.britauto.ru';
    const LANDSPIRIT_RU_CATALOG_URL = 'https://landspirit.ru/shop/';
    const LANDSPIRIT_RU_URL = 'https://landspirit.ru';
    const JAGUARLANDROVERCLASSIC_COM_CATALOG_URLS = [
        'https://parts.jaguarlandroverclassic.com/parts/index/hierarchy/id/34/brand/land-rover/',
    ];
    const JAGUARLANDROVERCLASSIC_COM_URL = 'https://parts.jaguarlandroverclassic.com';
    const CHARACTERISTICS_AUTOMOBILE = 'Автомобиль';
    const IMAGE_START_NUMBER = 9900;

//    const BASE_IMAGES_DIR = '/mnt/newmagazin/Parsing/';
    const BASE_IMAGES_DIR = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'Parsing'.DIRECTORY_SEPARATOR;

    const AUTOVENTURI_IMAGES_DIR = self::BASE_IMAGES_DIR.'autoventuri.ru'.DIRECTORY_SEPARATOR;
    const AUTOVENTURI_IMAGES_DIR2 = self::BASE_IMAGES_DIR.'autoventuri2.ru'.DIRECTORY_SEPARATOR;
    const TRIABC_IMAGES_DIR = self::BASE_IMAGES_DIR.'triabc.ru'.DIRECTORY_SEPARATOR;
    const DALIAVTO_IMAGES_DIR = self::BASE_IMAGES_DIR.'daliavto.ru'.DIRECTORY_SEPARATOR;
    const RIVALAUTO_IMAGES_DIR = self::BASE_IMAGES_DIR.'rivalauto.ru'.DIRECTORY_SEPARATOR;
    const PROVERKACHEKA_RU_IMAGES_DIR = self::BASE_IMAGES_DIR.'proverkacheka.com'.DIRECTORY_SEPARATOR;
    const LRPARTS_RU_IMAGES_DIR = self::BASE_IMAGES_DIR.'lrparts.ru'.DIRECTORY_SEPARATOR;
    const JAGUARLANDROVERCLASSIC_COM_IMAGES_DIR = self::BASE_IMAGES_DIR.'jaguarlandroverclassic.com'.DIRECTORY_SEPARATOR;
    const LANDSPIRIT_RU_IMAGES_DIR = self::BASE_IMAGES_DIR.'landspirit.ru'.DIRECTORY_SEPARATOR;
    const LANDSPIRIT_RU_ARTICLES = ['AM', 'AM1', 'AM2', 'LR', 'MGR',];

    private $_newRubricsCount = 0;
    private $_rubricImagesCount = 0;
    private $_newItemsCount = 0;
    private $_britautoRubrics = [];
    private $_britautoPages = [];
    private $_landspiritPageUrls = [];

    public function actionAutoventuri()
    {
        $db = \Yii::$app->db;
        $externalDb = \Yii::$app->db2;
        $totalTime = time();
        $isConsole = true;
        $rowsCount = $savedCount = $savedImagesCount = 0;

        // Каталог
        $html = file_get_contents(self::AUTOVENTURI_RU_CATALOG_URL);

        $crawler = (new Crawler($html));
        $catalogItems = $crawler->filter('div.section-selector > div.section-item')->each(function (Crawler $node, $i) {
            return [
                'href' => self::AUTOVENTURI_RU_URL.$node->filter('a')->last()->attr('href'),
                'name' => trim($node->filter('a')->last()->text()),
            ];
        });

        ConsoleHelper::debug('Найдено '.count($catalogItems).' рубрик', $isConsole);

        if ($catalogItems) {
            ConsoleHelper::deleteParserByType(Parser::TYPE_AUTOVENTURI, $isConsole);
        }

        // Рубрики каталога
        foreach ($catalogItems as $item) {
            try {
                $html = file_get_contents($item['href']);
                ConsoleHelper::debug('Загрузка страницы рубрики, пауза на 1 секунду...', $isConsole);
                sleep(1);
            } catch (\Exception $e) {
                ConsoleHelper::debug('Ошибка: '.$e->getMessage(), $isConsole);
                continue;
            }

            if ($html === false) {
                continue;
            }

            $pages = [$html,];

            $crawler->clear();
            $crawler->addHtmlContent($html);
            $itemPages = $crawler->filter('ul.pagination > li > a')->each(function (Crawler $node, $i) {
                return self::AUTOVENTURI_RU_URL.$node->attr('href');
            });

            if ($itemPages) {
                $itemPages = array_unique($itemPages);

                foreach ($itemPages as $href) {
                    try {
                        $html = file_get_contents($href);
                        ConsoleHelper::debug('Загрузка страницы рубрики, пауза на 1 секунду...', $isConsole);
                        sleep(1);
                    } catch (\Exception $e) {
                        ConsoleHelper::debug('Ошибка: '.$e->getMessage(), $isConsole);
                        continue;
                    }
                    if ($html === false) {
                        continue;
                    }

                    $pages[] = $html;
                }
            }

            ConsoleHelper::debug('Найдено '.count($pages).' страниц для рубрики "'.$item['name'].'"', $isConsole);

            //Страницы рубрики
            $pageItems = [];
            foreach ($pages as $html) {
                $crawler->clear();
                $crawler->addHtmlContent($html);

                $rows = $crawler->filter('div.catalog-section > div.catalog-item')->each(function (Crawler $node, $i) {
                    return [
                        'href' => self::AUTOVENTURI_RU_URL.$node->filter('a.card-link')->first()->attr('href'),
                        'name' => trim($node->filter('a.card-link')->first()->text()),
                    ];
                });

                $pageItems = ArrayHelper::merge($pageItems, $rows);
            }

            ConsoleHelper::debug('Найдено '.count($pageItems).' товаров для рубрики "'.$item['name'].'"', $isConsole);

            // Товары рубрики
            $articles = [];
            foreach ($pageItems as $pageItem) {
                try {
                    $html = file_get_contents($pageItem['href']);
                    ConsoleHelper::debug('Загрузка страницы товара, пауза на 1 секунду...', $isConsole);
                    sleep(1);
                } catch (\Exception $e) {
                    ConsoleHelper::debug('Ошибка: '.$e->getMessage(), $isConsole);
                    continue;
                }

                $crawler = (new Crawler($html));

                $pageCatalogHeader = $crawler->filter('#catalog-element-before');
                $pageCatalogElement = $crawler->filter('div.bx-catalog-element');

                if ($pageCatalogHeader && $pageCatalogElement) {
                    $number = $pageCatalogElement->filter('div.element-top-info > div > b')->first()->text();

                    $lis = $pageCatalogHeader->filter('ul.breadcrumb > li')->each(function (Crawler $node, $i) {
                        return $node->text();
                    });

                    $characteristics = '';
                    foreach($pageCatalogElement->filter('table.content-table tr.product-item-detail-properties-item') as $context) {
                        $node = new Crawler($context);
                        $name = trim($node->filter('td.product-item-detail-properties-name')->first()->text());
//                        echo '$name = '.$name.PHP_EOL;

                        if ($name === self::CHARACTERISTICS_AUTOMOBILE) {
                            $characteristics = $node->filter('td.product-item-detail-properties-value')->first()->text();
                            break;
                        }
                    }

                    $article = [
                        'article' => $number,
                        'article_our' => ParserHelper::parseArticleNumber($number),
                        'brand' => trim($pageCatalogElement->filter('div.element-top-info > div > a')->first()->text()),
                        'title' => trim($pageCatalogElement->filter('h1')->first()->text()),
                        'description' => ParserHelper::parseDescription($pageCatalogElement->filter('div.prod-esc-text')->first()->text()),
                        'characteristics' => trim($characteristics),
                        'breadcrumbs' => implode(' / ', $lis),
                        'url' => $pageItem['href'],
                        'images' => [],
                    ];

                    $productSliderImagesContainer = $pageCatalogElement->filter('div.product-item-detail-slider-images-container');
                    if ($productSliderImagesContainer) {
                        $imgs = $productSliderImagesContainer->filter('div.product-item-detail-slider-image > img')->each(function (Crawler $node, $i) {
                            return self::AUTOVENTURI_RU_URL.$node->attr('src');
                        });

                        if (!empty($imgs)) {
                            $article['images'] = $imgs;
                        }
                    }

                    $articles[] = $article;
                }
            }

            ConsoleHelper::debug('Обработано '.count($articles).' товаров для рубрики "'.$item['name'].'"', $isConsole);
            ConsoleHelper::debug('Начинается сохранение обработанных товаров в БД и на диск...', $isConsole);

            $articlesSaved = $articlesNotSaved = 0;
            foreach ($articles as $article) {
                $model = new Parser();
                $model->type = Parser::TYPE_AUTOVENTURI;
                $model->article = $article['article'];
                $model->article_our = $article['article_our'];
                $model->title = $article['title'];
                $model->breadcrumbs = $article['breadcrumbs'];
                $model->url = $article['url'];
                $model->description = $article['description'];
                $model->brand = $article['brand'];
                $model->characteristics = $article['characteristics'];
                $model->article_1c = $model->country = $model->description_ext = $model->links = $model->length = $model->width = $model->height = $model->weight = null;

                if ($model->save(false)) {
                    $articlesSaved++;
                    $savedCount++;
                    if (!empty($article['images'])) {
                        $saved = 0;
                        $startNumber = self::IMAGE_START_NUMBER;

                        foreach ($article['images'] as $image) {
                            $ext = pathinfo($image, PATHINFO_EXTENSION);
                            $img = self::AUTOVENTURI_IMAGES_DIR.$article['article_our'].'__'.$startNumber++.'.'.$ext;

                            try {
                                $imgContent = file_get_contents($image);
                                ConsoleHelper::debug('Загрузка изображения, пауза на 1 секунду...', $isConsole);
                                sleep(1);
                            } catch (\Exception $e) {
                                ConsoleHelper::debug('Ошибка: '.$e->getMessage(), $isConsole);
                                continue;
                            }

                            $bytes = file_put_contents($img, $imgContent);
                            if ($bytes !== false) {
                                $saved++;
                                $savedImagesCount++;
                            }
                        }

//                        if ($saved) {
//                            ConsoleHelper::debug('Записано на диск '.$saved.' изображений для товара "'.$article['article_our'].'"', $isConsole);
//                        }
                    }
                } else {
                    $articlesNotSaved++;
                }
            }

            ConsoleHelper::debug('Сохранено '.$articlesSaved.' товаров для рубрики "'.$item['name'].'"', $isConsole);
            if ($articlesNotSaved) {
                ConsoleHelper::debug('[Внимание] Не сохранено '.$articlesNotSaved.' товаров для рубрики "'.$item['name'].'"', $isConsole);
            }
        }

//        ConsoleHelper::debug('Получено '.$rowsCount.' записей для таблицы '.PlanfixPartner::tableName(), $isConsole);
        ConsoleHelper::debug('[ИТОГ] Сохранено '.$savedCount.' записей в таблице '.ParserAutoventuri::tableName(), $isConsole);
        ConsoleHelper::debug('[ИТОГ] Записано '.$savedImagesCount.' изображений в папке '.self::AUTOVENTURI_IMAGES_DIR, $isConsole);

        $minutes = floor((time() - $totalTime) / 60);
        if ($minutes > 0) {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено минут: '.$minutes, $isConsole);
        } else {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено секунд: '.(time() - $totalTime), $isConsole);
        }

        return ExitCode::OK;
    }

    public function actionTriabc()
    {
        $db = \Yii::$app->db;
        $externalDb = \Yii::$app->db2;
        $totalTime = time();
        $isConsole = true;
        $rowsCount = $savedCount = $savedImagesCount = 0;
        $tableName = ParserTriabc::tableName();

        // Каталог
        $html = ParserHelper::getRemoteContent(self::TRIABC_RU_CATALOG_URL);
        if (empty($html)) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $crawler = (new Crawler($html));
        $rubricItems = $crawler->filter('div.primary-column ul.thumbnails li.sku-li')->each(function (Crawler $node, $i) {
            $url = $node->filter('a')->first()->attr('href');

            return [
                'url' => $url,
                'href' => self::TRIABC_RU_URL.$url,
                'name' => trim($node->filter('span.sku-card-name')->first()->text()),
            ];
        });

        ConsoleHelper::debug('Найдено рубрик: '.count($rubricItems), $isConsole);

        if ($rubricItems) {
            ConsoleHelper::deleteParserByType(Parser::TYPE_TRIABC, $isConsole);
        }

//        $rubricItems = [
//            [
//                'url' => '/catalog/4833/',
//                'href' => 'https://triabc.ru/catalog/4833/',
//                'name' => 'Набор автомобилиста',
//            ],
//        ];

        // Рубрики каталога
        foreach ($rubricItems as $item) {
            $html = ParserHelper::getRemoteContent($item['href']);
            if (empty($html)) {
                continue;
            }

            $pages = [
                $item['href'] => $html,
            ];
            $itemPages = [
                $item['url'] => $item['href'],
            ];

            $crawler->clear();
            $crawler->addHtmlContent($html);

            if ($crawler->filter('div.pagination > ul > li > a')->count()) {
                foreach($crawler->filter('div.pagination > ul > li > a') as $context) {
                    $node = new Crawler($context);
                    $href = $node->attr('href');
                    if ($href !== '#') {
                        $itemPages[$href] = self::TRIABC_RU_URL.$href;
                    }
                }

//                ConsoleHelper::debug('Найдено страниц на первой странице:', $isConsole);
//                print_r($itemPages);

                // Перебор пагинатора
                $cnt = 1;
                $prevLastPage = '';
                while (true) {
                    $lastPage = end($itemPages);
//                    ConsoleHelper::debug('$lastPage = '.$lastPage, $isConsole);

                    if (empty($lastPage) || $lastPage === $prevLastPage) {
//                        ConsoleHelper::debug('Break 1', $isConsole);
                        break;
                    }

                    $html = ParserHelper::getRemoteContent($lastPage);
                    if (empty($html)) {
                        ConsoleHelper::debug('Break 2', $isConsole);
                        break;
                    }

                    $pages[$lastPage] = $html;

                    $lastPageCrawler = new Crawler($html);

                    $index = 1;
                    foreach($lastPageCrawler->filter('div.pagination > ul > li > a') as $context) {
                        $node = new Crawler($context);
                        $href = $node->attr('href');
                        $name = $node->text();
                        if ($href === '#' && $node->closest('li')->attr('class') === 'active') {
                            if ($lastPageCrawler->filter('div.pagination > ul > li > a')->count() === $index) {
                                ConsoleHelper::debug('Break 444. End of pages!', $isConsole);
                                break;
                            }

                            continue;
                        }
                        if ($href !== '#' && $name !== '>>' && $name !== '<<') {
                            $itemPages[$href] = self::TRIABC_RU_URL.$href;
                        }

                        $index++;
                    }

                    $prevLastPage = $lastPage;
//                    ConsoleHelper::debug('$prevLastPage = '.$prevLastPage, $isConsole);

                    if ($cnt++ >= 1000) {
                        ConsoleHelper::debug('Count  '.$cnt.' break!', $isConsole);
                        break;
                    }
                }
            }

            ConsoleHelper::debug('Найдено '.count($itemPages).' страниц для рубрики "'.$item['name'].'"', $isConsole);

//            print_r($itemPages);
//            return ExitCode::OK;

            $itemPages = array_unique($itemPages);

            foreach ($itemPages as $href) {
                if (!isset($pages[$href])) {
                    $html = ParserHelper::getRemoteContent($href);
                    if (empty($html)) {
                        ConsoleHelper::debug('Контент страницы  '.$href.' пуст!', $isConsole);
                        continue;
                    }

                    $pages[$href] = $html;
                }
            }

            unset($itemPages);

//            file_put_contents('./_pages.log', print_r($pages, 1));

            //Страницы рубрики
            $pageItems = [];
            foreach ($pages as $html) {
                $crawler->clear();
                $crawler->addHtmlContent($html);

                $rows = $crawler->filter('#catalog-section-wrapper ul.thumbnails li.sku-li')->each(function (Crawler $node, $i) {
                    return [
                        'href' => self::TRIABC_RU_URL.$node->filter('a.sku-card')->first()->attr('href'),
                        'name' => trim($node->filter('span.sku-card-art')->first()->text()),
                    ];
                });

                $pageItems = ArrayHelper::merge($pageItems, $rows);
            }

            ConsoleHelper::debug('Найдено '.count($pageItems).' товаров для рубрики "'.$item['name'].'". Начинается обработка товаров...', $isConsole);

            // Товары рубрики
            $articles = [];
            $pageItemsCount = 0;
            foreach ($pageItems as $pageItem) {
                $html = ParserHelper::getRemoteContent($pageItem['href']);
                if (empty($html)) {
                    continue;
                }

                $crawler = (new Crawler($html));

                $pageCatalogElement = $crawler->filter('div.primary-column');

                if ($pageCatalogElement) {
                    $breadcrumbs = [];
                    foreach($pageCatalogElement->filter('ul.breadcrumb') as $context) {
                        $node = new Crawler($context);

                        $breadcrumb = [];
                        foreach($node->filter('li') as $context2) {
                            $node2 = new Crawler($context2);

                            $href = $node2->filter('a')->first()->attr('href');
                            if ($href !== '/') {
                                $breadcrumb[] = trim($node2->filter('a')->first()->text());
                            }
                        }

                        $breadcrumbs[] = implode(' / ', $breadcrumb);
                    }

                    $number = $brand = $description = '';
                    try {
                        foreach($pageCatalogElement->filter('div.span5 > ul.unstyled > li') as $context) {
                            $node = new Crawler($context);

                            $nodeName = $node->filter('div.properties-list__left')->text();
                            $nodeValue = $node->filter('div.properties-list__right')->text();
                            if ($nodeName === 'Артикул') {
                                $number = $nodeValue;
                            } elseif ($nodeName === 'БРЕНД') {
                                $brand = $nodeValue;
                            } else {
                                $description .= $nodeName.': '.$nodeValue.PHP_EOL;
                            }
                        }


                    } catch (\Exception $e) {
                        ConsoleHelper::debug('Ошибка: '.$pageItem['href'], $isConsole);
                        ConsoleHelper::debug('HTML: '.$html, $isConsole);
                        ConsoleHelper::debug('Exc: '.$e->getMessage(), $isConsole);

                        continue;
//                        return ExitCode::UNSPECIFIED_ERROR;
                    }

                    try {
                        $title = trim($pageCatalogElement->filter('h1.productName')->first()->text());
                    } catch (\Exception $e) {
                        $title = $number;
                    }

                    if ($pageCatalogElement->filter('div.compatibility-list')->count()) {
                        $description .= 'Подходит на: ';

                        foreach($pageCatalogElement->filter('div.compatibility-list > ul > li > a') as $context) {
                            $node = new Crawler($context);

                            $description .= trim($node->text()).PHP_EOL.PHP_EOL;
                        }
                    }

                    $article = [
                        'article' => $number,
                        'article_our' => ParserHelper::parseArticleNumber($number),
                        'brand' => trim($brand),
                        'title' => $title,
                        'description' => $description,
                        'breadcrumbs' => implode(PHP_EOL, $breadcrumbs),
                        'url' => $pageItem['href'],
                        'images' => [],
                    ];

                    $imgs = $pageCatalogElement->filter('div.span7 a.fancyme')->each(function (Crawler $node, $i) {
                        return self::TRIABC_RU_URL.$node->attr('href');
                    });

                    if (!empty($imgs)) {
                        $article['images'] = $imgs;
                    }

                    $articles[] = $article;
                }

                $pageItemsCount++;

                if ($pageItemsCount >= 1000 && $pageItemsCount % 1000 === 0) {
                    ConsoleHelper::debug('Обработано '.$pageItemsCount.' товаров из '.count($pageItems), $isConsole);
                }
            }

            ConsoleHelper::debug('Обработано '.count($articles).' товаров для рубрики "'.$item['name'].'"', $isConsole);
            if (!$articles) {
                continue;
            }
            ConsoleHelper::debug('Начинается сохранение обработанных товаров в БД и на диск...', $isConsole);

            $articlesSaved = $articlesNotSaved = $articlesCount = 0;
            foreach ($articles as $article) {
                $model = new Parser();
                $model->type = Parser::TYPE_TRIABC;
                $model->article = $article['article'];
                $model->article_our = $article['article_our'];
                $model->title = $article['title'];
                $model->breadcrumbs = $article['breadcrumbs'];
                $model->url = $article['url'];
                $model->description = $article['description'];
                $model->brand = $article['brand'];
                $model->characteristics = $model->article_1c = $model->country = $model->description_ext = $model->links = $model->length = $model->width = $model->height = $model->weight = null;

                if ($model->save(false)) {
                    $articlesSaved++;
                    $savedCount++;
                    if (!empty($article['images'])) {
                        $startNumber = self::IMAGE_START_NUMBER;

                        foreach ($article['images'] as $image) {
                            $ext = pathinfo($image, PATHINFO_EXTENSION);
                            $img = self::TRIABC_IMAGES_DIR.$article['article_our'].'__'.$startNumber++.'.'.$ext;

                            if (file_exists($img)) {
                                continue;
                            }

                            $imgContent = ParserHelper::getRemoteContent($image);
                            if (empty($imgContent)) {
                                continue;
                            }

                            $bytes = file_put_contents($img, $imgContent);
                            if ($bytes !== false) {
                                $savedImagesCount++;
                            }
                        }

//                        if ($saved) {
//                            ConsoleHelper::debug('Записано на диск '.$saved.' изображений для товара "'.$article['article_our'].'"', $isConsole);
//                        }
                    }
                } else {
                    $articlesNotSaved++;
                }

                $articlesCount++;

                if ($articlesCount >= 1000 && $articlesCount % 1000 === 0) {
                    ConsoleHelper::debug('Сохранено '.$articlesCount.' товаров из '.count($articles), $isConsole);
                }
            }

            ConsoleHelper::debug('Сохранено '.$articlesSaved.' товаров для рубрики "'.$item['name'].'"', $isConsole);
            if ($articlesNotSaved) {
                ConsoleHelper::debug('[Внимание] Не сохранено '.$articlesNotSaved.' товаров для рубрики "'.$item['name'].'"', $isConsole);
            }
        }

//        ConsoleHelper::debug('Получено '.$rowsCount.' записей для таблицы '.PlanfixPartner::tableName(), $isConsole);
        ConsoleHelper::debug('[ИТОГ] Сохранено '.$savedCount.' записей в таблице '.$tableName, $isConsole);
        ConsoleHelper::debug('[ИТОГ] Записано '.$savedImagesCount.' изображений в папке '.self::TRIABC_IMAGES_DIR, $isConsole);

        $minutes = floor((time() - $totalTime) / 60);
        if ($minutes > 0) {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено минут: '.$minutes, $isConsole);
        } else {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено секунд: '.(time() - $totalTime), $isConsole);
        }

        return ExitCode::OK;
    }

    public function actionDaliavto()
    {
        $db = \Yii::$app->db;
        $externalDb = \Yii::$app->db2;
        $totalTime = time();
        $isConsole = true;
        $rowsCount = $savedCount = $savedImagesCount = 0;
        $tableName = ParserDaliavto::tableName();

        // Каталог
        $html = ParserHelper::getRemoteContent(self::DALIAVTO_RU_CATALOG_URL);
        if (empty($html)) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $crawler = (new Crawler($html));

        $rubricItems = [];
        foreach($crawler->filter('#block-menu-secondary-links .dali-vmenublockcontent ul.dali-vmenu > li') as $context) {
            $node = new Crawler($context);

            $isExpanded = $node->attr('class') === 'expanded';
            if (!$isExpanded) {
                $url = $node->filter('a')->attr('href');

                $rubricItems[$url] = [
                    'url' => $url,
                    'href' => self::DALIAVTO_RU_URL . $url,
                    'name' => trim($node->filter('a')->text()),
                ];
            } else {
                foreach($node->filter('ul > li') as $context2) {
                    $node2 = new Crawler($context2);
                    $url = $node2->filter('a')->attr('href');

                    if ($node2->attr('class') === 'collapsed') {
                        $html3 = ParserHelper::getRemoteContent(self::DALIAVTO_RU_URL . $url);
                        if (empty($html3)) {
                            continue;
                        }

                        $crawler3 = (new Crawler($html3));
                        foreach($crawler3->filter('#block-menu-secondary-links .dali-vmenublockcontent ul.dali-vmenu li') as $context3) {
                            $node3 = new Crawler($context3);
                            $url3 = $node3->filter('a')->attr('href');

                            if ($url3 === $url) {
                                foreach($node3->filter('ul > li') as $context4) {
                                    $node4 = new Crawler($context4);
                                    $url4 = $node4->filter('a')->attr('href');

                                    $rubricItems[$url4] = [
                                        'url' => $url4,
                                        'href' => self::DALIAVTO_RU_URL . $url4,
                                        'name' => trim($node4->filter('a')->text()),
                                    ];
                                }
                            }
                        }
                    } elseif ($node2->attr('class') !== 'expanded') {
                        $rubricItems[$url] = [
                            'url' => $url,
                            'href' => self::DALIAVTO_RU_URL . $url,
                            'name' => trim($node2->filter('a')->text()),
                        ];
                    }
                }
            }
        }

        ConsoleHelper::debug('Найдено рубрик: ' . count($rubricItems), $isConsole);

//        print_r($rubricItems);
//        return ExitCode::OK;

        if ($rubricItems) {
            ConsoleHelper::deleteParserByType(Parser::TYPE_DALIAVTO, $isConsole);
        }

//        $rubricItems = [
//            [
//                'href' => 'http://www.dali-avto.ru/kategoriya/bryzgoviki',
//            ],
//        ];


        $index = $articleIndex = 1;
        foreach ($rubricItems as $rubricItem) {
            $articles = [];
            $html = ParserHelper::getRemoteContent($rubricItem['href']);
            if (empty($html)) {
                continue;
            }

            $crawler = (new Crawler($html));

            //Товары рубрики
            $items = [];
            foreach($crawler->filter('table.views-view-grid td') as $context) {
                $node = new Crawler($context);

                try {
                    $items[] = [
                        'href' => self::DALIAVTO_RU_URL.$node->filter('a')->first()->attr('href'),
                        'name' => trim($node->filter('span.field-content > a')->first()->text()),
                    ];
                } catch (\Exception $e) {
                    continue;
                }
            }

            ConsoleHelper::debug('['.$index++.'] Рубрика "'.$rubricItem['name'].'" ('.$rubricItem['url'].'), найдено товаров: '.count($items).', идет процесс их получения и обработки...', $isConsole);

//            $items[] = [
//                'href' => 'http://www.dali-avto.ru/poduct/bryzgoviki/bryzgovik-350520-daf-rezina-obemnyi-belaya-nadpis-k-t',
//                'name' => 'Брызговик 350*520 DAF, резина, объемный, белая надпись, к-т',
//            ];
//
//            $items[] = [
//                'href' => 'http://www.dali-avto.ru/poduct/prochie-prinadlezhnosti/bashmak-protivootkatnyi-200-mm',
//                'name' => 'Башмак противооткатный 200 мм (Россия) желтый',
//            ];


//            print_r($items);

            foreach ($items as $item) {
                $html = ParserHelper::getRemoteContent($item['href']);
                if (empty($html)) {
                    continue;
                }

                $crawler = (new Crawler($html));

                $breadcrumbs = [];
                foreach($crawler->filter('div.breadcrumb > a') as $context) {
                    $node = new Crawler($context);

                    $breadcrumbs[] = $node->text();
                }

//                $text = $crawler->filter('div#node > table > tbody > tr > td')->count();//last()->text();
                $text = trim($crawler->filter('div#node > table > tr > td')->last()->text());
                preg_match('/^Код:(.*)\n/ui', $text, $matches);
                $articleNumber = !empty($matches[1]) ? trim($matches[1]) : null;

                if (!$articleNumber) {
                    ConsoleHelper::debug('Артикул не определился, товар пропущен. УРЛ: '.$item['href']);
                    continue;
                }

                $article = [
                    'article' => $articleNumber,
                    'article_our' => ParserHelper::parseArticleNumber($articleNumber),
                    'title' => trim($crawler->filter('#node > h1')->first()->text()),
                    'breadcrumbs' => implode(' / ', $breadcrumbs),
                    'url' => $item['href'],
                    'images' => [],
                ];

                $imgs = [];
                $imgs[] = $crawler->filter('#image > a')->attr('href');

                if ($crawler->filter('div#node > table > tr > td')->eq(1)->filter('div > a')->count()) {
                    foreach ($crawler->filter('div#node > table > tr > td')->eq(1)->filter('div > a') as $context) {
                        $node = new Crawler($context);

                        $imgs[] = self::DALIAVTO_RU_URL.$node->attr('href');
                    }
                }

                if (!empty($imgs)) {
                    $article['images'] = $imgs;
                }

                $articles[] = $article;
            }

            ConsoleHelper::debug('Обработано '.count($articles).' товаров', $isConsole);
            ConsoleHelper::debug('Начинается сохранение обработанных товаров в БД и на диск...', $isConsole);

            //            file_put_contents('./_articles.log', print_r($articles, 1));

            $articlesSaved = $articlesNotSaved = $articlesCount = 0;
            foreach ($articles as $article) {
                $model = new Parser();
                $model->type = Parser::TYPE_DALIAVTO;
                $model->article = $article['article'];
                $model->article_our = $article['article_our'];
                $model->title = $article['title'];
                $model->breadcrumbs = $article['breadcrumbs'];
                $model->url = $article['url'];
                $model->brand = $model->description = $model->characteristics = $model->article_1c = $model->country = $model->description_ext = $model->links = $model->length = $model->width = $model->height = $model->weight = null;

                if ($model->save(false)) {
                    $articlesSaved++;
                    $savedCount++;
                    if (!empty($article['images'])) {
                        $startNumber = self::IMAGE_START_NUMBER;

                        foreach ($article['images'] as $image) {
                            $ext = pathinfo($image, PATHINFO_EXTENSION);
                            $img = self::DALIAVTO_IMAGES_DIR.$article['article_our'].'__'.$startNumber++.'.'.$ext;

                            if (file_exists($img)) {
                                continue;
                            }

                            $imgContent = ParserHelper::getRemoteContent($image);
                            if (empty($imgContent)) {
                                continue;
                            }

                            $bytes = file_put_contents($img, $imgContent);
                            if ($bytes !== false) {
                                $savedImagesCount++;
                            }
                        }
                    }
                } else {
                    $articlesNotSaved++;
                    ConsoleHelper::debug('[Внимание] Не сохранен товар '.print_r($article, true).', '.print_r($model->getErrors(), true), $isConsole);
                }

                $articlesCount++;

                if ($articlesCount >= 50 && $articlesCount % 50 === 0) {
                    ConsoleHelper::debug('Сохранено '.$articlesCount.' товаров из '.count($articles), $isConsole);
                }
            }

            ConsoleHelper::debug('Сохранено '.$articlesSaved.' товаров', $isConsole);
            if ($articlesNotSaved) {
                ConsoleHelper::debug('[Внимание] Не сохранено '.$articlesNotSaved.' товаров', $isConsole);
            }
        }

        $minutes = floor((time() - $totalTime) / 60);
        if ($minutes > 0) {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено минут: '.$minutes, $isConsole);
        } else {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено секунд: '.(time() - $totalTime), $isConsole);
        }

        return ExitCode::OK;
    }

    public function actionRivalauto()
    {
        $db = \Yii::$app->db;
        $externalDb = \Yii::$app->db2;
        $totalTime = time();
        $isConsole = true;
        $rowsCount = $savedCount = $savedImagesCount = 0;
        $tableName = Parser::tableName();

        // Каталог
        $html = ParserHelper::getRemoteContent(self::RIVALAUTO_RU_CATALOG_URL);
        if (empty($html)) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $crawler = (new Crawler($html));

        $rubricItems = [];
        foreach($crawler->filter('ul.about2 > li > a') as $context) {
            $node = new Crawler($context);
            $url = $node->attr('href');

            $rubricItems[$url] = [
                'href' => self::RIVALAUTO_RU_URL . $url,
                'name' => trim($node->text()),
            ];
        }

        ConsoleHelper::debug('Найдено рубрик: ' . count($rubricItems), $isConsole);

//        print_r($rubricItems);
//        return ExitCode::OK;

        if ($rubricItems) {
            ConsoleHelper::deleteParserByType(Parser::TYPE_RIVALAUTO, $isConsole);
        }


        /*$rubricItems = [
            [
                'href' => 'https://rivalauto.ru/catalog/chehly',
                'name' => 'Чехлы',
            ],
        ];
        */

        $index = $articleIndex = 1;
        foreach ($rubricItems as $rubricItem) {
            $html = ParserHelper::getRemoteContent($rubricItem['href']);
            if (empty($html)) {
                continue;
            }

            $crawler = (new Crawler($html));

            //Бренды рубрики
            $brands = [];
            foreach($crawler->filter('div.center a') as $context) {
                $node = new Crawler($context);

                try {
                    $brands[] = [
                        'href' => self::RIVALAUTO_RU_URL . $node->attr('href'),
                        'name' => trim($node->text()),
                    ];
                } catch (\Exception $e) {
                    continue;
                }
            }

            ConsoleHelper::debug('['.$index.'] Рубрика "'.$rubricItem['name'].'", найдено брендов: '.count($brands), $isConsole);

//            print_r($brands);
//            return ExitCode::OK;

//            $brands[] = [
//                'href' => 'http://www.dali-avto.ru/poduct/bryzgoviki/bryzgovik-350520-daf-rezina-obemnyi-belaya-nadpis-k-t',
//                'name' => 'Брызговик 350*520 DAF, резина, объемный, белая надпись, к-т',
//            ];
//
//            $brands[] = [
//                'href' => 'http://www.dali-avto.ru/poduct/prochie-prinadlezhnosti/bashmak-protivootkatnyi-200-mm',
//                'name' => 'Башмак противооткатный 200 мм (Россия) желтый',
//            ];

            $brandIndex = 1;
            //Товары бренда рубрики
            foreach($brands as $brand) {
                $articles = $items = [];
                $html = ParserHelper::getRemoteContent($brand['href']);
                if (empty($html)) {
                    ConsoleHelper::debug('Страница бренда не загрузилась. [Пропущено]. УРЛ: '.$brand['href']);
                    continue;
                }

                $crawler = (new Crawler($html));

                foreach($crawler->filter('div.center > div.cat3 > div > a') as $context) {
                    $node = new Crawler($context);

                    $items[] = self::RIVALAUTO_RU_URL . $node->attr('href');
                }

                ConsoleHelper::debug('['.$index.'-'.$brandIndex.'] Бренд "'.$brand['name'].'", найдено товаров: '.count($items).', идет процесс их получения и обработки...', $isConsole);

                if (!$items) {
                    if ($crawler->filter('div.center > div.cat3')->count()) {
                        file_put_contents('./'.$index.'-'.$brandIndex.'.log', $crawler->filter('div.center > div.cat3')->html());
                        ConsoleHelper::debug('Данные записаны в файл: '.'./'.$index.'-'.$brandIndex.'.log', $isConsole);
                    } else {
                        ConsoleHelper::debug('Список товаров ПУСТ!', $isConsole);
                    }
                }

//                print_r($items);
//                return ExitCode::OK;

                foreach ($items as $item) {
                    $html = ParserHelper::getRemoteContent($item);
                    if (empty($html)) {
                        ConsoleHelper::debug('Страница товара не загрузилась. [Пропущено]. УРЛ: '.$item);
                        continue;
                    }

                    $crawler = (new Crawler($html));

                    $breadcrumbs = [];
                    foreach($crawler->filter('div.breadcrumbs > a') as $context) {
                        $node = new Crawler($context);

                        $breadcrumbs[] = $node->text();
                    }
                    $breadcrumbs[] = $crawler->filter('#center > div.breadcrumbs > span')->text();

                    $articleNumber = $crawler->filter('td#article')->text();
                    if (!$articleNumber) {
                        ConsoleHelper::debug('Артикул не определился, товар пропущен. УРЛ: '.$item);
                        continue;
                    }

                    $length = $width = $height = $weight = 0;
                    $tableNode = $crawler->filter('#center > div.content-wrap > table')->eq(1);
                    if ($tableNode) {
                        $tdIndex = 0;
                        foreach($tableNode->filter('td') as $context) {
                            $node = new Crawler($context);
                            switch ($tdIndex) {
                                case 0:
                                    $length = ParserHelper::parseFloat($node->html());
                                    break;
                                case 1:
                                    $width = ParserHelper::parseFloat($node->text());
                                    break;
                                case 2:
                                    $height = ParserHelper::parseFloat($node->text());
                                    break;
                                case 3:
                                    $weight = ParserHelper::parseFloat($node->text());
                                    break;
                            }

                            $tdIndex++;
                        }
                    }

                    $link = '';
                    if ($crawler->filter('#center > div.content-wrap > a')->count()) {
                        $lastLink = $crawler->filter('#center > div.content-wrap > a')->last();
                        if ($lastLink->text() === 'Инструкция') {
                            $link = self::RIVALAUTO_RU_URL . $lastLink->attr('href');
                        }
                    }

                    $article = [
                        'breadcrumbs' => implode(' / ', $breadcrumbs),
                        'title' => trim($crawler->filter('h1.title')->first()->text()),
                        'article' => $articleNumber,
                        'article_our' => ParserHelper::parseArticleNumber($articleNumber),
                        'url' => $item,
                        'length' => $length,
                        'width' => $width,
                        'height' => $height,
                        'weight' => $weight,
                        'links' => $link,

                        'images' => [],
                    ];

                    $imgs = [];
                    if ($crawler->filter('#center > div.content-wrap > a > img')->count()) {
                        foreach ($crawler->filter('#center > div.content-wrap > a > img') as $context) {
                            $node = new Crawler($context);

                            $imgs[] = self::RIVALAUTO_RU_URL . $node->closest('a')->attr('href');
                        }
                    }
                    $article['images'] = $imgs;

                    $articles[] = $article;
                }

                $brandIndex++;

                ConsoleHelper::debug('Получено и обработано '.count($articles).' товаров', $isConsole);
                ConsoleHelper::debug('Начинается сохранение обработанных товаров в БД и на диск...', $isConsole);

                $articlesSaved = $articlesNotSaved = $articlesCount = 0;
                foreach ($articles as $article) {
                    $model = new Parser();
                    $model->type = Parser::TYPE_RIVALAUTO;
                    $model->article = $article['article'];
                    $model->article_our = $article['article_our'];
                    $model->title = $article['title'];
                    $model->breadcrumbs = $article['breadcrumbs'];
                    $model->url = $article['url'];
                    $model->links = $article['links'];
                    $model->length = $article['length'];
                    $model->width = $article['width'];
                    $model->height = $article['height'];
                    $model->weight = $article['weight'];
                    $model->article_1c = $model->brand = $model->country = $model->description = $model->description_ext = $model->characteristics = null;

                    if ($model->save(false)) {
                        $articlesSaved++;
                        $savedCount++;
                        if (!empty($article['images'])) {
                            $startNumber = self::IMAGE_START_NUMBER;

                            foreach ($article['images'] as $image) {
                                $ext = pathinfo($image, PATHINFO_EXTENSION);
                                $img = self::RIVALAUTO_IMAGES_DIR.$article['article_our'].'__'.$startNumber++.'.'.$ext;

                                if (file_exists($img)) {
                                    continue;
                                }

                                $imgContent = ParserHelper::getRemoteContent($image);
                                if (empty($imgContent)) {
                                    continue;
                                }

                                $bytes = file_put_contents($img, $imgContent);
                                if ($bytes !== false) {
                                    $savedImagesCount++;
                                }
                            }
                        }
                    } else {
                        $articlesNotSaved++;
                        ConsoleHelper::debug('[Внимание] Не сохранен товар '.print_r($article, true).', '.print_r($model->getErrors(), true), $isConsole);
                    }

                    $articlesCount++;

                    if ($articlesCount >= 50 && $articlesCount % 50 === 0) {
                        ConsoleHelper::debug('Сохранено '.$articlesCount.' товаров из '.count($articles), $isConsole);
                    }
                }

                ConsoleHelper::debug('Сохранено '.$articlesSaved.' товаров', $isConsole);
                if ($articlesNotSaved) {
                    ConsoleHelper::debug('[Внимание] Не сохранено '.$articlesNotSaved.' товаров', $isConsole);
                }
            }

            $index++;
        }

        ConsoleHelper::debug('ВСЕГО сохранено '.$savedCount.' товаров', $isConsole);
        ConsoleHelper::debug('ВСЕГО загружено '.$savedImagesCount.' изображений', $isConsole);

        $minutes = floor((time() - $totalTime) / 60);
        if ($minutes > 0) {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено минут: '.$minutes, $isConsole);
        } else {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено секунд: '.(time() - $totalTime), $isConsole);
        }

        return ExitCode::OK;
    }

    public function actionUpload()
    {
        $db = \Yii::$app->db;
        $tableName = Parser::tableName();

        /** @var \yii\db\Connection $externalDb */
        $externalDb = \Yii::$app->db2;
        $externalTableName = '{{shop.parser}}';

        $isConsole = true;
        $rowsCount = 0;

        $time = time();
        $query = (new Query())->from($tableName);
        $queryCount = clone $query;
        if ($queryCount->count('*', $db) > 0) {
            foreach ($query->batch(ConsoleHelper::BATCH_LIMIT, $db) as $rows) {
                $count = $externalDb->createCommand()->batchInsert($externalTableName,
                    ['id', 'type', 'article', 'article_our', 'article_1c', 'title', 'url', 'brand', 'country', 'description', 'description_ext', 'characteristics', 'links', 'breadcrumbs', 'length', 'width', 'height', 'weight', 'created_at', 'updated_at',],
                    $rows)->execute();

                ConsoleHelper::debug('Вставлено ' . $count . ' записей в таблицу ' . $externalTableName, $isConsole);
                $rowsCount += $count;
            }

            ConsoleHelper::debug('Всего вставлено ' . $rowsCount . ' записей в таблицу ' . $externalTableName, $isConsole);
        }

        ConsoleHelper::debug('Затрачено ' . (time() - $time) . ' секунд при работе с таблицей ' . $externalTableName, $isConsole);
        ConsoleHelper::debug(PHP_EOL, $isConsole);

        return ExitCode::OK;
    }


    /**
     * https://proverkacheka.com/check
     *
     * @return int
     */
    public function actionProverkacheka()
    {
        $pagesTotal = 2000;
        $totalTime = time();
        $isConsole = true;
        $rowsCount = $savedCount = $notSavedCount = $savedImagesCount = 0;
        $pageItems = [];

        foreach (range(1, $pagesTotal) as $pageNumber) {
            $html = ParserHelper::getRemoteContent(self::PROVERKACHEKA_RU_CHECK_URL.$pageNumber);
            if (empty($html)) {
                ConsoleHelper::debug('Страница чеков #'.$pageNumber.' не загрузилась. [Пропущено]. УРЛ: ' . self::PROVERKACHEKA_RU_CHECK_URL.$pageNumber);
                continue;
            }

            $crawler = (new Crawler($html));

            foreach ($crawler->filter('table.table > tbody > tr > td > a') as $context) {
                $node = new Crawler($context);
                $url = $node->attr('href');

                $number = $node->closest('tr')->filter('td')->first()->text();

                $pageItems[$url] = [
                    'href' => self::PROVERKACHEKA_RU_URL . $url,
                    'number' => $number,
                ];
            }

            if ($pageNumber >= 500 && $pageNumber % 500 === 0) {
                ConsoleHelper::debug('Получены '.$pageNumber.' страниц с чеками из '.$pagesTotal, $isConsole);
            }
        }

//        $pageItems['/check/1376467-616e945d'] = [
//            'href' => self::PROVERKACHEKA_RU_URL . '/check/1376467-616e945d',
//            'number' => 1376467,
//        ];
//        $pageItems['/check/1374697-b0d0f1ad'] = [
//            'href' => self::PROVERKACHEKA_RU_URL . '/check/1374697-b0d0f1ad',
//            'number' => 1374697,
//        ];
//        $pageItems['/check/1320553-30a7a769'] = [
//            'href' => self::PROVERKACHEKA_RU_URL . '/check/1320553-30a7a769',
//            'number' => 1320553,
//        ];
//        $pageItems['/check/1287615-54404d6b'] = [
//            'href' => self::PROVERKACHEKA_RU_URL . '/check/1287615-54404d6b',
//            'number' => 1287615,
//        ];
//        $pageItems['/check/1274754-2f8d3d7d'] = [
//            'href' => self::PROVERKACHEKA_RU_URL . '/check/1274754-2f8d3d7d',
//            'number' => 1274754,
//        ];
//        $pageItems['/check/1263369-11fa7469'] = [
//            'href' => self::PROVERKACHEKA_RU_URL . '/check/1263369-11fa7469',
//            'number' => 1263369,
//        ];

        ConsoleHelper::debug('Найдено чеков: ' . count($pageItems), $isConsole);

        $checks = [];
        foreach ($pageItems as $pageItem) {
            $url = $pageItem['href'];
            $number = $pageItem['number'];

            $html = ParserHelper::getRemoteContent($url);
            if (empty($html)) {
                ConsoleHelper::debug('Страница чека не загрузилась. [Пропущено]. УРЛ: ' . $url);
                continue;
            }

            $crawler = (new Crawler($html));

            ConsoleHelper::debug('Count: '.$crawler->filter('table.table > tbody > tr > td')->count(), $isConsole);


            $inn = $type = $qrCode = '';
            $total = 0;
            $isTotal = false;
            foreach ($crawler->filter('table.table > tbody > tr > td') as $context) {
                $node = new Crawler($context);
                $nodeText = $node->text();

                ConsoleHelper::debug('Text: '.$nodeText, $isConsole);

                if (mb_substr($nodeText, 0, 3) === 'ИНН') { //ИНН 672708541562
                    $inn = trim(mb_substr($nodeText, 4));
                }

                if ($isTotal) {
                    $type = $nodeText;
                    $isTotal = false;
                }

                if ($node->attr('class') === 'b-check_itogo' && $nodeText !== 'ИТОГО:') {
                    $total = (float) $nodeText;
                    $isTotal = true;
                }

                if ($node->filter('img')->count()) {
                    $qrCode = $node->filter('img')->first()->attr('src');
                }
            }

            if ($inn && $type && $qrCode) {
                $checks[] = [
                    'number' => $number,
                    'inn' => $inn,
                    'total' => $total,
                    'type' => $type,
                    'qrcode' => self::PROVERKACHEKA_RU_URL . $qrCode,
                    'url' => $url,
                ];

                $rowsCount++;

                if ($rowsCount >= 500 && $rowsCount % 500 === 0) {
                    ConsoleHelper::debug('Получены '.$rowsCount.' чеков из '.count($pageItems), $isConsole);
                }
            } else {
                ConsoleHelper::debug('Часть данных не найдена на странице '.$url.'. ИНН: '.$inn.', итого:'.$total.', оплата: '.$type.', QR-код: '.$qrCode);
            }
        }

        ConsoleHelper::debug('=====================================================================', $isConsole);

        ConsoleHelper::debug('Получено и обработано '.$rowsCount.' из '.count($pageItems).' чеков', $isConsole);
        ConsoleHelper::debug('Начинается сохранение обработанных чеков в БД и на диск...', $isConsole);

        if ($checks) {
            ConsoleHelper::debug('Очистка таблицы '.ParserProverkacheka::tableName(), $isConsole);
            ParserProverkacheka::deleteAll([]);
        }

        foreach ($checks as $check) {
            $model = new ParserProverkacheka();
            $model->number = $check['number'];
            $model->inn = $check['inn'];
            $model->total = $check['total'];
            $model->type = $check['type'];

            if ($model->save(false)) {
                $savedCount++;

                $img = self::PROVERKACHEKA_RU_IMAGES_DIR.$check['number'].'.svg';

                if (file_exists($img)) {
                    continue;
                }

                $imgContent = ParserHelper::getRemoteContent($check['qrcode']);
                if (empty($imgContent)) {
                    continue;
                }

                $bytes = file_put_contents($img, $imgContent);
                if ($bytes !== false) {
                    $savedImagesCount++;
                }
            } else {
                ConsoleHelper::debug('[Внимание] Не сохранен чек '.print_r($check, true).', '.print_r($model->getErrors(), true), $isConsole);
                $notSavedCount++;
            }

            if ($savedCount >= 500 && $savedCount % 500 === 0) {
                ConsoleHelper::debug('Сохранено '.$savedCount.' чеков из '.count($checks), $isConsole);
            }
        }

        ConsoleHelper::debug('ВСЕГО сохранено '.$savedCount.' товаров', $isConsole);
        if ($notSavedCount) {
            ConsoleHelper::debug('[Внимание] Не сохранено '.$notSavedCount.' чеков', $isConsole);
        }
        ConsoleHelper::debug('ВСЕГО загружено '.$savedImagesCount.' изображений', $isConsole);

        ConsoleHelper::debug('=====================================================================', $isConsole);

        $minutes = floor((time() - $totalTime) / 60);
        if ($minutes > 0) {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено минут: '.$minutes, $isConsole);
        } else {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено секунд: '.(time() - $totalTime), $isConsole);
        }

        return ExitCode::OK;
    }

    /**
     * @param string $href
     *
     * @return string
     */
    private function _getUrl(string $href) : string
    {
        return substr(strrchr($href, "/"), 1);
    }

    /**
     * @param string $href
     *
     * @return string
     */
    private function _getPath(string $href) : string
    {
        return substr($href, strlen('/katalog'));
    }

    /**
     * @param string      $url
     * @param string|null $parent_url
     *
     * @return array || null
     */
    private function _getRubricModel(string $url, string $parent_url = null) : ?array
    {
        return ParserLrpartsRubrics::find()->where(['url' => $url, 'parent_url' => $parent_url,])->asArray()->one();
    }

    /**
     * @param string $url
     * @param int    $rubricID
     *
     * @return array || null
     */
    private function _getRubricItemModel(string $url, int $rubricID) : ?array
    {
        return ParserLrpartsItems::find()->where(['url' => $url, 'rubric_id' => $rubricID,])->asArray()->one();
    }

    /**
     * https://lrparts.ru/katalog
     *
     * @return bool|int
     *
     * @throws \PHPHtmlParser\Exceptions\ChildNotFoundException
     * @throws \PHPHtmlParser\Exceptions\CircularException
     * @throws \PHPHtmlParser\Exceptions\ContentLengthException
     * @throws \PHPHtmlParser\Exceptions\LogicalException
     * @throws \PHPHtmlParser\Exceptions\NotLoadedException
     * @throws \PHPHtmlParser\Exceptions\StrictException
     */
    public function actionLrparts()
    {
        $totalTime = time();
        $isConsole = true;
        $rowsCount = $savedCount = $notSavedCount = $savedImagesCount = 0;
        $pageItems = [];
        $rubricItems = [];

        // Каталог
        $html = ParserHelper::getRemoteContent(self::LRPARTS_RU_CATALOG_URL);
        if (empty($html)) {
            ConsoleHelper::debug('Страница каталога не загрузилась. [Пропущено]. УРЛ: '.self::LRPARTS_RU_CATALOG_URL, $isConsole, true);

            return false;
        }

        $dom = new Dom;
        $dom->loadStr($html);
        /** @var AbstractNode $content */
        foreach ($dom->find('div.category-view > div.row > div.category > div.spacer > h2 > a') as $content) {
            $href = $content->getAttribute('href');
            $title = $content->getAttribute('title');
            $imgSrc = '';

            if (count($content->find('img'))) {
                $img = $content->find('img')[0];
                $imgSrc = $img->getAttribute('src');
            }

            $rubricItems[] = [
                'id' => 0,
                'parent_id' => 0,
                'name' => trim($title),
                'url' => $this->_getUrl($href),
                'path' => $this->_getPath($href),
                'parent_url' => null,
                'is_last' => false,
                'href' => self::LRPARTS_RU_URL . $href,
                'img' => self::LRPARTS_RU_URL . $imgSrc,
                'children' => [],
            ];
        }

        ConsoleHelper::debug('Найдено основных рубрик: ' . count($rubricItems), $isConsole);

//        print_r($rubricItems);

        $processedRubrics = ParserLrpartsRubricsProcessed::find()->asArray()->indexBy('url')->all();

        if (count($rubricItems) > 0 && count($rubricItems) === count($processedRubrics)) {
            ParserLrpartsRubricsProcessed::deleteAll([]);
        }

        foreach ($rubricItems as $i => $rubricItem) {
            if (!isset($processedRubrics[$rubricItem['url']])) {
                ConsoleHelper::debug('=====================================================================', $isConsole);
                ConsoleHelper::debug('=====================================================================', $isConsole);
                ConsoleHelper::debug('=====================================================================', $isConsole);
                ConsoleHelper::debug('РУБРИКА: '.$rubricItem['url'], $isConsole);
                ConsoleHelper::debug('=====================================================================', $isConsole);
                ConsoleHelper::debug('=====================================================================', $isConsole);
                ConsoleHelper::debug('=====================================================================', $isConsole);
                $rubricItems[$i] = $this->_getRubricDataLrparts2($rubricItem);
                $rubricItems[$i] = $this->_processRubricDataLrparts2($rubricItem, []);

                $processed = new ParserLrpartsRubricsProcessed();
                $processed->url = $rubricItem['url'];
                $processed->save();
            } else {
                ConsoleHelper::debug('Рубрика "'.$rubricItem['url'].'" уже импортирована, пропуск...', $isConsole, true);
            }

//            break;
        }

        \Yii::$app->cache->delete(ParserHelper::CACHE_KEY_LRPARTS);

        ConsoleHelper::debug('=====================================================================', $isConsole);
        ConsoleHelper::debug('[ИТОГ] Создано новых рубрик: '.$this->_newRubricsCount, $isConsole);
        ConsoleHelper::debug('[ИТОГ] Загружено изображений рубрик: '.$this->_rubricImagesCount, $isConsole);
        ConsoleHelper::debug('[ИТОГ] Создано новых товаров: '.$this->_newItemsCount, $isConsole);

        $minutes = floor((time() - $totalTime) / 60);
        if ($minutes > 0) {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено минут: '.$minutes, $isConsole);
        } else {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено секунд: '.(time() - $totalTime), $isConsole);
        }

        return ExitCode::OK;
    }

    /**
     * @param array $rubric
     *
     * @return array
     * @throws \PHPHtmlParser\Exceptions\ChildNotFoundException
     * @throws \PHPHtmlParser\Exceptions\CircularException
     * @throws \PHPHtmlParser\Exceptions\ContentLengthException
     * @throws \PHPHtmlParser\Exceptions\LogicalException
     * @throws \PHPHtmlParser\Exceptions\NotLoadedException
     * @throws \PHPHtmlParser\Exceptions\StrictException
     */
    private function _getRubricDataLrparts2(array &$rubric)
    {
        $html = ParserHelper::getRemoteContent($rubric['href']);
        if (empty($html)) {
            ConsoleHelper::debug('Страница рубрики не загрузилась. [Пропущено]. УРЛ: '.$rubric['path'], true, true);

            return [];
        }

        ConsoleHelper::debug('Страница рубрики '.$rubric['path'].' загружена');

        $dom = new Dom;
        $dom->loadStr($html);
        $nodes = $dom->find('div.category-view > div.row > div.category > div.spacer > h2 > a');

        if (count($nodes)) { //Подрубрики
            /** @var AbstractNode $node */
            foreach($nodes as $node) {
                $href = $node->getAttribute('href');
                $title = $node->getAttribute('title');
                $imgSrc = '';

                if (count($node->find('img'))) {
                    $img = $node->find('img')[0];
                    $imgSrc = $img->getAttribute('src');
                }

                $rubricItem = [
                    'id' => 0,
                    'parent_id' => 0,
                    'name' => trim($title),
                    'url' => $this->_getUrl($href),
                    'path' => $this->_getPath($href),
                    'parent_url' => $rubric['url'],
                    'is_last' => false,
                    'href' => self::LRPARTS_RU_URL . $href,
                    'img' => self::LRPARTS_RU_URL . $imgSrc,
                    'children' => [],
                ];

                $this->_getRubricDataLrparts2($rubricItem);

                $rubric['children'][] = $rubricItem;

//                break;
            }
        } else { //Товары
            //Большая картинка конечной рубрики
            if (count($dom->find('div.browse-view img'))) {
                $img = $dom->find('div.browse-view img')[0];
                $imgSrc = $img->getAttribute('src');
                $rubric['img'] = self::LRPARTS_RU_URL . $imgSrc;
            }

            $pages = [$dom,];
            $nodes = $dom->find('div.vm-pagination > ul.pagination > li > a.pagenav');

            if (count($nodes)) {
                $pageUrls = [];
                /** @var AbstractNode $node */
                foreach($nodes as $node) {
                    $href = self::LRPARTS_RU_URL . $node->getAttribute('href');

                    $pageUrls[$href] = $href;
                }

                foreach ($pageUrls as $pageUrl) {
                    $html = ParserHelper::getRemoteContent($pageUrl);
                    if (empty($html)) {
                        ConsoleHelper::debug('Страница товаров не загрузилась. [Пропущено]. УРЛ: '.$pageUrl, true, true);
                        continue;
                    }

                    $dom = new Dom;
                    $dom->loadStr($html);

                    $pages[] = $dom;
                }
            }

//            ConsoleHelper::debug('Страниц товаров : '.count($pages));

            foreach ($pages as $dom) {
                $itemsCount = count($dom->find('div.pg_products_table > table > tbody > tr.row-fluid'));
//                ConsoleHelper::debug('Товаров найдено: '.$itemsCount);

                if ($itemsCount) {
                    /** @var AbstractNode $node */
                    foreach($dom->find('div.pg_products_table > table > tbody > tr.row-fluid') as $node) {
                        $position = $node->find('td')[0]->find('a')[0]->innerHtml();
                        $position = $this->_processPosition($position);
                        $name = $node->find('td')[1]->find('span')[0]->text;
                        /** @var AbstractNode $a */
                        $a = $node->find('td')[1]->find('a')[0];
                        $url = self::LRPARTS_RU_URL . $a->getAttribute('href');
                        $code = trim($node->find('td')[2]->text);

                        unset($rubric['children']);
                        $rubric['items'][] = [
                            'id' => 0,
                            'rubric_id' => 0,
                            'position' => trim($position),
                            'name' => trim($name),
                            'code' => trim($code),
                            'url' => $this->_getUrl($url),
                            'path' => $this->_getPath($a->getAttribute('href')),
                        ];

//                        break;
                    }
                }
            }

            if (!empty($rubric['items'])) {
                $rubric['is_last'] = true;
            }
        }

        return $rubric;
    }

    private function _processRubricDataLrparts2(array &$rubric, array $parentRubric = [])
    {
        $rubric = $this->_checkRubric2($rubric, $parentRubric);

        if (!empty($rubric['children'])) {
            foreach ($rubric['children'] as $i => $child) {
                $rubric['children'][$i] = $this->_processRubricDataLrparts2($child, $rubric);
            }
        } elseif (!empty($rubric['items'])) {
            foreach ($rubric['items'] as $i => $item) {
                $rubric['items'][$i] = $this->_checkRubricItem2($item, $rubric);
            }
        }

        return $rubric;
    }

    /**
     * @param array $rubric
     * @param array $parentRubric
     *
     * @return array
     */
    private function _checkRubric2(array $rubric, array $parentRubric = []) : array
    {
//        $modelData = $this->_getRubricModel($rubric['url'], $rubric['parent_url']);
        $modelData = null;

        if (empty($modelData)) {
            $model = new ParserLrpartsRubrics();
            $model->parent_id = !empty($parentRubric) ? $parentRubric['id'] : 0;
            $model->name = $rubric['name'];
            $model->url = $rubric['url'];
            $model->path = $rubric['path'];
            $model->parent_url = $rubric['parent_url'];
            $model->is_last = (bool) $rubric['is_last'];

            if ($model->save(false)) {
                $this->_newRubricsCount++;
                ConsoleHelper::debug('Рубрика "'.$model->path.'" создана с ID: '.$model->id);
                $rubric['id'] = $model->id;
                $rubric['parent_id'] = $model->parent_id;

                if (!empty($rubric['img'])) {
                    $ext = pathinfo($rubric['img'], PATHINFO_EXTENSION);
                    $img = self::LRPARTS_RU_IMAGES_DIR.$model->id.'.'.$ext;

                    if (!file_exists($img)) {
                        $imgContent = ParserHelper::getRemoteContent($rubric['img']);
                        file_put_contents($img, $imgContent);
                        $this->_rubricImagesCount++;
                    }
                }
            } else {
                ConsoleHelper::debug('[ОШИБКА] Рубрика не создана : '.print_r($rubric, true).print_r($model->getErrors(), true), true, true);
            }
        } else {
            $rubric['id'] = $modelData['id'];
            $rubric['parent_id'] = $modelData['parent_id'];

            ConsoleHelper::debug('Рубрика '.$rubric['url'].' найдена, #ID: '.$modelData['id']);
        }

        return $rubric;
    }

    /**
     * @param array $item
     * @param array $parentRubric
     *
     * @return array
     */
    private function _checkRubricItem2(array $item, array $parentRubric) : array
    {
        if (!empty($parentRubric['id'])) {
//            $modelData = $this->_getRubricItemModel($item['url'], $parentRubric['id']);
            $modelData = null;

            if (empty($modelData)) {
                $model = new ParserLrpartsItems();
                $model->rubric_id = $parentRubric['id'];
                $model->name = $item['name'];
                $model->position = $item['position'];
                $model->code = $item['code'];
                $model->url = $item['url'];
                $model->path = $item['path'];

                if ($model->save(false)) {
                    $this->_newItemsCount++;
                    ConsoleHelper::debug('Товар '.$item['path'].' создан с ID: '.$model->id);
                    $item['id'] = $model->id;
                    $item['rubric_id'] = $model->rubric_id;
                } else {
                    ConsoleHelper::debug('[ОШИБКА] Товар рубрики('.$parentRubric['url'].') не создан : '.print_r($item, true).print_r($model->getErrors(), true), true, true);
                }
            } else {
                $item['id'] = $modelData['id'];
                $item['rubric_id'] = $modelData['rubric_id'];

                ConsoleHelper::debug('Товар '.$item['path'].' найден, #ID: '.$modelData['id']);
            }
        } else {
            ConsoleHelper::debug('При проверке товара у рубрики нет ID: '.print_r($item, true).print_r($parentRubric, true), true, true);
        }

        return $item;
    }

    /**
     * @param array  $node
     * @param string $topParentName
     *
     * @return array
     * @throws \yii\db\Exception
     */
    private function _processNode(array $node, string $topParentName)
    {
        $isChanged = false;
        if (empty($node['title'])) {
            $node['title'] = $topParentName.' '.$node['name'];
            $isChanged = true;
        }
        if (empty($node['page_header'])) {
            $node['page_header'] = $node['name'].' '.$topParentName;
            $isChanged = true;
        }

        if ($isChanged) {
            (new Query())->createCommand()->update(
                ParserLrpartsRubrics::tableName(),
                ['title' => $node['title'], 'page_header' => $node['page_header'],],
                ['id' => $node['id'],]
            )->execute();

            ConsoleHelper::debug('Рубрика #'.$node['id'].' обновлена');
        }

        if (!empty($node[Catalog::TREE_ITEM_CHILDREN])) {
            foreach ($node[Catalog::TREE_ITEM_CHILDREN] as $other) {
                $this->_processNode($other, $topParentName);
            }
        }

        return $node;
    }

    private function _processPosition(string $position) : string
    {
        $pos = strpos($position, '<');

        if ($pos !== false) {
            $pos2 = strpos($position, '<', $pos + 1);

            if ($pos2 !== false) { //<044a59< />>
                $position = substr($position, 0, $pos2);
                $position = strtoupper($position);
            }
        }

        return $position;
    }

    /**
     * https://www.britauto.ru/land_rover_zapchasti
     *
     * @return false|int
     * @throws \PHPHtmlParser\Exceptions\ChildNotFoundException
     * @throws \PHPHtmlParser\Exceptions\CircularException
     * @throws \PHPHtmlParser\Exceptions\ContentLengthException
     * @throws \PHPHtmlParser\Exceptions\LogicalException
     * @throws \PHPHtmlParser\Exceptions\NotLoadedException
     * @throws \PHPHtmlParser\Exceptions\StrictException
     */
    public function actionBritauto()
    {
        $externalDb = \Yii::$app->db2;
        $totalTime = time();
        $isConsole = true;
        $rowsCount = $savedCount = $notSavedCount = $savedImagesCount = 0;
        $rubricItems = $pageItems = [];

        //        $command = (new \yii\db\Query())
        //            ->select(['code', 'name', 'name_official', 'address', 'buyer', 'supplier', 'type',])
        //            ->from('parser_britauto')
        //            ->createCommand();
        //        $command->db = $externalDb;
        //        $rows = $command->queryAll();

        // Каталог
        $html = ParserHelper::getRemoteContent(self::BRITAUTO_RU_CATALOG_URL);
        if (empty($html)) {
            ConsoleHelper::debug('Страница каталога не загрузилась. [Пропущено]. УРЛ: '.self::LRPARTS_RU_CATALOG_URL, $isConsole, true);

            return false;
        }

        $dom = new Dom;
        $dom->loadStr($html);
        /** @var AbstractNode $content */
        foreach ($dom->find('div.wcatlist > div.citem > div.ctext > a') as $content) {
            $href = $content->getAttribute('href');
            $url = self::BRITAUTO_RU_URL.$href;

            $rubricItems[$url] = true;
        }

        ConsoleHelper::debug('Найдено основных рубрик: ' . count($rubricItems), $isConsole);

        $processedRubrics = ParserBritautoProcessed::find()->asArray()->indexBy('url')->all();

        if (count($rubricItems) > 0 && count($rubricItems) === count($processedRubrics)) {
            ParserBritautoProcessed::deleteAll([]);
            (new Query())->createCommand($externalDb)->truncateTable('shop.parser_britauto')->execute();
        }

        // Основные рубрики
        foreach ($rubricItems as $url => $true) {
            if (!isset($processedRubrics[$url])) {
                ConsoleHelper::debug('=====================================================================', $isConsole);
                ConsoleHelper::debug('=====================================================================', $isConsole);
                ConsoleHelper::debug('=====================================================================', $isConsole);
                ConsoleHelper::debug('РУБРИКА: '.$url, $isConsole);
                ConsoleHelper::debug('=====================================================================', $isConsole);
                ConsoleHelper::debug('=====================================================================', $isConsole);
                ConsoleHelper::debug('=====================================================================', $isConsole);

                $this->_getSubRubricsDataBritauto($url, $externalDb);

                $processed = new ParserBritautoProcessed();
                $processed->url = $url;
                $processed->save();
            } else {
                ConsoleHelper::debug('Рубрика "'.$url.'" уже импортирована, пропуск...', $isConsole, true);
            }
        }

        ConsoleHelper::debug('=====================================================================', $isConsole);
        ConsoleHelper::debug('[ИТОГ] Создано новых товаров: '.$this->_newItemsCount, $isConsole);

        $minutes = floor((time() - $totalTime) / 60);
        if ($minutes > 0) {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено минут: '.$minutes, $isConsole);
        } else {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено секунд: '.(time() - $totalTime), $isConsole);
        }

        return ExitCode::OK;
    }

    /**
     * @param string             $url
     * @param \yii\db\Connection $externalDb
     *
     * @return bool
     * @throws \PHPHtmlParser\Exceptions\ChildNotFoundException
     * @throws \PHPHtmlParser\Exceptions\CircularException
     * @throws \PHPHtmlParser\Exceptions\ContentLengthException
     * @throws \PHPHtmlParser\Exceptions\LogicalException
     * @throws \PHPHtmlParser\Exceptions\NotLoadedException
     * @throws \PHPHtmlParser\Exceptions\StrictException
     * @throws \yii\db\Exception
     */
    private function _getSubRubricsDataBritauto(string $url, \yii\db\Connection $externalDb) : bool
    {
        $html = ParserHelper::getRemoteContent($url);
        if (empty($html)) {
            ConsoleHelper::debug('Страница рубрики не загрузилась. [Пропущено]. УРЛ: '.$url, true, true);

            return false;
        }

        ConsoleHelper::debug('Страница рубрики '.$url.' загружена');

        $dom = new Dom;
        $dom->loadStr($html);
        $nodes = $dom->find('div.wcatlist > div.citem > div.ctext > a');

        if (count($nodes)) { //Подрубрики
            /** @var AbstractNode $node */
            foreach($nodes as $node) {
                $href = $node->getAttribute('href');
                $suburl = self::BRITAUTO_RU_URL.$href;
//                $this->_britautoRubrics[$suburl] = true;

                $this->_getSubRubricsDataBritauto($suburl, $externalDb);
            }
        } else { //Товары
            $this->_processItemsBritauto($dom, $url, $externalDb);

            $nodes = $dom->find('table.pgs > tr > td > a');
            if (count($nodes)) { //Пагинация

                $pageUrls = [];
                /** @var AbstractNode $node */
                foreach($nodes as $node) {
                    $href = self::BRITAUTO_RU_URL . $node->getAttribute('href');

                    $pageUrls[$href] = $href;
                }

                ConsoleHelper::debug('Страниц товаров: '.count($pageUrls));

                $index = 1;
                foreach ($pageUrls as $pageUrl) {
                    $html = ParserHelper::getRemoteContent($pageUrl);
                    if (empty($html)) {
                        ConsoleHelper::debug('Страница товаров не загрузилась. [Пропущено]. УРЛ: '.$pageUrl, true, true);
                        continue;
                    }

                    $dom = new Dom;
                    $dom->loadStr($html);

                    $this->_processItemsBritauto($dom, $url, $externalDb, $index++);
                }
            }
        }

        return true;
    }

    /**
     * @param Dom                $dom
     * @param string             $url
     * @param \yii\db\Connection $externalDb
     * @param                    $index
     *
     * @return void
     * @throws \PHPHtmlParser\Exceptions\ChildNotFoundException
     * @throws \PHPHtmlParser\Exceptions\NotLoadedException
     * @throws \yii\db\Exception
     */
    private function _processItemsBritauto(Dom $dom, string $url, \yii\db\Connection $externalDb, $index = 0)
    {
        $itemsCount = count($dom->find('div.witemlist > div.witem > div.wtext'));

        if ($itemsCount) {
            $data = [];

            foreach($dom->find('div.witemlist > div.witem > div.wtext') as $node) {
                $article = $node->find('span')[0]->text;
                $title = $node->find('span')[1]->text;
                $href = $node->find('a.redtext')[0]->getAttribute('href');
                $vars = explode(':', $article);

                $data[] = [
                    trim($vars[0]),
                    trim($title),
                    self::BRITAUTO_RU_URL . $href,
                    time(),
                ];
                //                        break;
            }

            if ($data) {
                $count = $externalDb->createCommand()->batchInsert('shop.parser_britauto', ['article', 'title', 'url', 'created_at',], $data)->execute();
                $this->_newItemsCount += $count;

                ConsoleHelper::debug(($index ? '['.$index.'] ' : '').'Вставлено '.$count.' записей для рубрики '.$url, true);
            }
        } else {
            ConsoleHelper::debug('Товаров не найдено на странице '.$url, true, true);
        }
    }

    /**
     * @param string $article
     *
     * @return string
     */
    private function _landspiritParseArticle(string $article) : string
    {
        foreach (self::LANDSPIRIT_RU_ARTICLES as $art) {
            $length = strlen($article);
            $pos = strrpos($article, $art);
            if ($pos !== false && ($length - $pos) <= 3) {
                $article = substr($article, 0, $pos);

                break;
            }
        }

        return $article;
    }

    /**
     * @param string $article
     *
     * @return string
     */
    private function _landspiritParseImage(string $article) : string
    {
        $article = str_replace(' ', '_', $article);
        $article = str_replace('+', '_', $article);

        return $article;
    }

    public function actionLandspirit2()
    {
        /** @var Connection $externalDb */
        $externalDb = \Yii::$app->db2;
        $tableName = '{{shop.parser_landspirit}}';
        $query = (new Query())->from($tableName);
        $queryCount = clone $query;
        if ($queryCount->count('*', $externalDb) > 0) {
            $totalCount = $updatedCount = 0;
            foreach ($query->batch(30, $externalDb) as $rows) {
                foreach ($rows as $row) {
                    $totalCount++;
                    $itemUrl = $row['url'];

                    $item = $this->_processItemLandspirit($itemUrl);
                    if (!empty($item)) {
                        $result = $externalDb->createCommand()->update(
                            $tableName,
                            ['article' => $item[0], 'description' => $item[2], 'image' => $item[4],],
                            ['id' => $row['id'],]
                        )->execute();


                        if ($result) {
                            ConsoleHelper::debug('['.$totalCount.'] Обновлен артикул '.$item[0].'. УРЛ: '.$itemUrl, true);
                            $updatedCount++;
                        } else {
                            ConsoleHelper::debug('['.$totalCount.'] Ощибка обновления артикула '.$item[0].'. УРЛ: '.$itemUrl, true, true);
                        }
                    }
                }
            }

            ConsoleHelper::debug('Всего обновлено '.$updatedCount.' записей в таблице '.$tableName, true);
        }

        return ExitCode::OK;





        $itemUrl = 'https://landspirit.ru/shop/zapchasti/baraban-transmissionnogo-tormoza-am-frc3502/';
        $itemUrl = 'https://landspirit.ru/shop/zapchasti/disk-tormoznoj-peredn-zadn-neventil-298mmx14mm-am-oem-frc7329/';

        $html = ParserHelper::fileGetContentsCurl($itemUrl);
        if (empty($html)) {
            ConsoleHelper::debug('Страница товара не загрузилась. [Пропущено]. УРЛ: '.$itemUrl, true, true);

            return ExitCode::OK;
        }

        $itemDom = new Dom;
        $itemDom->loadStr($html);
        $article = $title = $description = $image = $imgSrc = '';

        $articleItems = explode('-', $itemUrl);
        $article = array_pop($articleItems);
        $pos = strpos($article, '/');
        if ($pos !== false) {
            $article = str_replace('/', '', $article);
        }
        $article = strtoupper($article);

        $title = $itemDom->find('h1.product_title')[0]->text;
        $pos = strpos($title, $article);
        if ($pos !== false) {
            $title = str_replace($article, '', $title);
        }

        if (!empty($article)) {
            if (count($itemDom->find('div.woocommerce-Tabs-panel--description > p'))) {
                $description = $itemDom->find('div.woocommerce-Tabs-panel--description > p')[0]->text;
                $pos = strpos($description, $article);
                if ($pos !== false) {
                    $description = str_replace($article, '', $description);
                }
            }

            echo '$article = '.$article.PHP_EOL;
            echo '$title = '.$title.PHP_EOL;
            echo '$description = '.$description.PHP_EOL;

            $figure = $itemDom->find('figure');
            if ($figure->count() && count($figure->find('img'))) {
                $img = $figure->find('img')[0];
                if (!empty($img->getAttribute('data-large_image'))) {
                    $imgSrc = $img->getAttribute('data-large_image');
                } elseif (!empty($img->getAttribute('data-src'))) {
                    $imgSrc = $img->getAttribute('data-src');
                } else {
                    $imgSrc = $img->getAttribute('src');
                }
                $pos = strpos($imgSrc, 'https:');
                if ($pos === false) {
                    $imgSrc = 'https:'.$imgSrc;
                }

                echo '$imgSrc = '.$imgSrc.PHP_EOL;

                if (!empty($imgSrc)) {
                    $ext = pathinfo($imgSrc, PATHINFO_EXTENSION);
                    $imageName = pathinfo($imgSrc, PATHINFO_BASENAME);

                    if ($imageName !== 'placeholder.png') {
                        $image = $article.'.'.$ext;
                    } else {
                        $image = $imageName;
                    }
                    $img = self::LANDSPIRIT_RU_IMAGES_DIR.$image;

                    echo '$image = '.$image.PHP_EOL;

                    if (!file_exists($img)) {
                        $imgContent = ParserHelper::fileGetContentsCurl($imgSrc);
                        file_put_contents($img, $imgContent);
                        $this->_rubricImagesCount++;

                        ConsoleHelper::debug('Загружено изображение '.$image.' для страницы '.$itemUrl, true);
                    }
                }
            }
        } else {
            ConsoleHelper::debug('Артикул товара не определен. [Пропущено]. УРЛ: '.$itemUrl, true, true);
        }

        return ExitCode::OK;
    }

    /**
     * https://landspirit.ru/shop/
     *
     * @return false|int
     * @throws \PHPHtmlParser\Exceptions\ChildNotFoundException
     * @throws \PHPHtmlParser\Exceptions\CircularException
     * @throws \PHPHtmlParser\Exceptions\ContentLengthException
     * @throws \PHPHtmlParser\Exceptions\LogicalException
     * @throws \PHPHtmlParser\Exceptions\NotLoadedException
     * @throws \PHPHtmlParser\Exceptions\StrictException
     */
    public function actionLandspirit()
    {
        $externalDb = \Yii::$app->db2;
        $totalTime = time();
        $isConsole = true;
        $rowsCount = $savedCount = $notSavedCount = $savedImagesCount = 0;
        $rubricItems = $pageItems = [];

        // Каталог
        $html = ParserHelper::fileGetContentsCurl(self::LANDSPIRIT_RU_CATALOG_URL);
        if (empty($html)) {
            ConsoleHelper::debug('Страница каталога не загрузилась. [Пропущено]. УРЛ: '.self::LANDSPIRIT_RU_CATALOG_URL, $isConsole, true);

            return false;
        }

        $dom = new Dom;
        $dom->loadStr($html);
        /** @var AbstractNode $content */
        foreach ($dom->find('ul.products > li.product > a') as $content) {
            $href = $content->getAttribute('href');
            $url = 'https:'.$href;

            $rubricItems[$url] = true;
        }

        ConsoleHelper::debug('Найдено основных рубрик: ' . count($rubricItems), $isConsole);

        $processedRubrics = ParserLandspiritProcessed::find()->asArray()->indexBy('url')->all();

        if (count($rubricItems) > 0 && count($rubricItems) === count($processedRubrics)) {
            ParserLandspiritProcessed::deleteAll([]);
            (new Query())->createCommand($externalDb)->truncateTable('shop.parser_landspirit')->execute();

            ConsoleHelper::debug('Таблицы очищены...', $isConsole);
        }

        // Основные рубрики
        foreach ($rubricItems as $url => $true) {
            if (!isset($processedRubrics[$url])) {
                ConsoleHelper::debug('=====================================================================', $isConsole);
                ConsoleHelper::debug('=====================================================================', $isConsole);
                ConsoleHelper::debug('РУБРИКА: '.$url, $isConsole);
                ConsoleHelper::debug('=====================================================================', $isConsole);
                ConsoleHelper::debug('=====================================================================', $isConsole);

                $this->_landspiritPageUrls = [];
                $this->_getSubRubricsDataLandspirit($url);

                $index = 0;
                foreach ($this->_landspiritPageUrls as $landspiritPageUrl => $true2) {
                    $this->_processItemsLandspirit($landspiritPageUrl, $externalDb, $index++);
                }

                $processed = new ParserLandspiritProcessed();
                $processed->url = $url;
                $processed->save();
            } else {
                ConsoleHelper::debug('Рубрика "'.$url.'" уже импортирована, пропуск...', $isConsole, true);
            }
        }

        ConsoleHelper::debug('=====================================================================', $isConsole);
        ConsoleHelper::debug('[ИТОГ] Загружено картинок: '.$this->_rubricImagesCount, $isConsole);
        ConsoleHelper::debug('[ИТОГ] Создано новых товаров: '.$this->_newItemsCount, $isConsole);

        $minutes = floor((time() - $totalTime) / 60);
        if ($minutes > 0) {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено минут: '.$minutes, $isConsole);
        } else {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено секунд: '.(time() - $totalTime), $isConsole);
        }

        return ExitCode::OK;
    }

    /**
     * @param string             $url
     *
     * @return bool
     * @throws \PHPHtmlParser\Exceptions\ChildNotFoundException
     * @throws \PHPHtmlParser\Exceptions\CircularException
     * @throws \PHPHtmlParser\Exceptions\ContentLengthException
     * @throws \PHPHtmlParser\Exceptions\LogicalException
     * @throws \PHPHtmlParser\Exceptions\NotLoadedException
     * @throws \PHPHtmlParser\Exceptions\StrictException
     * @throws \yii\db\Exception
     */
    private function _getSubRubricsDataLandspirit(string $url) : bool
    {
        $html = ParserHelper::fileGetContentsCurl($url);
        if (empty($html)) {
            ConsoleHelper::debug('Страница рубрики не загрузилась. [Пропущено]. УРЛ: '.$url, true, true);

            return false;
        }

        ConsoleHelper::debug('Страница рубрики '.$url.' загружена');

        $dom = new Dom;
        $dom->loadStr($html);
        $nodes = $dom->find('ul.products > li.product-category > a');

        if (count($nodes)) { //Подрубрики
            /** @var AbstractNode $node */
            foreach($nodes as $node) {
                $href = $node->getAttribute('href');
                $suburl = 'https:'.$href;

                $this->_getSubRubricsDataLandspirit($suburl);
            }
        } else { //Товары
            $nodes = $dom->find('ul.page-numbers > li > a');
            if (count($nodes)) { //Пагинация
                $pageNumber = [];
                /** @var AbstractNode $node */
                foreach($nodes as $node) {
                    $number = $node->text();
                    if (is_numeric($number)) {
                        $pageNumber[] = $number;
                    }
                }
                $max = max($pageNumber);
                if ($max > 0) {
                    foreach (range(1, $max) as $page) {
                        $pageUrl = $url . 'page/'.$page.'/';
                        $this->_landspiritPageUrls[$pageUrl] = true;
                    }
                }

                ConsoleHelper::debug('Страниц товаров: '.$max);
            } else {
                $this->_landspiritPageUrls[$url] = true;
            }
        }

        return true;
    }

    /**
     * @param string             $url
     * @param \yii\db\Connection $externalDb
     * @param                    $index
     *
     * @return bool
     * @throws \PHPHtmlParser\Exceptions\ChildNotFoundException
     * @throws \PHPHtmlParser\Exceptions\NotLoadedException
     * @throws \yii\db\Exception
     */
    private function _processItemsLandspirit(string $url, \yii\db\Connection $externalDb, $index = 0) : bool
    {
        $html = ParserHelper::fileGetContentsCurl($url);
        if (empty($html)) {
            ConsoleHelper::debug('Страница с товарами не загрузилась. [Пропущено]. УРЛ: '.$url, true, true);

            return false;
        }

        $dom = new Dom;
        $dom->loadStr($html);

        $itemsCount = count($dom->find('ul.products > li.product > a.woocommerce-LoopProduct-link'));
        if ($itemsCount) {
            $data = [];

            foreach($dom->find('ul.products > li.product > a.woocommerce-LoopProduct-link') as $node) {
                $href = $node->getAttribute('href');
                $itemUrl = 'https:'.$href;

                $item = $this->_processItemLandspirit($itemUrl);
                if (!empty($item)) {
                    $data[] = $item;
                }
            }

            if ($data) {
                $count = $externalDb->createCommand()->batchInsert('shop.parser_landspirit', ['article', 'title', 'description', 'url', 'image', 'created_at',], $data)->execute();
                $this->_newItemsCount += $count;

                ConsoleHelper::debug(($index ? '['.$index.'] ' : '').'Вставлено '.$count.' записей для страницы '.$url, true);
            }
        } else {
            ConsoleHelper::debug('Товаров не найдено на странице '.$url, true, true);
        }

        return true;
    }

    /**
     * @param string $itemUrl
     *
     * @return array
     * @throws \PHPHtmlParser\Exceptions\ChildNotFoundException
     * @throws \PHPHtmlParser\Exceptions\CircularException
     * @throws \PHPHtmlParser\Exceptions\ContentLengthException
     * @throws \PHPHtmlParser\Exceptions\LogicalException
     * @throws \PHPHtmlParser\Exceptions\NotLoadedException
     * @throws \PHPHtmlParser\Exceptions\StrictException
     */
    private function _processItemLandspirit(string $itemUrl) : array
    {
        $html = ParserHelper::fileGetContentsCurl($itemUrl);
        if (empty($html)) {
            ConsoleHelper::debug('Страница товара не загрузилась. [Пропущено]. УРЛ: '.$itemUrl, true, true);

            return [];
        }

        $itemDom = new Dom;
        $itemDom->loadStr($html);
        $article = $articleShort = $title = $description = $image = $imgSrc = '';

        if ($itemDom->find('div.product_meta > span.sku_wrapper > span.sku')->count()) {
            $article = $itemDom->find('div.product_meta > span.sku_wrapper > span.sku')[0]->text;
            $articleShort = $this->_landspiritParseArticle($article);
        } else {
            ConsoleHelper::debug('Артикул товара не определен. [Пропущено]. УРЛ: '.$itemUrl, true, true);

            return [];
        }

        $title = $itemDom->find('h1.product_title')[0]->text;
        $pos = strpos($title, $article);
        if ($pos !== false) {
            $title = str_replace($article, '', $title);
        }

        if (!empty($article)) {
            if (count($itemDom->find('div.woocommerce-Tabs-panel--description > p'))) {
                $description = $itemDom->find('div.woocommerce-Tabs-panel--description > p')[0]->text;
                $pos = strpos($description, $article);
                if ($pos !== false) {
                    $description = str_replace($article, '', $description);
                } else {
                    $pos = strpos($description, $articleShort);
                    if ($pos !== false) {
                        $description = str_replace($articleShort, '', $description);
                    }
                }
            }

            $figure = $itemDom->find('figure');
            if ($figure->count() && count($figure->find('img'))) {
                $img = $figure->find('img')[0];
                if (!empty($img->getAttribute('data-large_image'))) {
                    $imgSrc = $img->getAttribute('data-large_image');
                } elseif (!empty($img->getAttribute('data-src'))) {
                    $imgSrc = $img->getAttribute('data-src');
                } else {
                    $imgSrc = $img->getAttribute('src');
                }
                $pos = strpos($imgSrc, 'https:');
                if ($pos === false) {
                    $imgSrc = 'https:'.$imgSrc;
                }

                if (!empty($imgSrc)) {
                    $ext = pathinfo($imgSrc, PATHINFO_EXTENSION);
                    $imageName = pathinfo($imgSrc, PATHINFO_BASENAME);

                    if ($imageName !== 'placeholder.png') {
                        $image = $this->_landspiritParseImage($articleShort).'.'.$ext;
                    } else {
                        $image = $imageName;
                    }
                    $img = self::LANDSPIRIT_RU_IMAGES_DIR.$image;

                    if (!file_exists($img)) {
                        $imgContent = ParserHelper::fileGetContentsCurl($imgSrc);
                        file_put_contents($img, $imgContent);
                        $this->_rubricImagesCount++;

                        ConsoleHelper::debug('Загружено изображение '.$image.' для страницы '.$itemUrl, true);
                    }
                }
            }
        } else {
            ConsoleHelper::debug('Артикул товара не определен. [Пропущено]. УРЛ: '.$itemUrl, true, true);

            return [];
        }

        return [
            trim($articleShort),
            trim($title),
            trim($description),
            $itemUrl,
            $image,
            time(),
        ];
    }

    public function actionJaguarLandroverClassic()
    {
        $totalTime = time();
        $isConsole = true;
        $rowsCount = $savedCount = $notSavedCount = $savedImagesCount = 0;
        $topRubricIndex = 1;
        $rubricItems = $pageItems = [];

        $urls = [
            'https://parts.jaguarlandroverclassic.com/parts/index/part/id/1T.1TB.1TB0405.1TB040505B/brand/land-rover/',
            'https://parts.jaguarlandroverclassic.com/parts/index/part/id/34.56.563.5631002.563100205AD/brand/land-rover/',
            'https://parts.jaguarlandroverclassic.com/parts/index/part/id/34.56.563.5630301.563030110AC/brand/land-rover/',
        ];

        foreach ($urls as $url) {
            $this->_getJaguarLandroverClassicRubric($url, 0);
        }

        return ExitCode::OK;




        foreach (self::JAGUARLANDROVERCLASSIC_COM_CATALOG_URLS as $url) {
            ConsoleHelper::debug('********************************************', $isConsole);
            ConsoleHelper::debug('Рубрика: ' . $url, $isConsole);
            ConsoleHelper::debug('********************************************', $isConsole);
            // Каталог
            $html = ParserHelper::getRemoteContent($url);
            if (empty($html)) {
                ConsoleHelper::debug('Страница каталога не загрузилась. [Пропущено]. УРЛ: '.$url, $isConsole, true);

                return false;
            }

            $rubricIndex = 1;
            $dom = new Dom;
            $dom->loadStr($html);

            $topRubric = ParserJaguarlandroverclassicRubrics::find()->where(['url' => $url, 'parent_id' => 0,])->asArray()->one();
            if (!$topRubric) {
                $span = $dom->find('p.parts_finder__breadcrumbs > span')[0];
                $rubricItem = [
                    'name' => trim($span->text()),
                    'img' => '',
                    'url' => $url,
                    'sort' => $topRubricIndex++,
                    'description' => '',
                    'is_active' => true,
                    'is_last' => false,
                ];
                $topRubricID = self::_createJaguarLandroverClassicRubric($rubricItem, 0);
            } else {
                $topRubricID = $topRubric['id'];
            }

            if (!$topRubricID) {
                ConsoleHelper::debug('ID рубрики не определена/не создана. [Пропущено]. УРЛ: '.$url, $isConsole, true);
                continue;
            }

            /** @var AbstractNode $content */
            foreach ($dom->find('div.parts_finder__content > div.iweb_grid > div.iweb_grid__item > div.iweb_grid_card__image > a') as $content) {
                $href = $content->getAttribute('href');
                $img = $content->find('img')[0];
                if (!empty($img->getAttribute('data-src'))) {
                    $imgSrc = $img->getAttribute('data-src');
                } else {
                    $imgSrc = $img->getAttribute('src');
                }
                $alt = $img->getAttribute('alt');

                $rubricItems[$href] = [
                    'name' => trim($alt),
                    'img' => $imgSrc,
                    'url' => $href,
                    'sort' => $rubricIndex++,
                    'description' => '',
                    'is_active' => true,
                    'is_last' => false,
                ];
            }

            ConsoleHelper::debug('Найдено основных рубрик: ' . count($rubricItems), $isConsole);

//            print_r($rubricItems);

            $processedRubrics = ParserJaguarlandroverclassicRubricsProcessed::find()->asArray()->indexBy('url')->all();

            if (count($rubricItems) > 0 && count($rubricItems) === count($processedRubrics)) {
                ParserJaguarlandroverclassicRubricsProcessed::deleteAll([]);
                //(new Query())->createCommand()->truncateTable(ParserJaguarlandroverclassicRubricsProcessed::tableName())->execute();
                ConsoleHelper::debug('Очищена таблица ' . ParserJaguarlandroverclassicRubricsProcessed::tableName(), $isConsole);
            }

            // Основные рубрики
            foreach ($rubricItems as $url => $rubricItem) {
                if (!isset($processedRubrics[$url])) {
                    ConsoleHelper::debug('=====================================================================', $isConsole);
                    ConsoleHelper::debug('РУБРИКА: '.$url, $isConsole);
                    ConsoleHelper::debug('=====================================================================', $isConsole);

                    $id = self::_createJaguarLandroverClassicRubric($rubricItem, $topRubricID);

                    if (!$id) {
                        ConsoleHelper::debug('ID рубрики не определена/не создана. [Пропущено]. УРЛ: '.$url, $isConsole, true);
                        continue;
                    }

                    $this->_getJaguarLandroverClassicRubric($url, $id);

                    $processed = new ParserJaguarlandroverclassicRubricsProcessed();
                    $processed->url = $url;
                    $processed->save();
                } else {
                    ConsoleHelper::debug('Рубрика "'.$url.'" уже импортирована, пропуск...', $isConsole, true);
                }
            }

            ConsoleHelper::debug('=====================================================================', $isConsole);
            ConsoleHelper::debug('[ИТОГ] Создано новых рубрик: '.$this->_newRubricsCount, $isConsole);
            ConsoleHelper::debug('[ИТОГ] Создано новых товаров: '.$this->_newItemsCount, $isConsole);
        }

        $minutes = floor((time() - $totalTime) / 60);
        if ($minutes > 0) {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено минут: '.$minutes, $isConsole);
        } else {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено секунд: '.(time() - $totalTime), $isConsole);
        }

        return ExitCode::OK;
    }

    /**
     * @param string $url
     * @param int    $parentRubricID
     *
     * @return bool
     * @throws \PHPHtmlParser\Exceptions\ChildNotFoundException
     * @throws \PHPHtmlParser\Exceptions\CircularException
     * @throws \PHPHtmlParser\Exceptions\ContentLengthException
     * @throws \PHPHtmlParser\Exceptions\LogicalException
     * @throws \PHPHtmlParser\Exceptions\NotLoadedException
     * @throws \PHPHtmlParser\Exceptions\StrictException
     * @throws \yii\base\InvalidConfigException
     */
    private function _getJaguarLandroverClassicRubric(string $url, int $parentRubricID) : bool
    {
        $html = ParserHelper::getRemoteContent($url);
        if (empty($html)) {
            ConsoleHelper::debug('Страница рубрики не загрузилась. [Пропущено]. УРЛ: '.$url, true, true);

            return false;
        }

        ConsoleHelper::debug('Страница рубрики '.$url.' загружена');

        $dom = new Dom;
        $dom->loadStr($html);
        $nodes = $dom->find('div.parts_finder__content > div.iweb_grid > div.iweb_grid__item > div.iweb_grid_card__image > a');

        if (count($nodes)) { //Подрубрики (2 вида: с img или object)
            ConsoleHelper::debug('НЕТ ТОВАРОВ '.$url);

            return true;

            $rubricIndex = 1;
            /** @var AbstractNode $body */
            foreach($nodes as $body) {
                $isLast = false;
                $img = $object = $imgSrc = $alt = null;
                $href = $body->getAttribute('href');
                //img
                $imgs = $body->find('img');
                if (count($imgs)) {
                    $img = $imgs[0];

                    if (!empty($img->getAttribute('data-src'))) {
                        $imgSrc = $img->getAttribute('data-src');
                    } else {
                        $imgSrc = $img->getAttribute('src');
                    }
                    $alt = $img->getAttribute('alt');
                } else {
                    $objects = $body->find('object');
                    if (count($objects)) {
                        $object = $objects[0];
                        $imgSrc = $object->getAttribute('data');
                        $isLast = true;
                    } else {
                        ConsoleHelper::debug('Пустая ссылка рубрики '.$href.', пропуск');
                        continue;
                    }
                }

                $rubricItem = [
                    'name' => trim($alt),
                    'img' => $imgSrc,
                    'url' => $href,
                    'sort' => $rubricIndex++,
                    'description' => '',
                    'is_active' => true,
                    'is_last' => $isLast,
                ];

                $id = self::_createJaguarLandroverClassicRubric($rubricItem, $parentRubricID);
                if (!$id) {
                    ConsoleHelper::debug('ID рубрики не определена/не создана. [Пропущено]. УРЛ: '.$url, true, true);
                    continue;
                }

                $this->_getJaguarLandroverClassicRubric($href, $id);
            }
        } else { //Товары

            ConsoleHelper::debug('************************************************', true);
            ConsoleHelper::debug('**************** Т О В А Р Ы *******************', true);
            ConsoleHelper::debug($url, true);
            ConsoleHelper::debug('************************************************', true);


            $itemsCount = count($dom->find('div.finder_list > table.finder_table > tbody.finder_body'));

            if ($itemsCount) {
                $data = [];

                foreach($dom->find('div.finder_list > table.finder_table > tbody.finder_body') as $body) {
                    $mainItemPosition = $body->find('tr.finder_body__tr > td.finder_body__td')[0]->text;
                    $mainItemName = $body->find('tr.finder_body__tr > td.finder_body__td')[2]->text;

                    foreach ($body->find('tr.finder_list--additional > td.finder_body__td--additional > table.finder_list--additional > tbody.finder_list--additional') as $item) { //

                    }

                    $mainItemName = $body->find('tr.finder_body__tr > td.finder_body__td')[2]->text;





                    $title = $body->find('span')[1]->text;
                    $href = $body->find('a.redtext')[0]->getAttribute('href');
                    $vars = explode(':', $article);

                    $data[] = [
                        trim($vars[0]),
                        trim($title),
                        self::BRITAUTO_RU_URL . $href,
                        time(),
                    ];
                    //                        break;
                }

                if ($data) {
                    $count = $externalDb->createCommand()->batchInsert('shop.parser_britauto', ['article', 'title', 'url', 'created_at',], $data)->execute();
                    $this->_newItemsCount += $count;

                    ConsoleHelper::debug(($index ? '['.$index.'] ' : '').'Вставлено '.$count.' записей для рубрики '.$url, true);
                }
            } else {
                ConsoleHelper::debug('Товаров не найдено на странице '.$url, true, true);
            }
            /**/
        }

        return true;
    }

    /**
     * @param array $rubric
     * @param int   $parentRubricID
     *
     * @return int
     * @throws \yii\base\InvalidConfigException
     */
    private function _createJaguarLandroverClassicRubric(array $rubric, int $parentRubricID) : int
    {
        $model = new ParserJaguarlandroverclassicRubrics();
        $model->parent_id = !empty($parentRubricID) ? $parentRubricID : 0;
        $model->name = $rubric['name'];
        $model->url = $rubric['url'];
        $model->sort = $rubric['sort'];
        $model->description = $rubric['description'];
        $model->is_active = (bool) $rubric['is_active'];
        $model->is_last = (bool) $rubric['is_last'];

        if ($model->save(false)) {
            $this->_newRubricsCount++;
            ConsoleHelper::debug('Рубрика "'.$model->url.'" создана с ID: '.$model->id);

            if (!empty($rubric['img'])) {
                $ext = pathinfo($rubric['img'], PATHINFO_EXTENSION);
                $img = self::JAGUARLANDROVERCLASSIC_COM_IMAGES_DIR.$model->id.'.'.$ext;

                if (!file_exists($img)) {
                    $imgContent = ParserHelper::getRemoteContent($rubric['img']);
                    file_put_contents($img, $imgContent);
                    $this->_rubricImagesCount++;
                }
            }

            return $model->id;
        } else {
            ConsoleHelper::debug('[ОШИБКА] Рубрика не создана : '.print_r($rubric, true).print_r($model->getErrors(), true), true, true);
        }

        return 0;
    }


    public function actionTest()
    {
        $ids = $emptyIds = [];
        $fileName = \Yii::getAlias('@files').DIRECTORY_SEPARATOR.'parser_lrparts_items.csv';

        if (file_exists($fileName) && ($handle = fopen($fileName, "r")) !== FALSE) {
            while (($csvData = fgetcsv($handle, 1000, ';')) !== FALSE) {
                $ID = $csvData[0];
                $code = $csvData[4];

                if (!empty($code)) {
                    $ids[$ID] = $code;
                } else {
                    $emptyIds[$ID] = $ID;
                }
            }
            fclose($handle);
        }

        ConsoleHelper::debug('Найдено строк для обновления: '.count($ids));
        ConsoleHelper::debug('Найдено строк для удаления: '.count($emptyIds));

        $updated = 0;
        foreach ($ids as $id => $code) {
            $i = (new Query())->createCommand()->update(ParserLrpartsItems::tableName(), ['code' => $code,],
                ['id' => $id,])->execute();
            $updated += $i;

            if ($updated % 500 === 0) {
                ConsoleHelper::debug('Обновлено ' . $updated . ' строк из ' . count($ids));
            }
        }

        ConsoleHelper::debug('[ВСЕГО] Из '.count($ids).' обновлено '.$updated.' строк');

        if (count($emptyIds)) {
            $i = 0;
            //$i = (new Query())->createCommand()->delete(ParserLrpartsItems::tableName(), ['id' => $emptyIds,])->execute();
            ConsoleHelper::debug('[ВСЕГО] Удалено строк: '.$i);
        }

        return ExitCode::OK;
    }

    public function actionTest2()
    {
        $totalTime = time();
        $data = $articles = [];

        $query = (new Query())->from(Articles::tableName())->select(['id', 'number',]);
        foreach ($query->batch(1000) as $rows) {
            foreach ($rows as $row) {
                $articles[strtolower($row['number'])] = $row['id'];
            }
        }

        ConsoleHelper::debug('Извлечено '.count($articles).' записей из таблицы '.Articles::tableName(), true);

        $items = ParserLrpartsItems::find()->asArray()->select(['id', 'code', 'name',])->all();

        ConsoleHelper::debug('Извлечено '.count($items).' записей из таблицы '.ParserLrpartsItems::tableName(), true);

        foreach ($items as $item) {
            if (!isset($articles[strtolower($item['code'])])) {
                $data[] = $item;
            }
        }

        if ($data) {
            ConsoleHelper::debug('Найдено строк для обновления: '.count($data));

            $fp = fopen(\Yii::getAlias('@files').DIRECTORY_SEPARATOR.'missed_lrparts_items.csv', 'w');

            foreach ($data as $fields) {
                fputcsv($fp, $fields, ';');
            }

            fclose($fp);

            ConsoleHelper::debug('Файл записан');
        }

        $minutes = floor((time() - $totalTime) / 60);
        if ($minutes > 0) {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено минут: '.$minutes, true);
        } else {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено секунд: '.(time() - $totalTime), true);
        }

        return ExitCode::OK;
    }

    public function actionTest3()
    {
        $totalTime = time();
        $updated = ParserHelper::setEpcInArticles();

        ConsoleHelper::debug('Строк обновлено: '.$updated);

        $minutes = floor((time() - $totalTime) / 60);
        if ($minutes > 0) {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено минут: '.$minutes, true);
        } else {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено секунд: '.(time() - $totalTime), true);
        }

        return ExitCode::OK;
    }
}