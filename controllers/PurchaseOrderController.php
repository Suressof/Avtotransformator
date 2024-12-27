<?php

namespace app\controllers;

use app\models\Purchaseorder;
use app\models\PurchaseorderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Order;
use Yii;

/**
 * PurchaseorderController implements the CRUD actions for Purchaseorder model.
 */
class PurchaseorderController extends Controller
{
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
     * Lists all Purchaseorder models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PurchaseorderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Purchaseorder model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Purchaseorder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Purchaseorder();

        // if ($model->load(Yii::$app->request->post())) {
            $query = Order::find()->orderBy(['id'=>SORT_DESC])->limit(1)->one();
            $lastOrderId = $query->id;

            $cartItems = Yii::$app->session->get('cart', []);
            foreach ($cartItems as $productId) {
                $purchaseOrder = new Purchaseorder();
                $purchaseOrder->id_order = $lastOrderId;
                $purchaseOrder->id_product = $productId;
                $purchaseOrder->date = Yii::$app->formatter->asDateTime('now + 1 hour', 'php:H:i d.m.Y');
                $purchaseOrder->status = 'Не доставлен';
                $purchaseOrder->save();
            }
            Yii::$app->session->remove('cart'); // Очистить корзину после оформления заказа
    

            return $this->redirect(['/lk']);

            // return $this->redirect(['view', 'id' => $model->id]);
        // } else {
            // return $this->render('create', [
                // 'model' => $model,
            // ]);
        // }
    }

    public function actionSolve($id)
    {
        $model = $this->findModel($id);
        $model->status = 'Доставлен';
        $model->save();
        return $this->redirect(['/purchaseorder']);

    }

    /**
     * Updates an existing Purchaseorder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Purchaseorder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Purchaseorder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Purchaseorder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Purchaseorder::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
