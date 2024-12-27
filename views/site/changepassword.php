<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Изменение пароля';

?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(['id' => 'change-password-form']); ?>

<?= $form->field($model, 'newPassword')->passwordInput() ?>
<?= $form->field($model, 'confirmNewPassword')->passwordInput() ?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'change-password-button']) ?>
</div>

<?php ActiveForm::end(); ?>