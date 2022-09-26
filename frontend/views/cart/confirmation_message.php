<?php
/**
 * @var \yii\web\View $this
 * @var $activeAction string
 * @var $cartSettings array
 * @var $message string
 */

$this->title = $cartSettings['name'];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];
$this->params['activeAction'] = $activeAction;

use \common\components\helpers\CatalogHelper;
use common\models\Catalog;
use common\models\ShopOrder;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\components\helpers\CartHelper;
?>

<!-- Cart-confirmation -->
<section class="cart-confirmation">
    <h3 style="text-align: center;  margin: 150px;"><?= $message ?></h3>
</section>
