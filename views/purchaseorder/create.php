<?php 
use yii\helpers\Html; 
use yii\widgets\ActiveForm; 
 
/** @var yii\web\View $this */ 
/** @var app\models\Purchaseorder $model */ 
 
$this->title = 'Create Purchaseorder'; 
$this->params['breadcrumbs'][] = ['label' => 'Purchaseorders', 'url' => ['index']]; 
$this->params['breadcrumbs'][] = $this->title; 
 
$cartItems = Yii::$app->session->get('cart', []); 
$form = ActiveForm::begin(); 
foreach ($cartItems as $productId): 
?> 
 
<div class="purchaseorder-create"> 
    <h1><?= Html::encode($this->title) ?></h1> 
    <div class="purchaseorder-form"> 
 
        <?= $form->field($model, 'id_order')->textInput() ?> 
        <?= $form->field($model, 'id_product')->textInput(['value' => $productId]) ?> 
        <?= $form->field($model, 'date')->textInput(['value' => \Yii::$app->formatter->asDateTime('now + 1 hour', 'php:H:i d.m.Y')]) ?> 
        <?= $form->field($model, 'status')->textInput(['value' => 'Не доставлен']) ?> 
 
    </div> 
</div> 

<?php endforeach; ?>  

<div class="form-group"> 
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?> 
</div> 

<?php ActiveForm::end(); ?>