<?php
    session_start();
    include_once('scripts/connectDB.php');
    isset($_SESSION["userId"]) ? $userId = $_SESSION["userId"] : header("Location: signin.php");
    $userId = $_SESSION['userId'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/bootstrap.min.css" rel="stylesheet">
    <?php
        echo ("<link rel='stylesheet' href='style/". (isset($_SESSION["userId"]) ? "header-after-sign.css'>" : "header.css'>"));
    ?>
    <link rel="stylesheet" href="style/add-animals.css">
    <link rel="stylesheet" href="style/add-button.css">
    <script type="text/javascript" src="scripts/jquery_3_7_1.min.js"></script>
    <script type="text/javascript" src="scripts/add-pet.js"></script>
    <script type="text/javascript" src="scripts/pets.js"></script>
    <title>Животные</title>
</head>
<body>
    <?php
        include_once("components/". (isset($_SESSION["userId"]) ? "header-after-sign.html" : "header.html"));
    ?>
    <div class="search-container">
        <input type="text" class="search-form" placeholder="Поиск..." data-id="<?php echo($userId); ?>">
        <div class="filter-dropdown">
            <div class="dropdown-content-filter">
                <div><input type="checkbox" name="filter" id="option1" checked><label for="option1">Самец</label></div>
                <div><input type="checkbox" name="filter" id="option2" checked><label for="option2">Самка</label></div>
                <div><input type="checkbox" name="filter" id="option3"><label for="option3">Щенок</label></div>
            </div>
            <button class="dropdown-button-filter">
                <img src="materials/filter_btn.png" alt="Кнопка" class="img-menu">
            </button>
        </div>
    </div>
    <div class="form-container">
        <div name="petResults">
            <?php
            
                $query = "SELECT *
                    FROM `Pets`
                    WHERE `userId` = '$userId'";
                $result = $link->query($query);
                $rows = $result->fetch_all();
                foreach ($rows as $row) {
                    $petId = $row[0];
                    $name = $row[2];
                    $gender = $row[5];
                    $breed = $row[6];
                    $img = file_exists("img/$petId.png") ? "<img src='img/$petId.png'>" : "<p class='photo-text'>".mb_substr($name, 0, 1)."</p>";
                    echo ("<button class='block-animals' data-id='$petId'>");
                    echo ("<div class='img-block'>$img</div>");
                    echo ("<div class='animal-info'><p>$name</p>");
                    echo ("<p>$breed</p>");
                    echo ("<p>$gender</p></div>");
                    echo ("<div class='selectPetDiv'><input type='checkbox' name='selectPet' class='hiddenObject'></div>");
                    echo ("</button>");
                }
            
            ?>
        </div>
        <div name="feedResults">
            <?php

                $query = "SELECT MAX(`id`) FROM `Feeds`";
                $maxFeedId = $link->query($query)->fetch_all()[0][0] + 1;
                echo ("<div class='block-feeds' data-id='$maxFeedId' id='empty'>");
                echo ("<input type='text' name='brand' placeholder='Название товара'>");
                echo ("<div class='feed-split'><input type='text' name='quantity' placeholder='Объем'>");
                echo ("<input type='text' name='price' placeholder='Цена'></div>");
                echo ("<button name='add'>Добавить</button>");
                echo ("</div>");
                $query = "SELECT *
                    FROM `Feeds`
                    WHERE `userId` = '$userId'";
                $result = $link->query($query);
                if ($result->num_rows) {
                    $rows = $result->fetch_all();
                    foreach ($rows as $row) {
                        $feedId = $row[0];
                        $brand = $row[2];
                        $quantity = $row[3];
                        $price = $row[4];
                        echo ("<div class='block-feeds' data-id='$feedId'>");
                        echo ("<input type='text' name='brand' placeholder='Название товара' value='$brand'>");
                        echo ("<div class='feed-split'><input type='text' name='quantity' placeholder='Объем' value='$quantity'>");
                        echo ("<input type='text' name='price' placeholder='Цена' value='$price'></div>");
                        echo ("<div class='feed-split'><button name='save'>Сохранить</button>");
                        echo ("<button name='delete'>Удалить</button></div>");
                        echo ("</div>");
                    }
                }

            ?>
        </div>
        <div class="hiddenObject" name="calcDiv">
            <div>
                <h3>Расходы на выбранных животных</h3>
                <div>
                    <button name="selectAll">Выбрать все</button>
                    <button name="clearAll">Очистить все</button>
                </div>
                <p>Не выбран ни один питомец</p>
            </div>
        </div>
    </div>
    <div class="calcTrigger">
        <img src="materials/calculator.png" alt="Калькулятор">
    </div>
    <div class="add-button" name="add-anim" id="add-anim" title="Добавить животное">+</div>
</body>
</html>