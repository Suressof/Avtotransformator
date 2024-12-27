<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'generator', 'content' => 'Hugo 0.118.2']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/assets/atf.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
    <script src="../assets/color-modes.js"></script>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <script src="../assets/jquery-1.11.1.min.js"></script>
    <link href="../assets/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/bootstrap.min.js" rel="stylesheet">
    
    <!-- <link href="../css/site.css" rel="stylesheet"> -->
    <script src="../assets/okzoom.js"></script>
    <script>
        jQuery(document).ready(function($) {
            $(function(){
                $('#example').okzoom({
                width: 200,
                height: 200,
                border: "1px solid black",
                shadow: "0 0 5px #000"
                });
            });
        });
    </script>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    $array = array('L','o','g','i','n');
    $string = implode($array);

    function theme() {
        return '<svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                    <symbol id="check2" viewBox="0 0 16 16">
                    <path  d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                    </symbol>
                    <symbol id="circle-half" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                    </symbol>
                    <symbol id="moon-stars-fill" viewBox="0 0 16 16">
                    <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
                    <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/>
                    </symbol>
                    <symbol id="sun-fill" viewBox="0 0 16 16">
                    <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
                    </symbol>
                </svg>
            <div class="dropdown bd-mode-toggle ms-3">
                <button style="fill: white;" class="btn rounded-pill bg-secondary bg-gradient py-2 dropdown-toggle d-flex align-items-center"
                        id="bd-theme"
                        type="button"
                        aria-expanded="false"
                        data-bs-toggle="dropdown"
                        aria-label="Toggle theme (auto)">
                <svg style="fill: white;" class="my-1 theme-icon-active" width="1em" height="1em"><use href="#circle-half"></use></svg>
                <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                    <svg class="me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#sun-fill"></use></svg>
                    Light
                    <svg  class="ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
                    </button>
                </li>
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                    <svg class="me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>
                    Dark
                    <svg class="ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
                    </button>
                </li>
                
                </ul>
            </div>
            <script src="../assets/bootstrap.bundle.min.js"></script>';
    }

    try {
        if (implode($this->params['breadcrumbs']) == $string || implode($this->params['breadcrumbs']) == "Проверка почты" || implode($this->params['breadcrumbs']) == "Регистрация"){

        } else {
            NavBar::begin([
                // 'brandLabel' => "Avtotransformator",
                // 'brandUrl' => Yii::$app->homeUrl,
                'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top'],
            ]);
            $items = [];
            $items[] = [
            'label' => '<img src=" ' . Yii::getAlias('@web/assets/atf.png') . '" width="30" height="" class="d-inline-block align-text-top"> Avtotransformator',
            'url' => Yii::$app->homeUrl,
            'encode' => false,
            'linkOptions' => ['class' => 'navbar-brand']];
            
            $items[] = ['label' => 'Товары', 'url' => ['/product']];
            $items[] = ['label' => 'Категории', 'url' => ['/category']];
            
            if(Yii::$app->user->isGuest){
                $items[] = '</ul><div class="d-flex">' . Html::beginForm(['/user/create']). Html::submitButton('Регистрация', ['class' => 'btn btn-dark']) . Html::endForm() . '</div>';
                $items[] = '</ul><div class="d-flex">' . Html::beginForm(['/site/login']). Html::submitButton('Авторизация',['class' => 'btn btn-dark ms-3']) . Html::endForm() . '</div>';
                
                $items[] = theme();
            }
            else {
                if(Yii::$app->user->identity->status == 1) {
                    $items[] = ['label' => 'Административная панель', 'url' => ['/admin']];
                }
                else {
                    $items[] = ['label' => 'Личный кабинет', 'url' => ['/lk']];
                    $items[] = '</ul><button type="button" class="btn btn-outline-primary me-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <img src="../assets/cart.png" alt="">
                                    <span class="badge text-bg-primary rounded-pill align-text-bottom">' . count(Yii::$app->session->get('cart', [])) . '</span>
                                </button>';
                }
                $items[] = '</ul><div class="d-flex">'
                            . Html::beginForm(['/site/logout'])
                            . Html::submitButton(
                                'Выход (' . Yii::$app->user->identity->login . ')',
                                ['class' => 'btn btn-outline-danger']
                            )
                            . Html::endForm()
                            . '</div>';  
                $items[] = theme();
            }

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav me-auto mb-2 mb-lg-0'],
                'items' => $items,
                // 'items' => [
                //     ['label' => 'Home', 'url' => ['/site/index']],
                //     ['label' => 'Регистрация', 'url' => ['/user/create']],
                //     ['label' => 'Contact', 'url' => ['/site/contact']],
                //     ['label' => 'About', 'url' => ['/site/about']],
                //     Yii::$app->user->isGuest
                //         ? ['label' => 'Login', 'url' => ['/site/login']]
                //         : '<li class="nav-item">'
                //             . Html::beginForm(['/site/logout'])
                //             . Html::submitButton(
                //                 'Logout (' . Yii::$app->user->identity->login . ')',
                //                 ['class' => 'nav-link btn btn-link logout']
                //             )
                //             . Html::endForm()
                //             . '</li>'
                // ]
            ]);
            // echo '      <form class="d-flex">
            //     <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            //     <button class="btn btn-outline-success" type="submit">Search</button>
            //   </form>';
            NavBar::end();
        }
    }
    catch (\Throwable $th) {
        NavBar::begin([
            'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top'],
        ]);
        $items = [];
        $items[] = [
        'label' => '<img src=" ' . Yii::getAlias('@web/assets/atf.png') . '" width="30" height="" class="d-inline-block align-text-top"> Avtotransformator',
        'url' => Yii::$app->homeUrl,
        'encode' => false,
        'linkOptions' => ['class' => 'navbar-brand']];

        $items[] = ['label' => 'Товары', 'url' => ['/product']];
        $items[] = ['label' => 'Категории', 'url' => ['/category']];
        
        if(Yii::$app->user->isGuest){
            $items[] = '</ul><div class="d-flex">' . Html::beginForm(['/user/create']). Html::submitButton('Регистрация', ['class' => 'btn btn-dark']) . Html::endForm() . '</div>';
            $items[] = '</ul><div class="d-flex">' . Html::beginForm(['/site/login']). Html::submitButton('Авторизация',['class' => 'btn btn-dark ms-3']) . Html::endForm() . '</div>';
            
            $items[] = theme();
        }
        else {
            if(Yii::$app->user->identity->status == 1) {
                $items[] = ['label' => 'Административная панель', 'url' => ['/admin']];
            }
            else {
                $items[] = ['label' => 'Личный кабинет', 'url' => ['/lk']];
                $items[] = '</ul><button type="button" class="btn btn-outline-primary me-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <img src="../assets/cart.png" alt="">
                                <span class="badge text-bg-primary rounded-pill align-text-bottom">' . count(Yii::$app->session->get('cart', [])) . '</span>
                            </button>';
            }
            $items[] = '</ul><div class="d-flex">'
                        . Html::beginForm(['/site/logout'])
                        . Html::submitButton(
                            'Выход (' . Yii::$app->user->identity->login . ')',
                            ['class' => 'btn btn-outline-danger']
                        )
                        . Html::endForm()
                        . '</div>';  
                        $items[] = theme();
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav me-auto mb-2 mb-lg-0'],
            'items' => $items,
        ]);
        NavBar::end();
    }

    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])){ 
            try {
                if (implode($this->params['breadcrumbs']) == $string || implode($this->params['breadcrumbs']) == "Проверка почты" || implode($this->params['breadcrumbs']) == "Регистрация"){
                    
                }
                else {
                    ?><?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]); ?><?php 
                }
            } catch (\Throwable $th) {
                //throw $th;
                ?><?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]); ?><?php
            }
            ?>
        <?php } ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>
<script src="../assets/bootstrap.bundle.min.js"></script>
    <footer id="footer" class="mt-auto py-3">
        <div class="container">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">&copy; Avtotransformator <?= date('Y') ?></div>
                <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
            </div>
        </div>
    </footer>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
