<?php

use app\models\Category;
use app\models\PurchaseOrder;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
/** @var yii\web\View $this */
/** @var app\models\CategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Административная панель';
$this->params['breadcrumbs'][] = $this->title;

$weekOrdersCount = PurchaseOrder::find()
->select([
    'date as dayOfWeek',
    'COUNT(*) as orderCount'
])
->groupBy(['dayOfWeek'])
->asArray()
->all();

$weekOrdersCount1 = PurchaseOrder::find()
->select([
    'date as dayOfWeek',
    'COUNT(*) as orderCount'
])
->where(['status' => 'Доставлен'])
->groupBy(['dayOfWeek'])
->asArray()
->all();

$weekOrdersCount2 = PurchaseOrder::find()
->select([
    'date as dayOfWeek',
    'COUNT(*) as orderCount'
])
->where(['status' => 'Не доставлен'])
->groupBy(['dayOfWeek'])
->asArray()
->all();

$chartData = [];
foreach ($weekOrdersCount as $data) {
    $chartData['labels'][] = $data['dayOfWeek'];
    $chartData['data'][] = $data['orderCount'];
}

$chartData1 = [];
foreach ($weekOrdersCount1 as $data) {
    $chartData1['labels'][] = $data['dayOfWeek'];
    $chartData1['data'][] = $data['orderCount'];
}

$chartData2 = [];
foreach ($weekOrdersCount2 as $data) {
    $chartData2['labels'][] = $data['dayOfWeek'];
    $chartData2['data'][] = $data['orderCount'];
}
?>

<h2>Все заказы</h2>
<div class="container">
    <canvas id="ordersChart" ></canvas>
</div>

<h2>Заказы, которые были доставлены</h2>
<div class="container">
    <canvas id="ordersChart1" ></canvas>
</div>

<h2>Заказы, которые были не доставлены</h2>
<div class="container">
    <canvas id="ordersChart2" ></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Настройки графика
    var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    // Подготовка данных для графика
    var chartData = <?= json_encode($chartData) ?>;

    // Получение контекста canvas
    var ctx = document.getElementById('ordersChart').getContext('2d');

    // Создание графика
    var ordersChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Количество всех заказов',
                data: chartData.data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: chartOptions
    });

    // Подготовка данных для графика
    var chartData1 = <?= json_encode($chartData1) ?>;

    // Получение контекста canvas
    var ctx1 = document.getElementById('ordersChart1').getContext('2d');

    // Создание графика
    var ordersChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: chartData1.labels,
            datasets: [{
                label: 'Количество заказов, которые были доставлены',
                data: chartData1.data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: chartOptions
    });

        // Подготовка данных для графика
        var chartData2 = <?= json_encode($chartData2) ?>;

// Получение контекста canvas
var ctx2 = document.getElementById('ordersChart2').getContext('2d');

// Создание графика
var ordersChart = new Chart(ctx2, {
    type: 'line',
    data: {
        labels: chartData2.labels,
        datasets: [{
            label: 'Количество заказов, которые были не доставлены',
            data: chartData2.data,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: chartOptions
});
</script>
