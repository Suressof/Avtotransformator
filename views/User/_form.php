<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form d-flex justify-content-center">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

    
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'passwordConfirm')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'agree')->checkbox() ?>

    <div class="form-group text-center">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
