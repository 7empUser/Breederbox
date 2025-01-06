<?php 
    session_start();
    isset($_SESSION["userId"]) ? $userId = $_SESSION["userId"] : header("Location: signin.php");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/add-button.css">
    <link rel="stylesheet" href="style/lk.css">
    <script type="text/javascript" src="scripts/jquery_3_7_1.min.js"></script>
    <script type="text/javascript" src="scripts/add-pet.js"></script>
    <title>Личный кабинет</title>
    <?php
        echo ("<link rel='stylesheet' href='style/". (isset($_SESSION["userId"]) ? "header-after-sign.css'>" : "header.css'>"));
    ?>
</head>
<body>
    <?php 
        include_once("components/". (isset($_SESSION["userId"]) ? "header-after-sign.html" : "header.html"));
    ?>
    <div class="add-button" name="add-anim" id="add-anim" title="Добавить животное">+</div>
    <div class="body">
        <div class="container">
            <div class="form-fields"></div>
                <div class="form-field">
                    <input type="text" placeholder="Указать имя пользователя">
                </div>
                <div class="form-field">
                    <input type="text" placeholder="Адрес электронной почты">
                </div>
                <a href="#" name="edit-mail" id="edit-mail" class="edit-mail">Изменить почту</a>
                <div class="form-field">
                    <input type="password" placeholder="Пароль">
                </div>
                <a href="#" name="edit-pass" id="edit-pass" class="edit-pass">Изменить пароль</a>

            <img src="materials/dog_cat.png" class="dogcat">    
            <form>
                <button type="submit" class="manage_sub">Управление подпиской</button>
            </form>
        </div>
    </div>
</body>
</html>
