<?php

    session_start();
    include_once("connectDB.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST["feedId"] != 0) {
            $userId = $_SESSION["userId"];
            $feedId = $_POST["feedId"];
            $brand = $_POST["brand"];
            $quantity = $_POST["quantity"];
            $price = $_POST["price"];
            $action = $_POST["action"];
            $query;
            if ($action == "add") {
                $query = "INSERT INTO `Feeds`(`userId`, `brand`, `quantity`, `price`)
                    VALUES('$userId', '$brand', '$quantity', '$price')";
            } elseif ($action == "save") {
                $query = "UPDATE `Feeds` 
                    SET `brand` = '$brand', `quantity` = '$quantity', `price` = '$price'
                    WHERE `id` = '$feedId'";
            } else {
                $query = "DELETE FROM `Feeds`
                    WHERE `id` = '$feedId'";
            }
            $link->query($query);
        }
    }
    
?>