<?php

namespace backend\models;

use common\models\User;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class UserSearch extends User
{
    public $name, $item_name;

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return ArrayHelper::merge(parent::attributes(), ['name', 'item_name']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [self::attributes(), 'safe']
        ];
    }

    public function search()
    {
        $query = self::find()->joinWith(['profile', 'role', 'authAssignment']);
        $query->andFilterWhere(['user.id' => $this->id]);
        $query->andFilterWhere(['ilike', 'profile.full_name', $this->name]);
        $query->andFilterWhere(['ilike', 'email', $this->email]);
        $query->andFilterWhere(['auth_assignment.item_name' => $this->item_name]);
        $query->andFilterWhere(['status' => $this->status]);

        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $dataProvider->sort->attributes['name'] = [
            'asc' => ['profile.full_name' => SORT_ASC],
            'desc' => ['profile.full_name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['role'] = [
            'asc' => ['role.name' => SORT_ASC],
            'desc' => ['role.name' => SORT_DESC],
            'label' => 'role',
        ];

        return $dataProvider;
    }
}