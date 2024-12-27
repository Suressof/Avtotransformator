<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
use app\models\Order;
use app\models\Comments;
use app\models\Category;
use app\models\Vendor;
use yii\widgets\ActiveForm;
use app\models\Product;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = $model->title;
if(Yii::$app->user->isGuest){
    $this->params['breadcrumbs'][] = $this->title;
}
else { 
    if(Yii::$app->user->identity->status == 1) {
        $this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
        $this->params['breadcrumbs'][] = $this->title;
    }
    else {
        $this->params['breadcrumbs'][] = $this->title;
    }
}
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">
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

        // var_dump($user = User::find()->where(['id' => 3])->all()); title echo

        $vendor = Vendor::findOne($model->id_vendor);
        $category = Category::findOne($model->id_category);

        // echo($vendor->title)
        $model->id_vendor = $vendor->title;
        $model->id_category = $category->title;

        $CommentsOrders = Comments::find()->where(['id_product'=>$model->id])->orderBy(['date'=>SORT_DESC])->all();
    ?>
        <div class="row">
            <div class="container col-lg-8">
                <img src="/assets/<?= $model->photo ?>" class="img-fluid" id="example" alt="...">
            </div>
            <div class="col-lg-4">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'title',
                        'weight',
                        'price',
                        'id_vendor',
                        'id_category',
                    ],
                ]) ?>
            </div>
        </div>
        <div>
            <div class="d-flex mt-5 justify-content-between"> 
                <h3 class="fst-italic">Комментарии товара</h3>
                <?= Html::a('Авторизоваться', ['/site/login'], ['class' => 'btn btn-success mb-3 me-2']) ?>
            </div>
            <ul class="list-unstyled">
            <?php
                $count = count($CommentsOrders);
                
                if ($count === 0) {
                    echo '
                    <li class="align-items-start align-items-lg-center border-top py-3">
                        <div class="text-secondary">
                            <h5 class="mb-0">Похоже у этого товара нет комментариев</h7>
                        </div>
                        </a>
                    </li>';
                }
                else {
                    foreach ($CommentsOrders as $CommentsOrder) {
                        $UserOrders = User::find()->where(['id'=>$CommentsOrder->id_user])->one();  

                            echo '
                            <li class="align-items-start align-items-lg-center border-top py-3">
                                <div class="col-lg-4">
                                    <h7 class="mb-0">'. $CommentsOrder->date . ' <b>' . $UserOrders->login. '</b></h7>
                                </div>
                                <div class="mt-3 text-secondary">
                                    <h6 class="mb-0">' . $CommentsOrder->comment. '</h6>
                                </div>
                                </a>
                            </li>';
                            }
                }
                ?>
                </ul>
        </div>
        <?php 
        } else { ?>

        <?php
            if(Yii::$app->user->identity->status == 1) {
        ?>
            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
            <?php
                $vendor = Vendor::findOne($model->id_vendor);
                $category = Category::findOne($model->id_category);

                // echo($vendor->title)
                $model->id_vendor = $vendor->title;
                $model->id_category = $category->title;

                $CommentsOrders = Comments::find()->where(['id_product'=>$model->id])->orderBy(['date'=>SORT_DESC])->all();          
            ?>
            <div class="row">
                <div class="container col-lg-8">
                    <img src="/assets/<?= $model->photo ?>" class="img-fluid" id="example" alt="...">
                </div>
                <div class="col-lg-4">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'title',
                            'weight',
                            'price',
                            'id_vendor',
                            'id_category',
                        ],
                    ]) ?>
                </div>
            </div>

            <div>
                <div class="d-flex mt-5 justify-content-between"> 
                    <h3 class="fst-italic">Комментарии товара</h3>

                    <?php Yii::$app->session->set('id_user', Yii::$app->user->identity->id); ?>
                    <?php Yii::$app->session->set('id_product', $model->id); ?>
                    <?= Html::a('Отправить комментарий', ['/comments/create'], ['class' => 'btn btn-success mb-3 me-2']) ?>
                </div>
                <ul class="list-unstyled">
                <?php
                $count = count($CommentsOrders);
                
                if ($count === 0) {
                    echo '
                    <li class="align-items-start align-items-lg-center border-top py-3">
                        <div class="text-secondary">
                            <h5 class="mb-0">Похоже у этого товара нет комментариев</h7>
                        </div>
                        </a>
                    </li>';
                }
                else {
                    foreach ($CommentsOrders as $CommentsOrder) {
                        $UserOrders = User::find()->where(['id'=>$CommentsOrder->id_user])->one();  

                            echo '
                            <li class="align-items-start align-items-lg-center border-top py-3">
                                <div class="col-lg-4">
                                    <h7 class="mb-0">'. $CommentsOrder->date . ' <b>' . $UserOrders->login. '</b></h7>
                                </div>
                                <div class="mt-3 text-secondary">
                                    <h6 class="mb-0">' . $CommentsOrder->comment. '</h6>
                                </div>
                                </a>
                            </li>';
                        }
                    }
                        ?>
                </ul>
            </div>
        <?php
        }
        else {
            $vendor = Vendor::findOne($model->id_vendor);
            $category = Category::findOne($model->id_category);

            // echo($vendor->title)
            $model->id_vendor = $vendor->title;
            $model->id_category = $category->title;

            $CommentsOrders = Comments::find()->where(['id_product'=>$model->id])->orderBy(['date'=>SORT_DESC])->all();          
            ?>
            <div class="row">
                <div class="container col-lg-8">
                    <img src="/assets/<?= $model->photo ?>" class="img-fluid" id="example" alt="...">
                </div>
                <div class="col-lg-4">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'title',
                            'weight',
                            'price',
                            'id_vendor',
                            'id_category',
                        ],
                    ]) ?>
                    <?= Html::a('Добавить в корзину', ['/cart/add', 'id' => $model->id], ['class' => 'btn btn-success mb-3 me-2']) ?>
                    
                </div>
            </div>

            <div>
                <div class="d-flex mt-5 justify-content-between"> 
                    <h3 class="fst-italic">Комментарии товара</h3>

                    <?php Yii::$app->session->set('id_user', Yii::$app->user->identity->id); ?>
                    <?php Yii::$app->session->set('id_product', $model->id); ?>
                    <?= Html::a('Отправить комментарий', ['/comments/create'], ['class' => 'btn btn-success mb-3 me-2']) ?>
                </div>
                <ul class="list-unstyled">
                <?php
                    $count = count($CommentsOrders);
                
                    if ($count === 0) {
                        echo '
                        <li class="align-items-start align-items-lg-center border-top py-3">
                            <div class="text-secondary">
                                <h5 class="mb-0">Похоже у этого товара нет комментариев</h7>
                            </div>
                            </a>
                        </li>';
                    }
                    else {
                        foreach ($CommentsOrders as $CommentsOrder) {
                        $UserOrders = User::find()->where(['id'=>$CommentsOrder->id_user])->one();  

                            echo '
                            <li class="align-items-start align-items-lg-center border-top py-3">
                                <div class="col-lg-4">
                                    <h7 class="mb-0">'. $CommentsOrder->date . ' <b>' . $UserOrders->login. '</b></h7>
                                </div>
                                <div class="mt-3 text-secondary">
                                    <h6 class="mb-0">' . $CommentsOrder->comment. '</h6>
                                </div>
                                </a>
                            </li>';
                        }
                    }
                    ?>
                </ul>
            </div>

            <?php
        }
    }
    ?>

</div>
