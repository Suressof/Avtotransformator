<?php

namespace app\controllers;
use Yii;
use app\models\RegForm;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Payment;
use yii\helpers\ArrayHelper;
use app\models\Product;

/**
 * AdminController implements the CRUD actions for User model.
 */
class LkController extends Controller
{
    public function beforeAction($action)
    {
        if(Yii::$app->user->isGuest || Yii::$app->user->identity->status==1) {
            $this->redirect(['/site/login']);
            return false;
        }
        if(!parent::beforeAction($action)) {
            return false;
        }

        return true; // or false to not run the action
    }
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $payments = Payment::find()->all();
        $payments = ArrayHelper::map($payments, 'id', 'title');

        $model = new Product();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'payments' => $payments,
            'model' => $model,
        ]);
    }

}
