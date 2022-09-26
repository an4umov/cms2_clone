<?php

use yii\db\Migration;

/**
 * Class m200501_070431_department_models_alter
 */
class m200501_070431_department_models_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\DepartmentModel::tableName(), 'url', $this->string(25)->null());//
        $this->addColumn(\common\models\DepartmentModel::tableName(), 'name', $this->string(255)->null());//
        $this->addColumn(\common\models\DepartmentModel::tableName(), 'image', $this->string(255)->null());
        $this->addColumn(\common\models\DepartmentModel::tableName(), 'is_active', $this->boolean()->null()->defaultValue(true));//
        $this->addColumn(\common\models\DepartmentModel::tableName(), 'sort', $this->integer()->null()->unsigned());//

        $models = \common\models\DepartmentModel::find()->all();
        foreach ($models as $model) {
            $url = substr(sha1($model->word_1.'_'.microtime()), 0, 8);
            $model->url = $url;
            $model->name = $model->word_1.($model->word_2 ? ' '.$model->word_2 : '');
            $model->is_active = true;
            $model->sort = $model->id;
            $model->save();

            $list = \common\models\DepartmentModelList::findAll(['department_model_id' => $model->id,]);

            foreach ($list as $item) {
                $newModel = new \common\models\DepartmentModel();
                $newModel->department_id = $model->department_id;
                $newModel->word_1 = $model->word_1;
                $newModel->word_2 = $model->word_2;
                $newModel->default_title = $model->default_title;

                $newModel->url = $item->url;
                $newModel->name = $item->name;
                $newModel->image = '';
                $newModel->is_active = $item->is_active;
                $newModel->sort = $item->sort;
                $newModel->save();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
