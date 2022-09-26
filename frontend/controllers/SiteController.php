<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\base\Module;
use yii\db\Expression;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use core\ContentFilter;
use common\components\helpers\BlockHelper;
use common\components\helpers\ContentHelper;
use common\models\Block;
use common\models\ContentBlock;
use common\models\ContentBlockField;
use common\models\LoginForm;
use frontend\components\widgets\ProductOffersWidget;
use frontend\models\search\SiteSearch;
use frontend\models\SendQuestionForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    private $contentFilter;

    public function __construct(string $id, Module $module, ContentFilter $filter, array $config = [])
    {
        $this->contentFilter = $filter;
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                    'form-send' => ['post'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
//        $mainPageMaterial = Material::findOne(['is_main' => 1,]);
//        if (is_null($mainPageMaterial)) {
//            throw new NotFoundHttpException("Такой страницы не существует");
//        }
//        $content = $this->contentFilter->filter($mainPageMaterial->content);
//        return $this->render('index2', ['content' => $content, 'title' => $mainPageMaterial->title,]);

        return $this->render('index', [
            'indexPage' => BlockHelper::getIndexPage(),
            'title' => 'Главная страница',
        ]);
    }

    /**
     * @return string
     */
    public function actionSearch()
    {
        $request = Yii::$app->request->isPost ? Yii::$app->request->post() : Yii::$app->request->get();
        $params = [];
        if (!empty($request[SiteSearch::TEXT])) {
            $request[SiteSearch::TEXT] = trim($request[SiteSearch::TEXT]);
            $list = explode(' ', $request[SiteSearch::TEXT]);

            $params[ProductOffersWidget::PARAM_TEXT] = $request[SiteSearch::TEXT];
            if (count($list) > 1) {
                $params[ProductOffersWidget::PARAM_NUMBERS] = $list;
            } else {
                $params[ProductOffersWidget::PARAM_NUMBER] = $request[SiteSearch::TEXT];
            }
        }

        if (!empty($request['shop'])) {
            $params[ProductOffersWidget::PARAM_SHOP] = $request['shop'];
        }

        $errors = [];
        $searchModel = new SiteSearch();
        $searchModel->load($params);

        if (!$searchModel->validate()) {
            $errors = $searchModel->getErrors();
        }

//        $dataProvider = $searchModel->search($params);
//        $countQuery = clone $dataProvider->query;
//        $pages = new Pagination(['totalCount' => $countQuery->count(),]);

        return $this->render('search', [
            'params' => $params,
            'errors' => $errors,
            'searchModel' => $searchModel,
            'shop' => $request['shop'] ?? '',
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
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
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws NotFoundHttpException
     * @throws \ImagickException
     */
    public function actionSpecial(int $id)
    {
        $row = Block::find()
            ->select([
                Block::tableName().'.id',
                Block::tableName().'.name',
                Block::tableName().'.description',
                Block::tableName().'.type',
                Block::tableName().'.global_type',
                ContentBlockField::tableName().'.data',
                ContentBlock::tableName().'.id AS content_block_id',
                ContentBlock::tableName().'.type AS content_block_type',
                ContentBlock::tableName().'.sort AS content_block_sort',
                ContentBlock::tableName().'.is_active AS content_block_is_active',
                new Expression("NULL AS color"),
                new Expression("NULL AS color_bg"),
                new Expression("NULL AS emails"),
                new Expression("NULL AS result"),
            ])
            ->innerJoin(ContentBlock::tableName(), ContentBlock::tableName().'.block_id = '.Block::tableName().'.id')
            ->leftJoin(ContentBlockField::tableName(), ContentBlock::tableName().'.id = '.ContentBlockField::tableName().'.content_block_id')
            ->where([
                ContentBlock::tableName().'.type' => ContentBlock::TYPE_BLOCK,
                Block::tableName().'.id' => $id,
                Block::tableName().'.deleted_at' => null,
            ])
            ->asArray()
            ->indexBy('content_block_id')
            ->one();

        if (!$row) {
            throw new NotFoundHttpException('Спецпредложения не найдены');
        }

        $block = new Block();
        $block->setAttributes($row, false);
        $block->data = $row['data'];
        $block->content_block_id = $row['content_block_id'];
        $block->content_block_type = $row['content_block_type'];
        $block->content_block_sort = $row['content_block_sort'];

        $fields = ContentHelper::getBlockFields($block->id, ContentBlock::TYPE_BLOCK);
        $json = ContentHelper::getBlockJson($block);

        $params = ContentHelper::parseSpecialOfferBlock($fields, $json);

        return $this->render('special', [
            'models' => ContentHelper::getSpecialOfferData($params['flag'], $params['groups'], $params['isRandom'], 13),
            'header' => $params['header'],
            'headerColor' => $params['headerColor'],
        ]);
    }

    public function actionQuestionSend()
    {
        $model = new SendQuestionForm();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->sendEmail()) {
                        Yii::$app->session->setFlash('success', 'Вопрос отправлен');
                    } else {
                        Yii::$app->session->setFlash('error', 'Ошибка отправки вопроса');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка валидации формы: '.print_r($model->getErrors(), true));
                }
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка отправки вопроса: '.print_r($model->getErrors(), true));
            }
        } else {
            throw new BadRequestHttpException();
        }

        return $this->goBack(Yii::$app->request->referrer);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
