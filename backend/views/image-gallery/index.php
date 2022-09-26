<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $data array */
/* @var $dir string */
/* @var $initdir string */
/* @var $filepath string */
/* @var $isDirs bool */
/* @var $isFiles bool */

$this->registerJs('jQuery(".fancybox").fancybox();', $this::POS_READY);
$dirTitle = str_replace($initdir, '', $dir);
?>
<div class="filemgr-content">
    <div class="filemgr-content-body ps">
			<div class="row">
				<? if ($isDirs): ?>
				<div class="col-md-3 filemgr-left">
					<label class="d-block tx-medium tx-10 tx-uppercase tx-sans tx-spacing-1 tx-color-03 mg-b-15">Текущая Дериктория <b><?= $dirTitle ?: DIRECTORY_SEPARATOR ?></b></label>
					<div class="row row-xs">
						<? foreach ($data as $item): ?>
							<? if (!empty($item['isDir'])): ?>
								<div class="col-md-12">
									<a class="media media-folder image-gallery-open-btn link-02" href="#" data-path="<?= !empty($item['parentDir']) ? $item['parentDir'] : $item['fullPath'] ?>" data-initdir="<?= $item['initdir'] ?>">
										<div class="media-icon">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
												stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
												class="feather feather-folder" <?= !empty($item['parentDir']) ? 'style="color:#F67B1E;"' : '' ?>>
												<path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
											</svg>
										</div>
										<div class="media-body">
											<h6><?= $item['name'] ?></h6>
											<span>Файлов: <?= $item['fileCount'] ?></span>
										</div>
									</a>
								</div>
							<? endif; ?>
						<? endforeach; ?>
					</div>
				</div>
				<? endif; ?>
				<div class="<? if ($isDirs) { ?>col-md-9<?php } else { ?>col-md-12<?php } ?> filemgr-right">
					<? if ($isFiles): ?>
					<label class="d-block tx-medium tx-10 tx-uppercase tx-sans tx-spacing-1 tx-color-03 mg-b-15">Файлы</label>
					<div class="row row-xs">
						<? $index = 1; ?>
						<? foreach ($data as $item): ?>
							<? if (empty($item['isDir'])): ?>
								<div class="col-6 col-sm-4 col-md-2 col-xl">
									<div class="card card-file<?= $filepath === $item['path'] ? ' active' : '' ?>" >
										<div class="dropdown-file">
											<a class="image-gallery-select-btn dropdown-link" href="#" data-path="<?= $item['path'] ?>">
												<i class="fas fa-check-double"></i>
											</a>
										</div>
										<div class="card-file-thumb tx-indigo">
											<a class="" target="_blank" rel="group" href="<?= $item['webPath'] ?>"><?= Html::img($item['webPath'], ['alt' => $item['name'], 'data' => $item,]) ?></a>
										</div>
										<div class="card-body">
											<a href="#" data-path="<?= $item['path'] ?>" class="image-gallery-select-btn image-gallery-filename"><?= $item['name'] ?>											<span><?= $item['size'] ?>, <?= $item['resolution'] ?></span></a>
										</div>
									</div>
								</div>
								<? if ($index++ % 5 === 0): ?>
									<div class="d-none d-xl-block wd-100p ht-10"></div>
								<? endif; ?>
							<? endif; ?>
						<? endforeach; ?>
					</div>
					<? endif; ?>
				</div>
			</div>




    </div>
</div>