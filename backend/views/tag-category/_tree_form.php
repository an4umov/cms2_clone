<?php

use yii\base\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var \common\models\TagCategory $node
 */


//$form = ActiveForm::begin();
//ActiveForm::end();


if ( ! $node->isNewRecord ) {


    $dataProvider = new \yii\data\ActiveDataProvider([
        'query' => $node->getTags(),
        'pagination' => [
            'pageSize' => 20,
        ],
    ]);

    echo $this->render('_tag_grid', [
        'dataProvider' => $dataProvider,
        'source' => \common\models\Menu::SOURCE,
        'parentId' => $node->id
    ]);
}



