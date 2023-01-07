<?php

namespace frontend\models\search;

use common\models\Articles;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

class SiteSearch extends Model
{
    const PAGESIZE = 10;
    const TEXT = 'text';
    const SEARCH_IN_ARTICLE = 'search_in_article';
    const SEARCH_IN_NAME = 'search_in_name';

    const TYPE_CONTAINS = 'contains';
    const TYPE_EQUALS = 'equals';
    const TYPE_BEGIN = 'begin';

    const TYPES = [self::TYPE_CONTAINS, self::TYPE_EQUALS, self::TYPE_BEGIN,];

    public $text;
    public $search_in_article;
    public $search_in_name;
//    public $type;
//    public $search_in_url;
//    public $search_in_title;
//    public $search_in_description;
//    public $search_in_username;
//    public $is_show_archive;
//    public $is_only_favorite;

    public function init()
    {
        parent::init();
        $this->search_in_name = true;
//        $this->type = self::TYPE_CONTAINS;
//        $this->search_in_url = false;
//        $this->search_in_title = true;
//        $this->search_in_description = true;
//        $this->search_in_username = false;
//        $this->is_show_archive = true;
//        $this->is_only_favorite = false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            ['type', 'in', 'range' => self::TYPES,],
            [self::TEXT, 'trim',],
            [self::TEXT, 'string', 'length' => [4, 500,],],
            [self::TEXT, 'required',],
//            [[self::TEXT, /*'search_in_url', 'search_in_title', 'search_in_description', 'search_in_username', 'is_show_archive', 'is_only_favorite',*/], 'safe',],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            self::TEXT => 'Поле поиска',
        ];
    }

    public function load($data, $formName = null)
    {
        if (!empty($data[self::TEXT])) {
            $this->text = $data[self::TEXT];
        }

        if (!empty($data[self::SEARCH_IN_ARTICLE])) {
            $this->search_in_article = true;
        } else {
            $this->search_in_article = false;
        }

        return true;
    }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) : ActiveDataProvider
    {
        $query = Articles::find()
            ->joinWith('fullPriceItems')
            ->where('0 = 1')
            ->orderBy([Articles::tableName().'.name' => SORT_ASC,]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => self::PAGESIZE,],
        ]);

        $this->load($params);

        if (!empty($params[self::TEXT])) {
            $this->text = $params[self::TEXT];
        }

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->where('');

        if (!empty($this->text)) {
            $query->andWhere(['ilike', Articles::tableName().'.name', $this->text,]);
        }
        if (!empty($params[self::SEARCH_IN_ARTICLE])) {
            $query->orWhere(['ilike', Articles::tableName().'.number', '%'.$this->text.'%',]);
        }

        return $dataProvider;
    }
}