<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Проверка почты';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div style="margin: 0 auto; max-width: 600px; text-align: center;">
        <img class="mb-4" src="../assets/atf.png" alt="" width="72" height="72">

        <h1><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin(['id' => 'password-reset-request-form']); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>


        <!-- // if (implode($this->params['breadcrumbs']) == "Проверка почты"){
        //     echo implode($this->params['breadcrumbs']);
        // }
        ?> -->

        
    </div>
    <!-- <div class="offset-lg-1" style="color:#999;">
        You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
        To modify the username/password, please check out the code <code>app\models\User::$users</code>.
    </div> -->

