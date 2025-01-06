<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/registrat.css">
    <?php
        echo ("<link rel='stylesheet' href='style/". (isset($_SESSION["userId"]) ? "header-after-sign.css'>" : "header.css'>"));
    ?>
    <title>Регистрация Breeder Box</title>
</head>
<body>
    <?php
        include_once("components/". (isset($_SESSION["userId"]) ? "header-after-sign.html" : "header.html"));
    ?>
    <div class="body">
        <div class="container">
            <h2 class="form-title">Все ваши животные <br> в одном месте</h2>
            <form action="scripts/registration.php" method="POST">
                <div class="form-field">
                    <input type="email" name="email" placeholder="Адрес электронной почты">
                </div>
                <div class="form-field">
                    <input type="password" name="password" placeholder="Введите пароль">
                </div>
                <div class="form-field">
                    <input type="password" name="confPassword" placeholder="Подтвердите пароль">
                </div>
                <button type="submit" class="reg_btn" name="reg" value="ok">Регистрация</button>
            </form>
            <p>Уже есть аккаунт? <a href="#"> Вход </p>
        </div>
    </div>    
</body>
</html>