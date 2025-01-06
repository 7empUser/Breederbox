<?php

    include_once("connectDB.php");

    if (!isset($_POST["reg"])) {
        header("Location: ");
    }
    $email = $_POST["email"];
    if ($_POST["password"] == $_POST["confPassword"]) {
        $pass = hash("sha256", $_POST["password"]);
    } else {
        header("Location: ../registration.php");
    }
    
    $time = strtotime(date("d-m-Y H:i:s"));

    $query = "INSERT INTO `Users`(`email`, `password`, `regTime`, `subscribe`) VALUES ('$email', '$pass', $time, '0')";
    $link->query($query);
    header("Location: ../signIn.php");

?>