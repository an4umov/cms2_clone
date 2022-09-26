<?php

/* @var \yii\web\View $this */
/* @var \common\models\Page $model */

$this->title = $model->title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $model->meta_keywords,
], 'keywords');

$this->registerMetaTag([
    'name' => 'description',
    'content' => $model->meta_description,
], 'description');


//$leaves = $model->leaves()->orderBy('lvl')->all();
$items = $model->children()->where(['lvl' => ($model->lvl + 1), 'active' => true])->orderBy('lvl')->all();

?>
<?php if (count($items)): ?>
    <!-- меню раздела -->
    <section class="mainmenu">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container mycontainer">

                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <?php foreach ($items as $item): ?>
                            <?php
                            $leaves = $item->leaves()->all();
                            ?>
                            <li class="nav-item dropdown active">
                                <?php echo \yii\helpers\Html::a($item->title, Yii::$app->urlManager->createUrl($item->alias), [
                                    'class' => ! empty($leaves) ? 'nav-link dropdown-toggle' : 'nav-link',
                                    'id' => $item->alias . '_navbarDropdown',
                                    'role' => "button",
                                    'data-toggle' => ! empty($leaves) ? "dropdown" : '',
                                    'aria-haspopup' => "true",
                                    'aria-expanded' => 'false'
                                ]); ?>

                                <?php if (! empty($leaves)): ?>
                                <div class="dropdown-menu" aria-labelledby="<?php echo $item->alias . '_navbarDropdown' ?>">
                                    <?php foreach ($leaves as $leave) {
                                        echo \yii\helpers\Html::a($leave->title, Yii::$app->urlManager->createUrl($leave->alias), ['class' => 'dropdown-item']);
                                    }?>
                                </div>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>

                    </ul>

                </div>
            </div>
        </nav>

    </section>
<?php endif; ?>
    <h2><?php echo $model->title ?></h2>
<?php echo $model->content ?>