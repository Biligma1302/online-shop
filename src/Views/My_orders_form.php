<div class="container">
    <h1>Мои заказы</h1>
    <hr>

    <?php if (empty($newUserOrders)): ?>
        <p>У вас пока нет оформленных заказов.</p>
        <a href="/catalog" class="orderbtn" style="text-align: center; display: block; text-decoration: none;">Перейти к покупкам</a>
    <?php else: ?>
        <?php foreach ($newUserOrders as $order): ?>
            <div class="order-card">
                <div class="order-header">
                    <strong>Заказ №<?php echo $order['id']; ?></strong>
                </div>

                <div class="order-details">
                    <p><b>Получатель:</b> <?php echo $order['contact_name']; ?></p>
                    <p><b>Телефон:</b> <?php echo $order['contact_phone']; ?></p>
                    <p><b>Адрес:</b> <?php echo $order['address']; ?></p>

                    <?php if (!empty($order['comment'])): ?>
                        <p><b>Комментарий:</b> <?php echo $order['comment']; ?></p>
                    <?php endif; ?>

                    <p><b>Товары:</b></p>
                    <ul>
                        <?php foreach ($order['products'] as $amount): ?>
                            <li>

                                <?php echo $amount['name']; ?> —
                                <?php echo $amount['amount']; ?> шт.
                                (по <?php echo $amount['price']; ?> руб.)
                            </li>
                        <?php endforeach; ?>
                    </ul>


                    <p style="margin-top: 10px; font-size: 1.1em;">
                        <strong>Итоговая сумма: <?php echo $order['total']; ?> руб.</strong>
                    </p>
                </div>
            </div>
            <hr>
        <?php endforeach; ?>
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