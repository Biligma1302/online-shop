<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог товаров</title>

    <link href="https://googleapis.com" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="main-header">
    <nav class="nav-container">

        <a href="/profile" class="nav-link profile-link">
            🏠 👤 Личный кабинет (<?= htmlspecialchars($_SESSION['user_name'] ?? 'Гость') ?>)
        </a>
        </a>
        <a href="../cart" class="nav-link">🛒 Корзина (<?= number_format($totalSum ?? 0, 0, '.', ' ') ?> ₽)</a>
    </nav>
</header>

<div class="container">
    <h3>Catalog</h3>
    <div class="card-deck">
        <?php foreach ($products as $product): ?>
            <?php $productId = $product->getId(); ?>
            <div class="card text-center">
                <div class="card-header">Hit!</div>

                <img class="card-img-top" src="<?= htmlspecialchars($product->getImageUrl()); ?>" alt="<?= htmlspecialchars($product->getName()); ?>">

                <div class="card-body">
                    <p class="card-text text-muted"><?= htmlspecialchars($product->getName()); ?></p>
                    <h5 class="card-title"><?= htmlspecialchars($product->getDescription()); ?></h5>

                    <div class="controls-wrapper">
                        <form action="/add-product" method="POST" style="display:inline;">
                            <input type="hidden" name="product_id" value="<?= $productId; ?>">
                            <button type="submit" class="registerbtn">+</button>
                        </form>

                        <span class="amount-badge">
                            <?= isset($user_products[$productId]) ? (int)$user_products[$productId]->getAmount() : 0; ?>
                        </span>

                        <form action="/decrease-product" method="POST" style="display:inline;">
                            <input type="hidden" name="product_id" value="<?= $productId; ?>">
                            <button type="submit" class="registerbtn">-</button>
                        </form>
                    </div>


                    <div style="margin-top: 15px;">
                        <a href="/reviews?product_id=<?= $productId; ?>" class="btn-open" style="display: block; text-decoration: none; text-align: center; width: 100%;">
                            Открыть отзывы
                        </a>
                    </div>
                </div>

                <div class="card-footer signin">
                    <p>Already have an account? <a href="#">Sign in</a>.</p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
<style>

    body {
        font-family: 'Roboto', sans-serif;
        font-size: 16px;
        display: flex;
        justify-content: center;
        background-color: #f5f5f5;
        margin: 0;
        padding: 20px;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    a:hover {
        text-decoration: underline;
    }

    h3 {
        line-height: 3em;
        font-size: 1.5em;
        font-weight: bold;
        margin-bottom: 20px;
    }

    /* Шапка */
    .main-header {
        width: 100%;
        background: white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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
        font-size: 1.1rem;
        font-weight: 500;
    }

    .profile-link {
        background: #f0f0f0;
        padding: 8px 15px;
        border-radius: 20px;
    }

    /* Основной контейнер */
    .container {
        max-width: 1200px;
        width: 100%;
        margin: 80px auto 0;
        padding: 0 20px;
    }

    /* Сетка карточек - 4 штуки в ряд */
    .card-deck {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        margin-top: 20px;
    }

    /* Карточка товара */
    .card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,.1);
        overflow: hidden;
        transition: transform 0.2s ease-in-out;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .card-header {
        font-size: 13px;
        color: darkgrey;
        background-color: transparent;
        padding: 10px;
        text-align: center;
        font-weight: bold;
    }

    .card-img-top {
        object-fit: cover;
        height: 180px;
        width: 100%;
        background: #f5f5f5;
    }

    .card-body {
        flex-grow: 1;
        padding: 15px;
        display: flex;
        flex-direction: column;
    }

    .card-text.text-muted {
        font-size: 14px;
        margin-bottom: 10px;
        color: #666;
    }

    .card-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }

    /* Форма */
    .card-body form {
        margin-top: auto;
    }

    .card-body form .container {
        margin: 0;
        padding: 0;
        max-width: 100%;
    }

    label b {
        display: block;
        margin-bottom: 5px;
        font-size: 14px;
    }

    input[type="text"] {
        width: 100%;
        padding: 8px;
        margin: 5px 0 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        box-sizing: border-box;
    }

    hr {
        display: none;
    }

    .registerbtn {
        width: 100%;
        background-color: #007bff;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        transition: background 0.3s;
    }

    .registerbtn:hover {
        background-color: #0056b3;
    }

    /* Подпись внизу карточки */
    .signin {
        text-align: center;
        font-size: 12px;
        padding: 10px;
        border-top: 1px solid #eee;
        margin-top: auto;
    }

    .signin a {
        color: #007bff;
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

    @media (max-width: 480px) {
        .card-deck {
            grid-template-columns: 1fr;
        }

        .container {
            padding: 0 10px;
        }
    }
</style>