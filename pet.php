<?php
    session_start();
    include_once("scripts/connectDB.php");
    isset($_SESSION["userId"]) ? $userId = $_SESSION["userId"] : header("Location: signin.php");
    if (isset($_GET["pet"])) {
        $petId = $_GET["pet"];
    } else {
        $query = "SELECT MAX(`id`) FROM `Pets`";
        $petId = $link->query($query)->fetch_all()[0][0] + 1;
        header("Location: pet.php?pet=$petId");
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/newPet.css">
    <?php
        echo ("<link rel='stylesheet' href='style/". (isset($_SESSION["userId"]) ? "header-after-sign.css'>" : "header.css'>"));
    ?>
    <script type="text/javascript" src="scripts/jquery_3_7_1.min.js"></script>
    <title>Новое животное</title>
</head>
<body>
    <?php
        include_once("components/". (isset($_SESSION["userId"]) ? "header-after-sign.html" : "header.html"));
    ?>
    <div class="container">
        <h2 class="form-title">Добавить новое животное</h2>
        <input type="file" name="img" enctype="multipart/form-data">
        <?php
            echo ("<img alt='Добавить фото' class='addImg' src='".(file_exists("img/$petId.png") ? "img/$petId.png" : "materials/photo.png")."'>");
        ?>
        <div>
            <div class="row" data-row="1">
                <div class="info-container">
                    <?php 
                        echo ("<input type='hidden' value='$userId' name='userId'>");
                        echo ("<input type='hidden' value='$petId' name='petId'>");
                    ?>
                    <img src="materials/info.png" alt="Информация">
                    <p>Основная информация</p>
                    <div class="panel-form">
                        <?php
                            $query = "SELECT * FROM `Pets` WHERE `id` = '$petId'";
                            $result = $link->query($query);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_all()[0];
                                $name = $row[2];
                                $pet = $row[3];
                                $age = $row[4];
                                $gender = $row[5];
                                $breed = $row[6];
                            } else {
                                $name = "";
                                $pet = "";
                                $age = "";
                                $gender = "";
                                $breed = "";
                            }
                            echo ("<input type='text' name='name' placeholder='Кличка' value='$name'>");
                            echo ("<input type='text' name='type' placeholder='Вид' value='$pet'>");
                            echo ("<input type='text' name='age' placeholder='Возраст' value='$age'>");
                            // echo ("<input type='text' name='gender' placeholder='Пол' value='$gender'>");
                            echo ("<select>");
                            echo ("<option value='Самец'" . ($gender == 'Самец' ? " selected" : "") . ">Самец</option>");
                            echo ("<option value='Самка'" . ($gender == 'Самка' ? " selected" : "") . ">Самка</option>");
                            echo ("</select>");
                            echo ("<input type='text' name='breed' placeholder='Порода' value='$breed'>");
                        ?>
                    </div>
                </div>
                <div class="info-container">
                    <img src="materials/veterinarian.png" alt="Ветеринар">
                    <p>Посещение ветеринара</p>
                    <div class="panel-form">
                        <?php
                            $query = "SELECT MAX(`id`) FROM `Veterinarian`";
                            $id = $link->query($query)->fetch_all()[0][0];
                            $id = ($id == NULL) ? -1 : $id;
                            echo ("<input type='text' id='vetEmpty' name='vetDate' placeholder='ДД.ММ.ГГГГ' data-id='".($id + 1)."'>");
                            $query = "SELECT * FROM `Veterinarian` WHERE `petId` = '$petId'";
                            $result = $link->query($query);
                            $row = $result->fetch_all();
                            foreach ($row as $elem) {
                                $id = $elem[0];
                                $date = $elem[2];
                                echo ("<input type='text' name='vetDate' placeholder='ДД.ММ.ГГГГ' data-id='$id' value='$date'>");
                            }
                        ?>
                    </div>
                </div>
                <div class="info-container">
                    <img src="materials/treatment.png" alt="Прививки">
                    <p>Прививки</p>
                    <div class="panel-form">
                        <?php
                            $query = "SELECT MAX(`id`) FROM `Vaccination`";
                            $id = $link->query($query)->fetch_all()[0][0];
                            $id = ($id == NULL) ? -1 : $id;
                            echo ("<input type='text' id='vacEmpty' name='vaccinationName' placeholder='Название прививки' data-id='".($id + 1)."'>");
                            $query = "SELECT * FROM `Vaccination` WHERE `petId` = '$petId'";
                            $result = $link->query($query);
                            $row = $result->fetch_all();
                            foreach ($row as $elem) {
                                $id = $elem[0];
                                $name = $elem[2];
                                echo ("<input type='text' name='vaccinationName' placeholder='Название прививки' data-id='$id' value='$name'>");
                            }
                        ?>
                    </div>
                </div>
                <div class="info-container">
                    <img src="materials/feed.png" alt="Питание">
                    <p>Питание</p>
                    <div class="panel-form">
                        <?php
                            echo ("<select name='feedId' placeholder='Id еды'>");
                            $query = "SELECT `feedId`, `count`, `dosage` FROM `Diet` WHERE `petId` = '$petId'";
                            $result = $link->query($query);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_all()[0];
                                $feedId = $row[0];
                                $count = $row[1];
                                $dosage = $row[2];
                            } else {
                                $feedId = -1;
                                $count = "";
                                $dosage = "";
                            }
                            $query = "SELECT `id`, CONCAT(`brand`, ' ', `quantity`) AS `name`
                                FROM `Feeds`
                                WHERE `userId` = '$userId'";
                            $result = $link->query($query);
                            $row = $result->fetch_all();
                            foreach ($row as $elem) {
                                $id = $elem[0];
                                $name = $elem[1];
                                echo("<script>console.log('$name')</script>");
                                echo ("<option value='$id'". (($id == $feedId) ? " selected" : "").">$name</option>");
                            }
                            echo ("</select>");
                            echo ("<input type='text' name='count' placeholder='Количество кормежек за день' value='$count'>");
                            echo ("<input type='text' name='dosage' placeholder='Размер порции в граммах' value='$dosage'>");
                        ?>
                    </div>
                </div>
            </div>
            <div class="row" data-row="2">
                <div class="info-container">
                    <img src="materials/feed.png" alt="Вес">
                    <p>Вес</p>
                    <div class="panel-form">
                        <div>
                            <input type="text" name="weight" placeholder="Вес в г" data-id="1">
                            <input type="text" name="weightDate" placeholder="ДД.ММ.ГГГГ">
                        </div>
                    </div>
                </div>
                <div class="info-container">
                    <img src="materials/note.png" alt="Заметки">
                    <p>Заметки</p>
                    <div class="panel-form">
                        <textarea name="notes" placeholder="Заметки" data-id="1"></textarea>
                    </div>
                </div>
                <div class="info-container">
                    <img src="materials/documents.png" alt="Документы">
                    <p>Документы</p>
                    <div class="panel-form">
                        <input type="hidden">
                    </div>
                </div>
            </div>
        </div>
        <div>
            <button class="save">Сохранить</button>
        </div>
    </div>
    <script src="scripts/pet.js"></script>
</body>
</html>