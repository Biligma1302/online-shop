<header class="main-header">
    <nav class="nav-container">
        <div class="nav-left">
            <a href="/catalog" class="nav-link">← В каталог</a>
        </div>
        <div class="nav-right">
            <a href="../profile" class="nav-link">Профиль</a>
            <a href="/create-order" class="btn-checkout">Оформить заказ</a>
        </div>
    </nav>
</header>

<div class="container">
    <h1 class="page-title">Ваша корзина</h1>

    <div class="card-grid">
        <?php if (empty($userProducts)): ?>
            <p class="empty-cart">В корзине пока пусто :(</p>
        <?php else: ?>
            <?php foreach ($userProducts as $item): ?>
                <div class="card" data-price="<?= $item['price'] ?>">
                    <div class="card-img-wrapper">
                        <img class="card-img-top" src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
                    </div>

                    <div class="card-body">
                        <h3 class="card-title"><?= $item['name'] ?></h3>
                        <div class="card-info">
                            <span class="info-label">Цена:</span>
                            <span class="info-value"><?= number_format($item['price'], 0, '.', ' ') ?> ₽</span>
                        </div>

                        <div class="controls-wrapper" style="display: flex; align-items: center; gap: 10px; margin: 10px 0;">
                            <form class="ajax-form" action="/decreaseProduct" method="POST" style="margin: 0;">
                                <input type="hidden" name="product_id" value="<?= $item['productId'] ?>">
                                <button type="submit" class="btn-qty-mini">-</button>
                            </form>

                            <span class="info-value amount-badge"><?= $item['amount'] ?> шт.</span>

                            <form class="ajax-form" action="/addProduct" method="POST" style="margin: 0;">
                                <input type="hidden" name="product_id" value="<?= $item['productId'] ?>">
                                <button type="submit" class="btn-qty-mini">+</button>
                            </form>
                        </div>
                    </div>

                    <div class="card-footer">
                        <span class="total-label">Сумма:</span>
                        <span class="total-price js-item-total"><?= number_format($item['price'] * $item['amount'], 0, '.', ' ') ?> ₽</span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if (!empty($userProducts)): ?>
        <div class="cart-total-footer" style="margin-top: 40px; padding: 20px; border-top: 2px solid #eee; text-align: right;">
            <div style="font-size: 1.2rem; color: #666; margin-bottom: 5px;">Общая стоимость:</div>
            <div class="js-cart-total"  style="font-size: 2rem; font-weight: bold; color: #333;"><?= number_format($totalSum, 0, '.', ' ') ?> ₽</div>
        </div>
    <?php endif; ?>
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
                    badge.text(response.newAmount + ' шт.');
                },
                error: function (xhr) {
                    if (xhr.status === 401) { window.location.href = '/login'; }
                    else { console.error("Ошибка:", xhr.responseText); }
                }
            });
        });
    });
</script>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f0f2f5;
        margin: 0;
        color: #333;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .page-title {
        text-align: center;
        margin-bottom: 40px;
        font-size: 2.5rem;
        color: #1a1a1a;
    }

    .main-header {
        background: #fff;
        padding: 15px 0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px;
    }

    .nav-link {
        text-decoration: none;
        color: #555;
        margin-left: 20px;
        font-weight: 500;
        transition: color 0.3s;
    }

    .nav-link:hover { color: #007bff; }
    .nav-link.active { color: #007bff; border-bottom: 2px solid #007bff; }

    .btn-checkout {
        background: #28a745;
        color: white;
        padding: 10px 25px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.3s;
    }

    .btn-checkout:hover { background: #218838; }

    .card-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
    }

    .card {
        background: #fff;
        width: 280px;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        overflow: hidden;
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .card:hover { transform: translateY(-10px); }

    .card-img-wrapper {
        height: 200px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
    }

    .card-img-top {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }

    .card-body {
        padding: 20px;
        flex-grow: 1;
    }

    .card-title {
        font-size: 1.1rem;
        margin: 0 0 15px 0;
        height: 2.4em;
        overflow: hidden;
        line-height: 1.2;
    }

    .card-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .info-label { color: #888; }
    .info-value { font-weight: 600; }

    .card-footer {
        padding: 15px 20px;
        background: #f8f9fa;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .total-label { font-size: 0.8rem; color: #666; }
    .total-price { font-size: 1.2rem; font-weight: bold; color: #007bff; }

    .empty-cart { font-size: 1.2rem; color: #999; margin-top: 50px; }

    .btn-qty-mini {
        background: #f0f2f5;
        border: none;
        padding: 5px 12px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: background 0.2s;
    }
    .btn-qty-mini:hover { background: #e4e6eb; }
</style>