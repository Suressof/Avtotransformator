<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\PurchaseOrder;
use app\models\Category;
use app\models\Order;
use app\models\User;
use app\models\News;
use app\models\Payment;
use yii\helpers\ArrayHelper;
use app\models\Product;
use app\models\ChangePasswordForm;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

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
        $model = new Product();

        $purchaseOrders = PurchaseOrder::find()->where(['status'=>'Доставлен'])->orderBy(['date'=>SORT_DESC])->limit(4)->all();  
        $users = User::find()->all();  
        $news = News::find()->all();      
        $categories = Category::find()->all();      

        $payments = Payment::find()->all();
        $payments = ArrayHelper::map($payments, 'id', 'title');

        $dataProvider = new ActiveDataProvider([
            'query' => PurchaseOrder::find()->where(['status'=>'Доставлен']),
            'pagination' => [
                'pageSize' => 4, // Количество элементов на странице
            ],
        ]);
        
        return $this->render('index', [
            'purchaseOrders'=>$purchaseOrders,
            'users'=>$users,
            'news'=>$news,
            'categories'=>$categories,
            'payments' => $payments,
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
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

        $model->password = '';
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


    public function actionConfirmEmail($token)
    {
        // Получение токена из сессии
        $sessionToken = Yii::$app->session->get('emailVerificationToken');
        // $emailUser = Yii::$app->session->get('emailUser');

        // Сравнение токенов
        if ($token !== $sessionToken) {
            throw new NotFoundHttpException('Неверный токен подтверждения email.');
        }

        // Очистка токена в сессии
        Yii::$app->session->remove('emailVerificationToken');

        // Здесь выполняйте необходимые действия при подтверждении email, например, активацию аккаунта и т.д.

        Yii::$app->session->setFlash('success', 'Email успешно подтвержден.');

        return $this->redirect(['site/change-password']);
    }

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();

        $emailUser = Yii::$app->session->get('emailUser');

        if ($model->load(Yii::$app->request->post())) {

            $model1 = $this->findByEmail($emailUser);

            $model1->password = $model->newPassword;
            $model1->save();

            return $this->redirect(['site/login']);
        }

        return $this->render('changepassword', [
            'model' => $model,
        ]);
    }

    public static function findByEmail($email)
    {
        return User::findOne(['email' => $email]);
    }
}
