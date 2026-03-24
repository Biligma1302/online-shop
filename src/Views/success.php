
<div class="success-container">
    <div class="success-card">
        <div class="success-icon">✔</div>
        <h1>Спасибо за заказ!</h1>
        <p>Ваш заказ успешно оформлен</p>

        <div class="actions">
            <a href="/user-orders" class="btn-primary">Посмотреть мои заказы</a>
            <a href="/catalog" class="btn-secondary">Вернуться в магазин</a>
        </div>
    </div>
</div>

<style>
    .success-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 70vh;
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .success-card {
        background: white;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        text-align: center;
        max-width: 500px;
        width: 100%;
        border-top: 5px solid #04AA6D;
    }

    .success-icon {
        background: #04AA6D;
        color: white;
        width: 70px;
        height: 70px;
        line-height: 70px;
        font-size: 40px;
        border-radius: 50%;
        margin: 0 auto 20px;
    }

    h1 {
        color: #333;
        margin-bottom: 15px;
    }

    p {
        color: #666;
        line-height: 1.6;
        margin-bottom: 30px;
    }

    .actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn-primary {
        background-color: #04AA6D;
        color: white;
        padding: 14px;
        text-decoration: none;
        border-radius: 4px;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background-color: #059862;
    }

    .btn-secondary {
        color: dodgerblue;
        text-decoration: none;
        font-size: 0.9em;
        margin-top: 10px;
    }

    .btn-secondary:hover {
        text-decoration: underline;
    }
</style>