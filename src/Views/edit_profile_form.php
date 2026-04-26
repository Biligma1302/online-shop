
<div class="main-container">
    <form action="/edit-profile" method="POST" class="form-example">
        <h1>Редактирование профиля</h1>
        <hr>

        <div class="form-group">
            <label for="name"><b>Имя пользователя</b></label>
            <?php if (isset($errors['name'])): ?>
                <label class="error-msg"><?php echo $errors['name']; ?></label>
            <?php endif; ?>

            <input type="text" name="name" id="name" value="<?php echo ($user->getName()); ?>" />
        </div>

        <div class="form-group">
            <label for="email"><b>Новый Email</b></label>
            <?php if (isset($errors['email'])): ?>
                <label class="error-msg"><?php echo $errors['email']; ?></label>
            <?php endif; ?>

            <input type="email" name="email" id="email" value="<?php echo ($user->getEmail()); ?>" />
        </div>

        <button type="submit" class="registerbtn">Сохранить изменения</button>

        <div class="signin">
            <p><a href="/profile">Вернуться назад</a></p>
        </div>
    </form>
</div>

<style>
    body {
        background-color: #f4f7f6;
        font-family: 'Segoe UI', sans-serif;
    }

    .main-container {
        max-width: 600px; /* Увеличил ширину */
        margin: 50px auto;
        background: white;
        padding: 40px; /* Больше внутренних отступов */
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    h1 {
        font-size: 28px;
        margin-bottom: 10px;
    }

    .form-group {
        margin-bottom: 25px; /* Больше расстояния между полями */
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-size: 18px; /* Крупный шрифт для текста */
    }

    input[type=text], input[type=email] {
        width: 100%;
        padding: 18px; /* Сделал поля выше */
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background: #f9f9f9;
    }

    input:focus {
        background-color: #fff;
        border-color: #04AA6D;
        outline: none;
    }

    .error-msg {
        color: red;
        font-size: 14px;
        display: block;
        margin-bottom: 5px;
    }

    /* Мощная кнопка */
    .registerbtn {
        background-color: #04AA6D;
        color: white;
        padding: 20px;
        font-size: 20px; /* Крупный текст на кнопке */
        font-weight: bold;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        width: 100%;
        transition: 0.3s;
    }

    .registerbtn:hover {
        background-color: #038d5a;
    }

    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 30px;
    }

    .signin {
        margin-top: 20px;
        text-align: center;
        font-size: 16px;
    }
</style>