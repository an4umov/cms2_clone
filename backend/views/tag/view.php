<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Tag */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Теги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tag-view">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Действительно удалить этот тег?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <?php

    /*$dataProvider = new \yii\data\ActiveDataProvider([
        'query' => \common\models\UserReferal::find()->alias('uf')
            ->where(['user_id'=>$model->user])
            ->leftJoin('program', '`program`.`id` = `uf`.`program_id`')
            ->andWhere(['program.reward' => \common\models\Program::REWARD_TYPE_CASH]),
        'pagination' => [
            'pageSize' => 20,
        ],
    ]);*/

    $dataProvider = new \yii\data\ActiveDataProvider([
        'query' => $model->getMaterials(),
        'pagination' => [
            'pageSize' => 20,
        ],
    ]);

    echo $this->render('../material/_grid', ['dataProvider' => $dataProvider, 'source' => 'tag']);

    ?>

</div>
