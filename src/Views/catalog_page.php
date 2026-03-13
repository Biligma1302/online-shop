<header class="main-header">
    <nav class="nav-container">
        <a href="" class="nav-link">🏠</a>

        <a href="../profile" class="nav-link profile-link">
            👤 Личный кабинет (<?= htmlspecialchars($_SESSION['user_name']) ?>)
        </a>
        <a href="../cart" class="nav-link profile-link">
            🛒 Корзина
        </a>

    </nav>
</header>


<div class="container">
    <h3>Catalog</h3>
    <div class="card-deck">
        <?php foreach ($products as $product): ?>
            <div class="card text-center">
                    <div class="card-header">
                        Hit!
                    </div>
                    <img class="card-img-top" src=<?php echo $product ['image_url'];?> alt="Card image">
                    <div class="card-body">
                        <p class="card-text text-muted"><?php echo $product['name'];?></p>
                        <a href="#"><h5 class="card-title"><?php echo $product['description'];?></h5></a>

                        <form action="/add-product" method="POST" style="margin-top: 10px;">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

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

            .card {
                max-width: 20rem;
                height: 400px; /* Равная высота всех карточек */
                border-radius: 10px; /* Закруглим углы */
                box-shadow: 0 4px 8px rgba(0,0,0,.1); /* Тень для глубины */
                overflow: hidden; /* Скроем выступающие части */
                transition: transform 0.2s ease-in-out; /* Анимация перехода */
            }

            .card:hover {
                transform: scale(1.05); /* Легкое увеличение при наведении */
            }

            .card-header {
                font-size: 13px;
                color: darkgrey;
                background-color: transparent;
                padding: 10px;
            }

            .card-img-top {
                object-fit: cover; /* Сохранит пропорцию изображения */
                height: 150px; /* Фиксированная высота изображения */
                width: 100%;
            }

            .card-body {
                flex-grow: 1;
                padding: 10px;
                display: flex;
                flex-direction: column;
                justify-content: space-between; /* Расставляет элементы равномерно */
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
                border-top: 1px solid lightgrey;
            }
        </style>