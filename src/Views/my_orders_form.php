<div class="container">
    <h1>Мои заказы</h1>
    <hr>

    <?php if (empty($newUserOrders)): ?>
        <p>У вас пока нет оформленных заказов.</p>
        <a href="/catalog" class="orderbtn" style="display: block; text-decoration: none;">Перейти к покупкам</a>
    <?php else: ?>
        <?php
        $currentOrderId = null;
        foreach ($newUserOrders as $order):
            ?>
            <?php if ($currentOrderId !== $order->getOrderId()): ?>
            <!-- Заголовок заказа (выводится один раз для всех товаров одного заказа) -->
            <?php if ($currentOrderId !== null) echo '</ul></div></div><hr>'; ?>

            <div class="order-card">
            <div class="order-header">
                <strong>Заказ №<?php echo $order->getOrderId(); ?></strong>
            </div>
            <div class="order-details">
            <p><b>Получатель:</b> <?php echo $order->getContactName(); ?></p>
            <p><b>Телефон:</b> <?php echo $order->getContactPhone(); ?></p>
            <p><b>Адрес:</b> <?php echo $order->getAddress(); ?></p>

            <?php if ($order->getComment()): ?>
                <p><b>Комментарий:</b> <?php echo $order->getComment(); ?></p>
            <?php endif; ?>

            <p><b>Товары:</b></p>
            <ul>
            <?php $currentOrderId = $order->getOrderId(); ?>
        <?php endif; ?>

            <?php foreach ($order->getProducts() as $product): ?>
            <li>
                <?php echo $product->getProductName(); ?> —
                <?php echo $product->getAmount(); ?> шт.
                (по <?php echo $product->getPrice(); ?> руб.)
            </li>
        <?php endforeach; ?>

        <?php endforeach; ?>
        </ul>
        </div></div><hr>
    <?php endif; ?>

    <div style="margin-top: 15px; text-align: center;">
        <a href="/profile" class="back-link">← Вернуться в личный кабинет</a>
    </div>
</div>

<style>
    * {box-sizing: border-box}

    .container {
        padding: 16px;
        max-width: 800px;
        margin: 0 auto;
    }

    .order-card {
        background: #f1f1f1;
        padding: 20px;
        margin-bottom: 10px;
        border-left: 5px solid #04AA6D;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 1.1em;
    }

    .order-date {
        color: #666;
    }

    .order-details p {
        margin: 8px 0;
    }

    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    .orderbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        text-align: center;
    }

    a {
        color: dodgerblue;
        text-decoration: none;
    }
</style>