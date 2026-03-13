
<header class="main-header">
    <nav class="nav-container">
        <a href="" class="nav-link"></a>

        <a href="../profile" class="nav-link profile-link">

            <header class="main-header">
                <nav class="nav-container">
                    <a href="" class="nav-link"></a>
                    <a href="../profile" class="nav-link profile-link"></a>
                    <a href="../cart" class="nav-link profile-link">
                        🛒 Корзина
                    </a>
                    <a href="/catalog" class="btn btn-primary mb-3">Вернуться в каталог</a>
                </nav>
            </header>

<div class="container">
    <h3></h3>
    <div class="card-deck">
        <?php foreach ($fullUserProducts as $userProduct): ?>
            <div class="card text-center">
                <div class="card-header">
                    Hit!
                </div>
                <img class="card-img-top" src=<?php echo $userProduct ['image_url'];?> alt="Card image">
                <div class="card-body">
                    <p class="card-text text-muted"><?php echo $userProduct['name'];?></p>
                    <a href="#"><h5 class="card-title"><?php echo $userProduct['description'];?></h5></a>

                    <p><strong>Price:</strong> <?php echo $userProduct['price']; ?></p>

                    <form action="/add-product" method="POST" style="margin-top: 10px;">
                        <input type="hidden" name="product_id" value="<?php echo $userProduct['id']; ?>">

                        <div class="container">
                            <label for="amount"><b>Amount</b></label>

                            <input type="text" placeholder="Enter Amount" name="amount" id="amount" required>
                            <hr>
                            <button type="submit" class="registerbtn">Add product</button>
                        </div>
                </div>
                <div class="container signin">
                    <p>Already have an account? <a href="#">Sign in</a>.</p>
                </div>
                </form>
            </div>

        <?php endforeach; ?>


        <style>
            body {
                font-family: 'Roboto', sans-serif; /* Используем красивый шрифт Roboto */
                font-size: 16px;
                display: flex;
                justify-content: center; /* Центрирование по горизонтали */
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
            }

            /* Карточка товара */
            .card {
                max-width: 20rem;
                /* Убираем фиксированную высоту, оставляем минимально необходимую */
                min-height: 400px; /* минимальная высота карточки */
                border-radius: 10px; /* закруглённые углы */
                box-shadow: 0 4px 8px rgba(0,0,0,.1); /* лёгкая тень */
                overflow: hidden; /* прячем выступающие части */
                transition: transform 0.2s ease-in-out; /* плавный эффект увеличения */
            }

            .card:hover {
                transform: scale(1.05); /* легкое увеличение при наведении */
            }

            .card-header {
                font-size: 13px;
                color: #666;
                background-color: transparent;
                padding: 10px;
            }

            .card-img-top {
                object-fit: cover; /* сохраняет пропорции изображения */
                height: 150px; /* фиксированная высота изображения */
                width: 100%;
            }

            .card-body {
                flex-grow: 1;
                padding: 10px;
                display: flex;
                flex-direction: column;
                justify-content: space-between; /* равномерное распределение элементов */
            }

            .card-text.text-muted {
                font-size: 14px;
                margin-bottom: 10px;
            }

            .card-title {
                font-size: 16px;
                font-weight: bold;
                margin-bottom: 10px;
            }

            .card-footer {
                font-weight: bold;
                font-size: 18px;
                background-color: white;
                padding: 10px;
                border-top: 1px solid #ddd;
            }

            /* Добавим немного оформления форме */
            .form-container {
                display: block;
                margin-top: 10px;
            }

            .form-group {
                margin-bottom: 10px;
            }

            .registerbtn {
                background-color: #007BFF;
                color: white;
                padding: 10px 20px;
                border: none;
                cursor: pointer;
                border-radius: 5px;
                font-size: 16px;
                transition: background-color 0.3s ease;
            }

            .registerbtn:hover {
                background-color: #0056b3;
            }
        </style>
