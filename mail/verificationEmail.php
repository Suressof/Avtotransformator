
<div class="verification-email">
    <p>Для подтверждения вашего email перейдите по следующей ссылке:</p>
    <p><?= Yii::$app->urlManager->createAbsoluteUrl(['site/confirm-email', 'token' => $token]) ?></p>
</div>