<?php
    session_start();
    include_once("connectDB.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if ($_POST["petId"] != 0) {
            $userId = $_POST["userId"];
            $petId = $_POST["petId"];
            $name = $_POST["name"];
            $pet = $_POST["type"];
            $age = $_POST["age"];
            $gender = $_POST["gender"];
            $breed = $_POST["breed"];

            $vetId = explode(",", $_POST["vetId"]);
            $vetDate = explode(",", $_POST["vetDate"]);

            $vacId = explode(",", $_POST["vacId"]);
            $vacName = explode(",", $_POST["vacName"]);

            $feedId = $_POST["feedId"];
            $count = $_POST["count"];
            $dosage = $_POST["dosage"];
            
            $weightId = explode(",", $_POST["weightId"]);
            $weightDate = explode(",", $_POST["weightDate"]);
            $weightValue = explode(",", $_POST["weightValue"]);
            
            $notes = $_POST["notes"];

            if (!($name == NULL or $pet == NULL or $age == NULL or $gender == NULL or $breed == NULL)) {
                $query = "INSERT INTO `Pets`(`id`, `userId`, `name`, `pet`, `age`, `gender`, `breed`)
                    VALUES ('$petId', '$userId', '$name', '$pet', '$age', '$gender', '$breed')
                    ON DUPLICATE KEY UPDATE
                        `name` = '$name',
                        `pet` = '$pet',
                        `age` = '$age',
                        `gender` = '$gender',
                        `breed` = '$breed'";
                $link->query($query);
            }

            for ($i = 0; $i < count($vetId); $i++) {
                $vetIdNum = $vetId[$i];
                $vetDateNum = $vetDate[$i];
                if (!($vetIdNum == NULL or $vetDateNum == NULL)) {
                    $query = "INSERT INTO `Veterinarian`(`id`, `petId`, `date`)
                        VALUES ('$vetIdNum', '$petId', '$vetDateNum')
                        ON DUPLICATE KEY UPDATE
                            `date` = '$vetDateNum'";
                    $link->query($query);
                }
            }

            for ($i = 0; $i < count($vacId); $i++) {
                $vacIdNum = $vacId[$i];
                $vacNameNum = $vacName[$i];
                if (!($vacIdNum == NULL or $vacNameNum == NULL)) {
                    $query = "INSERT INTO `Vaccination`(`id`, `petId`, `name`)
                        VALUES ('$vacIdNum', '$petId', '$vacNameNum')
                        ON DUPLICATE KEY UPDATE
                            `name` = '$vacNameNum'";
                    $link->query($query);
                }
            }

            if (!($feedId == NULL or $count == NULL or $dosage == NULL)) {
                $query = "INSERT INTO `Diet`(`petId`, `feedId`, `count`, `dosage`)
                    VALUES ('$petId', '$feedId', '$count', '$dosage')
                    ON DUPLICATE KEY UPDATE
                        `feedId` = '$feedId',
                        `count` = '$count',
                        `dosage` = '$dosage'";
                $link->query($query);
            }

            for ($i = 0; $i < count($weightId); $i++) {
                $weightIdNum = $weightId[$i];
                $weightDateNum = $weightDate[$i];
                $weightValueNum = $weightValue[$i];
                if (!($weightIdNum == NULL or $weightDateNum == NULL or $weightValueNum == NULL)) {
                    $query = "INSERT INTO `Weight`(`id`, `petId`, `gramms`, `date`)
                        VALUES ('$weightIdNum', '$petId', '$weightValueNum', '$weightDateNum')
                        ON DUPLICATE KEY UPDATE
                            `gramms` = '$weightValueNum',
                            `date` = '$weightDateNum'";
                    $link->query($query);
                }
            }

            if ($notes != NULL) {
                $query = "INSERT INTO `Notes`(`petId`, `content`)
                    VALUES ('$petId', '$notes')
                    ON DUPLICATE KEY UPDATE
                        `content` = '$notes'";
                $link->query($query);
            }

            if (isset($_FILES["upload"])) {
                $file = $_FILES["upload"];
                if ($file["error"] === UPLOAD_ERR_OK) {
                    $uploadDir = "../img/";
                    if (file_exists($uploadDir.$petId.".png")) {
                        unlink($uploadDir.$petId.".png");
                    }
                    $uploadFilePath = $uploadDir.$petId.".png";
                    move_uploaded_file($file["tmp_name"], $uploadFilePath);
                }
            }

        }
    }

?>