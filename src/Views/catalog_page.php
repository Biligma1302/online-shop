<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог товаров</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>

<header class="main-header">
    <nav class="nav-container">
        <a href="/profile" class="nav-link profile-link">
            🏠 👤 Личный кабинет (<?= $_SESSION['user_name'] ?? 'Гость' ?>)
        </a>
        <a href="../cart" class="nav-link">🛒 Корзина (<span class="cart-total-sum"><?= number_format($totalSum ?? 0, 0, '.', ' ') ?></span> ₽)</a>
    </nav>

</header>

<div class="container">
    <h3>Catalog</h3>
    <div class="card-deck">
        <?php
        foreach ($products as $product): ?>
            <?php
            $productId = $product->getId(); ?>
            <div class="card text-center">


                <img class="card-img-top" src="<?= htmlspecialchars($product->getImageUrl()); ?>"
                     alt="<?= htmlspecialchars($product->getName()); ?>">

                <div class="card-body">
                    <p class="card-text text-muted"><?= htmlspecialchars($product->getName()); ?></p>
                    <h5 class="card-title"><?= htmlspecialchars($product->getDescription()); ?></h5>

                    <div class="controls-wrapper">

                        <form class="ajax-form" action="/add-product" method="POST">
                            <input type="hidden" name="product_id" value="<?= $productId; ?>">
                            <button type="submit" class="registerbtn btn-plus">+</button>
                        </form>

                        <span class="amount-badge">
        <?= isset($user_products[$productId]) ? (int)$user_products[$productId]->getAmount() : 0; ?>
    </span>
                        <form class="ajax-form" action="/decrease-product" method="POST">
                            <input type="hidden" name="product_id" value="<?= $productId; ?>">
                            <button type="submit" class="registerbtn btn-minus">-</button>
                        </form>
                    </div>

                    <div style="margin-top: 15px;">
                        <a href="/reviews?product_id=<?= $productId; ?>" class="btn-open">
                            💬 Открыть отзывы
                        </a>
                    </div>
                </div>

            </div>
        <?php
        endforeach; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
        $('.ajax-form').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                dataType: 'json',
                success: function (response) {
                    var badge = form.closest('.controls-wrapper').find('.amount-badge');
                    badge.text(response.newAmount);
                 //   $('.cart-total-sum').text(response.totalSum);
                },
                error: function (xhr) {
                    if (xhr.status === 401) { window.location.href = '/login'; }
                    else { console.error("Ошибка:", xhr.responseText); }
                }
            });
        });
    });
</script>
</body>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        font-size: 16px;
        background-color: #f4f6f9;
        margin: 0;
        padding: 20px;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    h3 {
        font-size: 1.8em;
        font-weight: 700;
        margin-bottom: 25px;
        color: #212529;
    }

    /* Шапка */
    .main-header {
        width: 100%;
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 100;
    }

    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .nav-link {
        font-size: 1rem;
        font-weight: 500;
        transition: color 0.2s;
    }

    .profile-link {
        background: #f1f3f5;
        padding: 8px 16px;
        border-radius: 30px;
    }

    .profile-link:hover {
        background: #e9ecef;
    }

    /* Контейнер каталога */
    .container {
        max-width: 1200px;
        width: 100%;
        margin: 90px auto 0;
        padding: 0 20px;
        box-sizing: border-box;
    }

    /* Сетка */
    .card-deck {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
    }

    /* Карточка */
    .card {
        background: white;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        border: 1px solid #eef2f5;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .card-img-top {
        object-fit: cover;
        height: 200px;
        width: 100%;
        background: #f8f9fa;
        border-radius: 14px 14px 0 0;
    }

    .card-body {
        flex-grow: 1;
        padding: 20px;
        display: flex;
        flex-direction: column;
    }

    .card-text.text-muted {
        font-size: 14px;
        margin: 0 0 8px 0;
        color: #6c757d;
    }

    .card-title {
        font-size: 16px;
        font-weight: 600;
        margin: 0 0 20px 0;
        color: #212529;
        line-height: 1.4;
    }

    .controls-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        margin-top: auto;
        padding-bottom: 18px;
    }

    /* Общие стили круглых кнопок */
    .registerbtn {
        width: 42px;
        height: 42px;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        font-size: 22px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-minus:hover {
        background-color: #e01b22 !important;
        transform: scale(1.08);
        box-shadow: 0 6px 14px rgba(255, 77, 79, 0.4);
    }


    .btn-plus:hover {
        background-color: #006ddb !important;
        transform: scale(1.08);
        box-shadow: 0 6px 14px rgba(24, 144, 255, 0.4);
    }

    .amount-badge {
        font-size: 18px;
        font-weight: 700;
        color: #212529;
        min-width: 24px;
        text-align: center;
    }

    /* Кнопка "Открыть отзывы" — Фиолетовый индиго */
    .btn-open {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        box-sizing: border-box;
        background-color: #6366f1;
        color: #ffffff;
        padding: 12px 15px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
        text-decoration: none;
    }

    .btn-open:hover {
        background-color: #4f46e5;
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(99, 102, 241, 0.35);
    }

    .btn-open:active {
        transform: translateY(1px);
    }

    /* Адаптивность */
    @media (max-width: 1024px) {
        .card-deck {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .card-deck {
            grid-template-columns: repeat(2, 1fr);
        }

        .nav-container {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>
</html>