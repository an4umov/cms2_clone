<?php
use yii\helpers\Url;
use \common\components\helpers\CatalogHelper;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

?>
<h1>
	<a href="<?= Url::base(true) ?>" style="text-align: center; display: block;">
		<img src="<?= Url::base(true) ?>/img/logo.png" alt="">
	</a>
</h1>
<table style="max-width: 700px; width: 100%; margin: 0 auto;">
<? foreach ($data as $key => $item): ?>
	<tr style="border-bottom: 1px solid #ccc;">
		<td style="padding: 15px; border-bottom: 1px solid #ccc;">
			<img src="<?= Url::base(true) ?><?= $item['image']?>" alt="" style="width: 150px;">
		</td>
		<td style="padding: 15px; border-bottom: 1px solid #ccc;">
			<p><b><?= $item['name']?></b></p>
			<?= $item['description']?>
		</td>
		<td style="padding: 15px; color: orange; font-weight: bold; border-bottom: 1px solid #ccc;"><?= CatalogHelper::formatPrice($item['price'])?></td>
	</tr>
	<? 
		$articeIDs[] = $key;
	?>
<? endforeach; ?>
</table>
<h3 style="text-align: right; padding: 15px; display: block; max-width: 700px; width: 100%; margin: 0 auto; margin-top: 20px;"><a href="<?= Url::base(true) ?>/search?text=<?=implode('+', $articeIDs)?>">Посмотреть на сайте >></a></h3>
