<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\CartItem;
use app\models\Product;

class CartController extends Controller
{
    public function actionIndex()
    {
        $cartItems = Yii::$app->session->get('cart', []);
        return $this->render('index', ['cartItems' => $cartItems]);
    }

    public function actionAdd($id)
    {
        $cartItems = Yii::$app->session->get('cart', []);
        if (!in_array($id, $cartItems)) {
            $cartItems[] = $id;
            Yii::$app->session->set('cart', $cartItems);
        }
        Yii::$app->session->setFlash('success', 'Товар был добавлен в корзину');

        return $this->redirect(['product/view', 'id' => $id]);
        // var_dump($product);
    }

    public function actionRemove($id)
    {
        $cartItems = Yii::$app->session->get('cart', []);
        $index = array_search($id, $cartItems);
        if ($index !== false) {
            unset($cartItems[$index]);
            Yii::$app->session->set('cart', $cartItems);
        }
        Yii::$app->session->setFlash('danger', 'Товар был удален из корзины');
        return $this->redirect(['product/view', 'id' => $id]);
    }
}