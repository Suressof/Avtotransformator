<?php

use app\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\Product;

/** @var yii\web\View $this */
/** @var app\models\CategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Категории товаров';
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

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if(Yii::$app->user->isGuest){
    ?>
        <div>
            <ul class="list-unstyled">
                <?php
                    foreach ($categories as $category) {
                        echo '
                        <li>
                        <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top" href="/category/view?id='. $category->id.'">
                            <svg class="bd-placeholder-img" width="100%" height="96" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><image xlink:href="../assets/' . $category->photo_asset. '" x="0" y="0" width="96" height="96"/></svg>
                            <div class="col-lg-8">
                            <h6 class="mb-0">' . $category->title. '</h6>
                            </div>
                        </a>
                        </li>';
                    }
                ?>
            </ul>
        </div>
    <?php   
    }
    else {
    ?>
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
        <?php
        }
        else {
        ?>
            <div>
                <ul class="list-unstyled">
                    <?php
                        foreach ($categories as $category) {
                            echo '
                            <li>
                            <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top" href="/category/view?id='. $category->id.'">
                                <svg class="bd-placeholder-img" width="100%" height="96" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><image xlink:href="../assets/' . $category->photo_asset. '" x="0" y="0" width="96" height="96"/></svg>
                                <div class="col-lg-8">
                                <h6 class="mb-0">' . $category->title. '</h6>
                                </div>
                            </a>
                            </li>';
                        }
                    ?>
                </ul>
            </div>


        <?php   
        }
    }
    ?>

</div>
