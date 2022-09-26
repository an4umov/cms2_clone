<?php
namespace backend\controllers;

use common\models\Block;
use common\models\Content;
use common\models\ContentBlock;
use common\models\CustomTag;
use common\models\Department;
use common\models\DepartmentMenu;
use common\models\DepartmentModel;
use common\models\FormSended;
use common\models\QuestionSended;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'test',],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $query = "
            select
                count(id) as cnt,
                type
            from content
            where deleted_at is null and type <> 'setting'
            group by type
            order by type
        ";
        $cmd = Yii::$app->db->createCommand($query);
        $contentTypeCounts = [];
        foreach ($cmd->queryAll() as $item) {
            $contentTypeCounts[$item['type']] = $item['cnt'];
        }

        $query = "
            select
                count(id) as cnt,
                type
            from content_block
            where is_active = true
            group by type
            order by type
        ";
        $cmd = Yii::$app->db->createCommand($query);
        $contentBlockTypeCounts = [];
        foreach ($cmd->queryAll() as $item) {
            $contentBlockTypeCounts[$item['type']] = $item['cnt'];
        }

        $query = "
            select
                content_block.block_id,
                block.global_type,
                count(content_block.id) as cnt
            from content_block
            inner join block on content_block.block_id = block.id and block.deleted_at is null
            where content_block.is_active = true AND block.global_type is not null
            group by content_block.block_id, block.global_type
        ";
        $cmd = Yii::$app->db->createCommand($query);
        $globalTypeCounts = [];
        foreach ($cmd->queryAll() as $item) {
            $globalTypeCounts[$item['global_type']] = $item['cnt'];
        }

        $countStructureDepartment = Department::find()->where(['is_active' => true,])->count();
        $countStructureMenu = DepartmentMenu::find()->where(['is_active' => true,])->count();
        $countStructureModel = 0; //@TODO переделать на count новой таблицы моделей
        $countStructureTag = CustomTag::find()->where(['is_active' => true,])->count();

        $data = [
            Content::TYPE_NEWS => [],
            Content::TYPE_ARTICLE => [],
            Content::TYPE_PAGE => [],
        ];

        $start = strtotime('-1 year');
        $startDay = mktime(0, 0, 0, date('m', $start), 1, date('Y', $start));
        $endDay = mktime(23, 59, 59, date('m'), date('d'), date('Y'));

        for ($date = $startDay; $date < $endDay; $date = strtotime("+1 day", $date)) {
            $key = date('m.Y', $date);

            $data[Content::TYPE_NEWS][$key] = $data[Content::TYPE_ARTICLE][$key] = $data[Content::TYPE_PAGE][$key] = 0;
        }

        $news = Content::find()
            ->select(['id', 'created_at',])
            ->where(['between', 'created_at', $startDay, $endDay])
            ->andWhere(['type' => Content::TYPE_NEWS, ])
            ->orderBy(['created_at' => SORT_ASC,])->asArray()->all();

        foreach ($news as $new) {
            $key = date('m.Y', $new['created_at']);
            $data[Content::TYPE_NEWS][$key] += 1;
        }

        $articles = Content::find()
            ->select(['id', 'created_at',])
            ->where(['between', 'created_at', $startDay, $endDay])
            ->andWhere(['type' => Content::TYPE_ARTICLE, ])
            ->orderBy(['created_at' => SORT_ASC,])->asArray()->all();

        foreach ($articles as $article) {
            $key = date('m.Y', $article['created_at']);
            $data[Content::TYPE_ARTICLE][$key] += 1;
        }

        $pages = Content::find()
            ->select(['id', 'created_at',])
            ->where(['between', 'created_at', $startDay, $endDay])
            ->andWhere(['type' => Content::TYPE_NEWS, ])
            ->orderBy(['created_at' => SORT_ASC,])->asArray()->all();

        foreach ($pages as $page) {
            $key = date('m.Y', $page['created_at']);
            $data[Content::TYPE_PAGE][$key] += 1;
        }

        ////////////////////////////////////////////////////////////

        $sendedData = [
            QuestionSended::tableName() => [],
            FormSended::tableName() => [],
        ];

        $start = strtotime('-1 month');
        $startDay = mktime(0, 0, 0, date('m', $start), date('d', $start), date('Y', $start));
        $endDay = mktime(23, 59, 59, date('m'), date('d'), date('Y'));

        for ($date = $startDay; $date < $endDay; $date = strtotime("+1 day", $date)) {
            $key = date('d.m.Y', $date);

            $sendedData[QuestionSended::tableName()][$key] = $sendedData[FormSended::tableName()][$key] = 0;
        }

        $questions = QuestionSended::find()
            ->select(['id', 'created_at',])
            ->where(['between', 'created_at', $startDay, $endDay])
            ->orderBy(['created_at' => SORT_ASC,])->asArray()->all();
        foreach ($questions as $question) {
            $key = date('d.m.Y', $question['created_at']);
            $sendedData[QuestionSended::tableName()][$key] += 1;
        }

        $forms = FormSended::find()
            ->select(['id', 'created_at',])
            ->where(['between', 'created_at', $startDay, $endDay])
            ->orderBy(['created_at' => SORT_ASC,])->asArray()->all();
        foreach ($forms as $form) {
            $key = date('d.m.Y', $form['created_at']);
            $sendedData[FormSended::tableName()][$key] += 1;
        }

        return $this->render('index', [
            'countStructureDepartment' => $countStructureDepartment,
            'countStructureMenu' => $countStructureMenu,
            'countStructureModel' => $countStructureModel,
            'countStructureTag' => $countStructureTag,

            'data' => $data,
            'sendedData' => $sendedData,
            'contentBlockTypeCounts' => $contentBlockTypeCounts,
            'globalTypeCounts' => $globalTypeCounts,
            'contentTypeCounts' => $contentTypeCounts,
        ]);
    }

    public function actionTest()
    {
        return $this->render('test');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
