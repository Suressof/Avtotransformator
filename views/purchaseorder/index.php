<?php

use app\models\Purchaseorder;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PurchaseorderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Purchaseorders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchaseorder-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p> -->
        <!-- <?= Html::a('Create Purchaseorder', ['create'], ['class' => 'btn btn-success']) ?> -->
    <!-- </p> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            // 'id_order',
            [
                'attribute' => 'id_order',
                'value' => function($key) {
                    return $key->getUser()->login;
                },
            ],
            [
                'attribute' => 'address',
                'value' => function($key) {
                    return $key->getUser()->address;
                },
            ],
            // 'id_product',
            [
                'attribute' => 'id_product',
                'value' => function($key) {
                    return $key->getProducts();
                },
            ],
            'date',
            'status',
            [
                'class' => ActionColumn::className(),
                'template'=>'{solve} <br> {cancel}',
                'buttons'=>[
                    'cancel'=>function ($url, $model) 
                    {
                        if ($model->status=='Не доставлен')
                        {
                            return Html::a('Не доставлен', ['/purchaseorder/cancel', 'id'=>$model->id]);
                        }
                    },
                    'solve'=>function ($url, $model) 
                    {
                        if($model->status=='Не доставлен')
                        {
                            return Html::a('Доставлен', ['/purchaseorder/solve', 'id'=>$model->id]);
                        }
                    },
                ],
                'urlCreator' => function ($action, Purchaseorder $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
