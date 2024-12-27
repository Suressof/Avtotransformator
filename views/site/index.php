<?php
use app\models\Order;
use app\models\Product;
use app\models\PurchaseOrder;
use app\models\User;
use yii\bootstrap5\Html;
use yii\web\RedirectAction;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\widgets\ListView;

/** @var yii\web\View $this */

$this->title = 'Avtotransformator';
?>
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

<div class="site-index">
<div class="row g-5">
    <div class="col-md-9">
        <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-image" style="background: linear-gradient(45deg, orange 10%, transparent 75%); background-size: cover; background-position: center center;">
            <!-- <img src="../assets/atf.png" class="w-100" alt="..."> -->
            <div class="col-lg-6 px-0">
            <h1 class="display-4 fst-italic">"Автотрансформатор"</h1>
            <h6 class="lead my-3">Комплектующие для силовых и распределительных трансформаторов от производителя</h6>
            <p class="lead mb-0"><a href="#" class="text-body-emphasis fw-bold">Далее...</a></p>
            </div>
        </div>

        <!-- <div class="jumbotron text-center bg-transparent">
            <h1 class="display-8">Завод "Автотрансформатор": <br> Комплектующие для силовых и распределительных трансформаторов от производителя</h1>
            <p class="lead">Производство комплектующих для силовых и распределительных трансформаторов в сфере электроэнергетики, нефтегазовой и химической промышленности.</p> -->
            <!-- <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p> -->
        <!-- </div> -->

        <article class="blog-post">
            <h2 class="display-5 link-body-emphasis mb-1">Новости</h2>
            <?php
                foreach ($news as $new) {
                    echo '
                    <p class="blog-post-meta">' . $new->date. ' от <span>Admin</span></p>

                    <h4>' . $new->title. '</h4>
                    <p>' . $new->new. '</p>
                    <hr>';
                }
            ?>
        </article>
    </div>
    <div class="col-md-3">
      <div class="position-sticky" style="top: 2rem;">
        <div class="p-4 mb-3 bg-body-tertiary rounded">
          <h4 class="fst-italic">О нас</h4>
          <p class="mb-0">Завод «Автотрансформатор», успешно работает на электроэнергетическом рынке РФ и стран СНГ c 2020 года.</p>
        </div>

        <div>
          <h4 class="fst-italic">Категории товаров</h4>
          <ul class="list-unstyled">
            <?php
                foreach ($categories as $category) {
                    echo '
                    <li>
                      <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top" href="/category/view?id='. $category->id.'">
                        <svg class="bd-placeholder-img" width="100%" height="96" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><image xlink:href="../assets/' . $category->photo_asset. '" x="0" y="0" width="76" height="96"/></svg>
                        <div class="col-lg-8">
                          <h6 class="mb-0">' . $category->title. '</h6>
                        </div>
                      </a>
                    </li>';
                  }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </div>

    <h3 class="pb-4 mt-4 mb-4 fst-italic border-bottom">
        О нас
    </h3>

    <div class="container">
    <p class="text-indent">Завод «Автотрансформатор», успешно работает на электроэнергетическом рынке РФ и стран СНГ c 2020 года. Производимые нами компоненты используются ведущими трансформаторными заводами России для процессов производства и модернизации силовых трансформаторов.

        Собственное производство комплектующих для силовых и распределительных трансформаторов  «Автотрансформатор» постоянно расширяется и модернизируется, ориентируясь на потребности наших партнёров. Квалифицированный персонал чётко следует технологическим картам этапов производства, особое внимание уделяя качеству выпускаемой продукции.

        Специалисты компании оказывают всю необходимую помощь Заказчику, от консультации и до технически обоснованного выбора продукции.</p>
    </div>
    

    <h3 class="pb-4 mb-4 fst-italic border-bottom">
        Комплектующие для трансформаторов
    </h3>
    
    <div id="carouselExampleDark" class="carousel carousel-dark slide bg-body-secondary bg-gradient" style="--bs-bg-opacity: .8; width: 75%; margin: 10px auto; border-radius: 20px;">
        <div class="carousel-indicators w-70">
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="10000">
                <img src="/assets/trans-silovoj_500-300x300.png" class="d-block" style="width: 350px; height: 350px; margin: 0 auto;" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Силовые трансформаторы</h5>
                    <p>Комплектующие для силовых трансформаторов</p>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <img src="/assets/atf.png" class="d-block" style="width: 350px; height: 350px; margin: 0 auto;" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Распределительные трансформаторы</h5>
                    <p>Комплектующие для распределительных трансформаторов.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="..." class="d-block" style="width: 350px; height: 350px; margin: 0 auto;" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Электротехническое оборудование</h5>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <h3 class="pt-4 pb-4 mb-4 fst-italic border-bottom">
        Закупки товаров, которые были доставлены
    </h3>

    <div class="body-content">

        <div class="row">
        <?php
            foreach ($dataProvider->getModels() as $model) {
                // Ваш код для отображения элемента
                    $Product = Product::find()->where(['id'=>$model->id_product])->one();
                    $Order = Order::find()->where(['id'=>$model->id_order])->one();
                    $Users = User::find()->where(['id'=>$Order->id_client])->one();
                    echo '
                    <div class="col-lg-3 mb-3" style="text-align: center;">
                        <img class="card-img" src="/assets/'.$Product->photo.'" alt="фото" style="width: 230px; height: 230px;">
                        <p>'.$Product->title.'</p>
                        <p>'.$Users->login.'</p>
                        <p>'.$model->date.'</p>
                    </div>';
                
            }
            ?>
        </div>
        <?php 
            echo LinkPager::widget([
                'linkContainerOptions' => ['class' => 'pagination'],
                'linkOptions' => ['class' => 'page-link'],
                'options' => ['class' => 'pagination justify-content-center'], // Пример добавления стилей с использованием Bootstrap классов
                'pagination' => $dataProvider->pagination,
                'prevPageLabel' => false,
                'nextPageLabel' => false, 
            ]);
        ?>

    </div>
</div>
