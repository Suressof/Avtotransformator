<?php foreach ($cartItems as $productId): ?>
    <div>
        <p>Product ID: <?= $productId ?></p>
        <a href="<?= Yii::$app->urlManager->createUrl(['cart/remove-from-cart', 'productId' => $productId]) ?>">Remove from Cart</a>
    </div>
<?php endforeach; ?>