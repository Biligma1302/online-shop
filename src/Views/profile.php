
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Профиль пользователя — Увеличенная версия</title>
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 80px 20px; /* Увеличены отступы сверху */
            color: #333;
        }
        .container {
            display: flex;
            gap: 40px; /* Увеличено расстояние между колонками */
            max-width: 1200px; /* Увеличена общая ширина */
            margin: 0 auto;
        }

        /* Левая колонка */
        .sidebar {
            background: white;
            border: 1px solid #ccc;
            width: 400px; /* Ширина увеличена с 300 до 400 */
            height: fit-content;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .sidebar-header {
            padding: 20px; /* Увеличены внутренние отступы */
            text-align: center;
            font-weight: bold;
            border-bottom: 1px solid #eee;
            font-size: 20px; /* Шрифт стал больше */
            background-color: #fafafa;
        }
        .avatar-placeholder {
            height: 250px; /* Увеличена высота области аватара */
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
        }
        .avatar-placeholder img {
            width: 80px; /* Иконка стала заметнее */
            opacity: 0.3;
        }

        /* Правая колонка */
        .content {
            flex-grow: 1;
        }
        .tab-button {
            background-color: #4a90e2;
            color: white;
            border: none;
            padding: 15px 35px; /* Кнопка стала крупнее */
            font-size: 18px; /* Шрифт кнопки увеличен */
            border-radius: 6px 6px 0 0;
            cursor: default;
        }
        .info-table {
            background: white;
            border: 1px solid #ccc;
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .info-table td {
            padding: 20px 25px; /* Значительно увеличены отступы в ячейках */
            border-bottom: 1px solid #eee;
            font-size: 18px; /* Текст стал крупнее */
        }
        .label {
            background-color: #f9f9f9;
            width: 30%;
            font-weight: 600;
            color: #555;
        }
        .value {
            width: 70%;
        }

        /* Ссылки */
        .actions {
            margin-top: 30px;
        }
        .actions a {
            display: inline-block;
            color: #4a90e2;
            text-decoration: none;
            font-size: 18px;
            margin-right: 30px;
            margin-bottom: 20px;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        .edit-link {
            color: #999 !important;
        }
    </style>
</head>
<body>

<div class="content">
    <button class="tab-button">О пользователе</button>
    <table class="info-table">
        <tr>
            <td class="label">Имя:</td>
            <td class="value">
                <?= htmlspecialchars($user['name'] ?? 'Не указано') ?>
            </td>
        </tr>
        <tr>
            <td class="label">Email:</td>
            <td class="value">
                <?= htmlspecialchars($user['email'] ?? 'Не указано') ?>
            </td>
        </tr>
        <tr>
            <td class="label">Страна:</td>
            <td class="value">
                <?= htmlspecialchars($user['country'] ?? 'Россия') ?>
            </td>
        </tr>
    </table>

    <div class="actions">
        <a href="/catalog">← Назад в каталог</a>
        <a href="/edit-profile" class="edit-link">Изменить профиль</a>
    </div>
</div>