<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */



$this->title = 'Регистрация';
if(Yii::$app->user->isGuest){
    $this->params['breadcrumbs'][] = $this->title;

}
else {
    $this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
}
?>
<div class="user-create">

    <h1 class="text-center mb-5"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
