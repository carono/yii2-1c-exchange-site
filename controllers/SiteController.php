<?php

namespace app\controllers;

use app\models\FileUpload;
use app\models\Group;
use app\models\Offer;
use app\models\Product;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionGroup($id)
    {
        if (!$group = Group::findOne(['id' => (int)$id])) {
            throw new NotFoundHttpException('Group not found');
        }
        $dataProvider = Offer::find()->joinWith(['product'])->andWhere(['group_id' => $group->id])->search();
        return $this->render('product', ['group' => $group, 'dataProvider' => $dataProvider]);
    }

    public function actionOffer($id)
    {
        if (!$offer = Offer::findOne(['id' => (int)$id])) {
            throw new NotFoundHttpException('Offer not found');
        }
        return $this->render('offer', ['offer' => $offer]);
    }

    public function actionImage($id)
    {
        if (!($file = FileUpload::findOne($id)) || !$file->fileExist()) {
            throw new FileNotFoundException();
        }
        $content = file_get_contents($file->getFullPath());
        Yii::$app->response->sendContentAsFile($content, $file->getFullName());
    }
}
