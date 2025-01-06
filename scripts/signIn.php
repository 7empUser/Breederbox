<?php

    include_once("connectDB.php");

    if (!(isset($_POST["email"]) && isset($_POST["password"]))) {
        header("Location: ");
    }
    $email = $_POST["email"];
    $pass = $_POST["password"];

    $query = "SELECT `id`, `password`
        FROM `Users`
        WHERE `email` = '$email'";
    $result = $link->query($query);
    $row = $result->fetch_all();
    $userId = $row[0][0];
    $passDB = $row[0][1];
    if (hash("sha256", $pass) == $passDB) {
        session_start();
        $_SESSION["userId"] = $userId;
        header("Location: ../pets.php");
    } else {
        header("Location: ../signIn.php");
    }

?>