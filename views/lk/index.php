<?php

use app\models\Category;
use app\models\PurchaseOrder;
use app\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Product;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\CategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

<!-- Modal -->
<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Корзина</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">  
                <?php
                    $cartItems = Yii::$app->session->get('cart', []);
                    $count = count($cartItems);

                    if($count == 0) {
                        echo 'В корзине пусто';
                    }
                    $totalPrice = 0;
                    try { 
                        foreach ($cartItems as $productId): $Product = Product::find()->where(['id'=> $productId])->one(); 
                        $totalPrice += $Product->price; ?>
                    <div class="d-flex">
                        <img class="card-img" src="/assets/<?= $Product->photo ?>" alt="фото" style="width: 100px; height: 100px;">
                        <div>
                            <p>Product ID: <?= $productId . ' Цена: ' . $Product->price ?> <a href="<?= Yii::$app->urlManager->createUrl(['cart/remove', 'id' => $productId]) ?>">Удалить</a></p>
                            <p><?= $Product->title ?></p>
                        </div>
                    </div>
                <?php endforeach; } catch (\Throwable $th) { } ?>
                <hr>
                <div class="d-flex">  
                    <h2 class="fs-5 me-4">Выбирите способ оплаты</h2>
                    <?php $form = ActiveForm::begin(['id' => 'myForm']); echo 'Общая сумма: ' . $totalPrice . ' руб.'; ?>
                    <?= Html::dropDownList('dropdown', null, $payments, ['id' => 'my-dropdown', 'style' => 'padding: 2px; border-radius: 10px;']) ?>
                    <!-- <?= $form->field($model, 'id')->dropDownList($payments) ?> -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                <?= Html::submitButton('Далее', ['class' => 'btn btn-primary', 'id' => 'submitButton', 'name' => 'submit-button', 'data-bs-target'=>'#exampleModalToggle2', 'data-bs-toggle'=>'modal']) ?>
            <?php ActiveForm::end(); ?>
            </div>
            </div>
        </div>
    </div>
    <div class="modal" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Подтверждение заказа</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Ваш заказ был отправлен <br> Вы можете просмотреть ваши отправленные заказы в своем <a href="/lk">Личном кабинете</a>
            </div>
            <div class="modal-footer">
            <?php $form = ActiveForm::begin(['id' => 'myForm1', 'action' => 'http://avtotransformator/purchaseorder/create']); ?>
            <?php try { 
                foreach ($cartItems as $productId): ?>
                <!-- <?= Html::textInput('productId', $productId, ['class' => 'form-control']) ?> -->
                
                <?= $form->field($model, '')->textInput(['value' => $productId, 'class' => 'd-none']) ?>
                <?php endforeach; } catch (\Throwable $th) { } ?>

                <?= Html::submitButton('Подтверждение', ['class' => 'btn btn-primary', 'id' => 'submitButton1', 'data-bs-target'=>'#exampleModalToggle2', 'data-bs-toggle'=>'modal']) ?>
                <?php ActiveForm::end(); ?>

                <!-- <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Back to first</button> -->
            </div>
            </div>
        </div>
    </div>

    <script>
    $("#submitButton").click(function (e) {
    e.preventDefault();
    var formData = new FormData($("#myForm")[0]);
        $.ajax({
            type: "POST",
            url: "http://avtotransformator/order/create",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                console.log(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Ошибка запроса:", textStatus, errorThrown);
            }
        });
    });
    </script>

    <h1><?= Html::encode($this->title) . ' - ' . Yii::$app->user->identity->login ?></h1>
    <h2>Ваши заказы</h2>

    <div class="d-flex col-lg-12 text-center">
        <h6 class="col-md-3">Фото</h6>
        <h6 class="col-md-3">Наименование</h6>
        <h6 class="col-md-3">Дата</h6>
        <h6 class="col-md-3">Статус</h6>
    </div>

    <?php
        if(Yii::$app->user->identity->status == 1) {
        ?>
        <p>
            <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'title',
                // 'photo_asset',
                [
                    'attribute' => 'photo_asset',
                    'format' => 'raw',
                    'value' => function($model) {
                        return $model->getImageHtml();
                    },
                ],
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Category $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ],
            ],
        ]); ?>
        <?php } else { ?>
        <div>
            <ul class="list-unstyled">
                <?php
                    $id_order = Order::find()->where(['id_client'=>Yii::$app->user->identity->id])->all();
                    foreach ($id_order as $id) {
                        $id_purchaseorder = PurchaseOrder::find()->where(['id_order'=>$id->id])->all();
                        // var_dump($id->id);
                        foreach ($id_purchaseorder as $product) {
                        $Products = Product::find()->where(['id'=>$product->id_product])->one();

                            echo '
                            <li>
                                <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top" href="/product/view?id=' . $product->id_product . '">
                                    <div class="d-flex col-lg-12 text-center align-items-center">
                                        <img class="col-md-3" src="/assets/' . $Products->photo . '" alt="фото" >
                                        <h6 class="col-md-3 ">' . $Products->title. '</h6>
                                        <h6 class="col-md-3">' . $product->date. '</h6>
                                        <h6 class="col-md-3">' . $product->status. '</h6>
                                    </div>
                                </a>
                            </li>';
                        }
                    }
                    // echo(Yii::$app->user->identity->id);


                
                ?>
            </ul>
        </div>
        <?php   
        }
    ?>

</div>
