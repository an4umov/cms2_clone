<?php
/**
 * @var string $id
 * @var string $initdir
 * @var string $dir
 * @var string $filename
 * @var string $filepath
 * @var string $name
 * @var string $label
 * @var $this yii\web\View
 */

use kartik\dialog\Dialog;
use yii\web\JsExpression;
use yii\helpers\Html;

$widgetID = 'dialog-'.$id;
$widgetBtnID = 'dialog-btn-'.$id;
$libName = 'krajeeImgGallerySelect_'.str_replace("-", "_", $id);

echo Html::style('#'.$widgetID.' div.modal-dialog {width: 75%;}');
echo Html::style('#'.$widgetID.' div.bootstrap-dialog-message {height: 500px; overflow-y: auto;}');

echo Dialog::widget([
	'id' => $widgetID,
	'libName' => $libName,
	'options' => [
		'size' => Dialog::SIZE_WIDE,
		'type' => Dialog::TYPE_SUCCESS,
		'title' => 'Выбор изображения на сервере',
		'nl2br' => false,
		'buttons' => [
			[
				'id' => 'cust-cancel-btn',
				'label' => 'Отмена',
				'cssClass' => 'btn-outline-secondary',
				'hotkey' => 'C',
				'action' => new JsExpression("function(dialog) {
					return dialog.close();
				}")
			],
			[
				'id' => 'cust-submit-btn',
				'label' => 'Выбрать',
				'cssClass' => 'btn-success',
				'hotkey' => 'S',
				'action' => new JsExpression("function(dialog) {
					let item = app.getImageGalleryFilename();
					if(!!item) {
						jQuery('#".$id."').val(item);
						jQuery('#".$widgetBtnID."').data('filepath', item);
						return dialog.close();
					} else {
						app.addError('Выберите изображение');
					}
				}")
			],
		],
		'onshow' => new JsExpression("function(dialogRef) {
			dialogRef.getModalBody().find('div.bootstrap-dialog-message').css('height', document.documentElement.clientHeight / 100 * 70 + 'px');
		}"),
	],
]);
?>
<div class="add-img-group">
	<? if ($label): ?>
		<label class="control-label" for="<?= $id ?>"><?= $label ?></label>
	<? endif; ?>
	<div class="add-img-group__wrapper-img">
		<div class="add-img-group__inner-img">
		<? if (is_file($dir.$filepath) && file_exists($dir.$filepath)) { ?>
			<a href="/img/post<?=$filepath; ?>" target="_blank" class="image-size">
			<?
				$fileSize = filesize($dir.$filepath);
				$imageWidth = getimagesize($dir.$filepath)[0];
				$imageHeight = getimagesize($dir.$filepath)[1];
				echo round($fileSize / 1024, 2) . ' KB, ' .$imageWidth.'x'.$imageHeight;
				if ($imageWidth > 2000) {
					echo ' <i class="fas fa-exclamation-circle" title="изображение слишком большое"></i>';
				}
			?>
			</a>
			<?= Html::beginTag('button', ['id' => $widgetBtnID, 'type' => 'button', 'class' => 'image-gallery-btn', 'data' => ['initdir' => $initdir, 'dir' => $dir, 'filepath' => $filepath, 'libname' => $libName,],]); ?>
				<img src="/img/post<?=$filepath; ?>" alt="">
				<i class="far fa-file-image"></i>
			<?= Html::endTag('button');?>
		<? } elseif ($filename) { ?>
			<? 
				parse_str( parse_url( $filepath, PHP_URL_QUERY ), $filepath_vars );
				foreach ($filepath_vars as $val) {
					$yt_id = $val; 
					if($yt_id) {
						$filename = 'https://img.youtube.com/vi/'.$yt_id.'/0.jpg';
					}
				}
			?>
			<?= Html::beginTag('button', ['id' => $widgetBtnID, 'type' => 'button', 'class' => 'image-gallery-btn', 'data' => ['initdir' => $initdir, 'dir' => $dir, 'filepath' => '/', 'libname' => $libName,],]); ?>
				<img src="<?= $filename ?>" alt="">
				<i class="far fa-file-image"></i>
			<?= Html::endTag('button');?>
			<a href="<?= $filepath ?>" target="_blank" class="image-size">
				youtube
			</a>
		<? } else { ?>
			<?= Html::beginTag('button', ['id' => $widgetBtnID, 'type' => 'button', 'class' => 'image-gallery-btn', 'data' => ['initdir' => $initdir, 'dir' => $dir, 'filepath' => $filepath, 'libname' => $libName,],]); ?>
				<img class="no-image" src="/img/no-image.jpg" alt="">
				<i class="far fa-file-image"></i>
			<?= Html::endTag('button');?>
		<? } ?>
		</div>
	</div>
	<?= Html::textInput($name, $filepath, ['class' => 'form-control', 'id' => $id, 'placeholder' => 'Нажмите на блок изображения для выбора картинки']) ?>
</div>
