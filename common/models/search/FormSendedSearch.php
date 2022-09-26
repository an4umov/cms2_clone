<?php

namespace common\models\search;

use common\models\FormSended;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;

/**
 * FormSendedSearch represents the model behind the search form of `common\models\FormSended`.
 */
class FormSendedSearch extends FormSended
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['form_id',], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @param null $formID
     *
     * @return ActiveDataProvider
     */
    public function search($formID = null)
    {
        $this->form_id = $formID;

        $query = FormSended::find();
        $query->filterWhere(['form_id' => $this->form_id,]);
        $query->orderBy(['updated_at' => SORT_DESC,]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}
