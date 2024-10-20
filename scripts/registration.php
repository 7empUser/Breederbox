<?php

    if (!((isset($_POST["login"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirmPass"])))) {
        header("Location: ");
    }
    $login = $_POST["login"];
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $confirmPass = $_POST["confirmPass"];

?>