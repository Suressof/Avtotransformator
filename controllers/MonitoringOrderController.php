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
class MonitoringorderController extends Controller
{

    public function actionIndex()
    {
        // $searchModel = new PurchaseorderSearch();
        // $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
        ]);
    }


}
