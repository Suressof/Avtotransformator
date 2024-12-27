<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Comments $model */

$this->title = 'Create Comments';
if(Yii::$app->user->identity->status == 1) {
    $this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <?= $this->render('_form', [
        'model' => $model,
    ]) ?> -->

    <div class="comments-form">

        <?php $form = ActiveForm::begin(); ?>

        <div style="display: none;">
            <?= $form->field($model, 'id_user')->textInput(['value' => Yii::$app->session->get('id_user')]) ?>
            <?= $form->field($model, 'id_product')->textInput(['value' => Yii::$app->session->get('id_product')]) ?>
            <?= $form->field($model, 'date')->textInput(['value' => Yii::$app->formatter->asDateTime('now + 1 hour', 'php:H:i d.m.Y')]) ?>
        </div>

        <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>


        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
