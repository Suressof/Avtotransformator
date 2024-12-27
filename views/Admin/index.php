<?php

use app\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
/** @var yii\web\View $this */
/** @var app\models\CategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Административная панель';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Управление категориями', ['/category'], ['class' => 'btn btn-primary mb-3 me-2']) ?>
        <?= Html::a('Управление поставщиками', ['/vendor'], ['class' => 'btn btn-primary mb-3 me-2']) ?>
        <?= Html::a('Управление способами оплаты', ['/payment'], ['class' => 'btn btn-primary mb-3 me-2']) ?> <br>

        <?= Html::a('Управление новостями', ['/news'], ['class' => 'btn btn-info mb-3 me-2']) ?>
        <?= Html::a('Управление пользователями', ['/user'], ['class' => 'btn btn-info mb-3 me-2']) ?> <br>
        
        <?= Html::a('Управление товарами', ['/product'], ['class' => 'btn btn-success mb-3 me-2']) ?>
        <?= Html::a('Управление закупками товара', ['/purchaseorder'], ['class' => 'btn btn-success mb-3 me-2']) ?> <br>

        <?= Html::a('Мониторинг заказов товаров', ['/monitoringorder'], ['class' => 'btn btn-secondary  mb-3 me-2']) ?>

        <?php echo \Yii::$app->formatter->asDateTime('now + 1 hour', 'php:H:i d.m.Y'); ?>
    </p>

</div>
