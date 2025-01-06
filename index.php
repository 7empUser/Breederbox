<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/main.css">
    <?php
        echo ("<link rel='stylesheet' href='style/". (isset($_SESSION["userId"]) ? "header-after-sign.css'>" : "header.css'>"));
    ?>
    <title>Главная</title>
</head>
<body>
    <?php 
        include_once("components/". (isset($_SESSION["userId"]) ? "header-after-sign.html" : "header.html"));
    ?>

    <main>
        <div>
            <h1>Все ваши животные </br>в одном месте</h1>
            <p class="subhead">Храните все важные данные о питании, истории здоровья и многом</br>
                другом вместе с Breeder Box.</p>
            <div class="paragraph">
                <div>
                    <p class="checkmark">✓</p>
                    <p>Отслеживание питания, веса и диет</p>
                </div>
                <div>
                    <p class="checkmark">✓</p>
                    <p>История прививок, посещения ветеринаров и лечения</p>
                </div>
                <div>
                    <p class="checkmark">✓</p>
                    <p>Удобный поиск и сортировка информации</p>
                </div>
            </div>
        </div>
        <div class="icons-panel">
            <div>
                <img src="materials/documents.png">
                <img src="materials/treatment.png">
            </div>
            <div>
                <img src="materials/info.png">
                <img src="materials/treatment.png">
                <img src="materials/photo.png">
            </div>
            <div>
                <div>
                    <img src="materials/info.png">
                    <p>Графики</p>
                </div>
                <div>
                    <img src="materials/feed.png">
                    <p>Питание</p>
                </div>
                <div>
                    <img src="materials/veterinarian.png">
                    <p>Прививки</p>
                </div>
                <div>
                    <img src="materials/note.png">
                    <p>Заметки</p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>