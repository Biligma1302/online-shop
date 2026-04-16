<div class="main-container">
    <div class="review-card">
        <?php if (isset($product) && $product): ?>
            <div class="selected-product" style="display: flex; align-items: center; gap: 20px; padding: 15px; background: #f8f9fa; border-radius: 12px; margin-bottom: 25px; border: 1px solid #eee;">
                <img src="<?= $product->getImageUrl() ?>" alt="" style="width: 80px; height: 80px; object-fit: contain; background: white; border-radius: 8px;">
                <div>
                    <h3 style="margin: 0; font-size: 18px; color: #333;"><?= $product->getName() ?></h3>
                    <p style="margin: 5px 0 0; font-size: 14px; color: #777;"><?= $product->getDescription() ?></p>
                </div>
            </div>
        <?php endif; ?>

        <h2 class="review-title">Оставить отзыв</h2>
        <form action="/reviews-post" method="POST">
            <input type="hidden" name="product_id" value="<?= $product->getId(); ?>">

            <div class="rating-group">
                <span class="rating-label">Ваша оценка</span>
                <div class="star-rating">
                    <input type="radio" id="star5" name="rating" value="5"><label for="star5">★</label>
                    <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                    <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                    <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                    <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
                </div>
            </div>

            <div class="comment-group">
                <label class="comment-label" for="comment">Ваш комментарий</label>
                <textarea id="comment" name="comment" class="comment-input" placeholder="Поделитесь впечатлениями о покупке..."></textarea>
            </div>

            <button type="submit" class="submit-button">Опубликовать</button>
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <a href="/catalog" class="back-button" style="text-decoration: none; padding: 10px 20px; background: #6c757d; color: white; border-radius: 8px; font-size: 14px; text-align: center;">
                    Назад в каталог
                </a>
            </div>
        </form>


        <div class="reviews-list" style="margin-top: 40px; border-top: 1px solid #eee; padding-top: 20px;">
            <h3 style="margin-bottom: 20px;">Отзывы покупателей</h3>
            <?php if (!empty($reviewsList)): ?>
                <?php foreach ($reviewsList as $review): ?>
                    <div style="background: #fdfdfd; border: 1px solid #f0f0f0; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                        <div style="color: #f39c12; font-weight: bold; margin-bottom: 5px;">
                            Оценка: <?= $review->getRating() ?> ★
                            <span style="color: #999; font-size: 0.8em;">
                 <?= date('d.m.Y H:i', strtotime($review->getCreatedAt())) ?>
            </span>
                        </div>
                        <p style="margin: 0; color: #444;"><?=($review->getComment()) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: #999;">Отзывов пока нет. Будьте первым!</p>
            <?php endif; ?>
        </div>


    </div>
</div>
<style>

    body, html {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        background-color: #f5f5f7; /* Серый фон как у Apple */
    }

    .main-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
    }

    /* Сама карточка */
    .review-card {
        width: 100%;
        max-width: 500px;
        background: #ffffff;
        padding: 40px;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    .review-title {
        font-size: 32px;
        font-weight: 700;
        color: #1d1d1f;
        text-align: center;
        margin-top: 0;
        margin-bottom: 30px;
    }

    .rating-label, .comment-label {
        display: block;
        font-size: 18px;
        font-weight: 600;
        color: #1d1d1f;
        margin-bottom: 15px;
    }

    /* Стилизация звезд */
    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
        margin-bottom: 30px;
    }

    .star-rating input {
        display: none; /* Прячем страшные кружочки-радиокнопки */
    }

    .star-rating label {
        font-size: 50px; /* Крупные звезды */
        color: #d2d2d7;
        cursor: pointer;
        transition: color 0.2s ease-in-out;
        padding: 0 5px;
    }

    /* Эффект при наведении и выборе */
    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input:checked ~ label {
        color: #ff9500;
    }

    /* Поле ввода комментария */
    .comment-group {
        margin-bottom: 25px;
    }

    .comment-input {
        width: 100%;
        min-height: 160px;
        padding: 16px;
        border: 1px solid #d2d2d7;
        border-radius: 16px;
        font-size: 17px;
        font-family: inherit;
        line-height: 1.5;
        box-sizing: border-box; /* Чтобы паддинги не расширяли поле */
        resize: none; /* Убираем ручное изменение размера */
    }

    .comment-input:focus {
        outline: none;
        border-color: #0071e3;
        box-shadow: 0 0 0 4px rgba(0, 113, 227, 0.1);
    }

    /* Кнопка */
    .submit-button {
        width: 100%;
        padding: 18px;
        background-color: #0071e3;
        color: #ffffff;
        border: none;
        border-radius: 16px;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .submit-button:hover {
        background-color: #0077ed;
        transform: translateY(-1px);
    }

    .submit-button:active {
        transform: translateY(0);
    }
</style>