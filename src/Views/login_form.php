<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Форма входа</title>
</head>
<body>
<div class="form-container">
    <h2>Авторизация</h2>
    <form action="/login" method="POST">
        <label for>Имя пользователя:</label>
        <?php if (isset($errors['username'])):?>
            <label style="color: red"><?php echo $errors['username']; ?></label>
        <?php endif; ?>
        <input type="text" id="username" name="username" placeholder="Email Address" required autofocus>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" placeholder="Password" required>

        <button type="submit">Войти</button>
        <a href="/registration" class="btn-register">Зарегистрироваться</a>
    </form>
</div>

<style>
    * { box-sizing: border-box; }
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #fafafa;
        font-family: 'Roboto', sans-serif;
    }
    .form-container {
        max-width: 350px;
        padding: 30px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,.1);
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #555;
    }
    input[type="text"], input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        transition: all 0.3s ease-in-out;
    }
    input[type="text"]:focus, input[type="password"]:focus {
        outline: none;
        border-color: #4caf50;
        box-shadow: 0 0 5px rgba(76,175,80,0.5);
    }
    button {
        width: 100%;
        padding: 10px;
        background-color: #4caf50;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.3s ease-in-out;
    }
    button:hover {
        background-color: #45a049;
    }
    .btn-register {
        display: inline-block;
        width: 100%; /* Растягиваем на всю ширину */
        padding: 10px;
        margin-top: 10px;
        background-color: #f0f0f0; /* Светлый фон для контраста с основной кнопкой */
        color: #333;
        text-align: center;
        text-decoration: none; /* Убираем подчеркивание ссылки */
        border-radius: 4px;
        border: 1px solid #ccc;
        font-size: 14px;
        box-sizing: border-box;
        transition: background-color 0.3s ease;
    }

    .btn-register:hover {
        background-color: #e2e2e2; /* Эффект при наведении */
    }
</style>
</body>
</html>