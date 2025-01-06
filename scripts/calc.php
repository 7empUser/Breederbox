<?php 
    session_start();
    include_once("connectDB.php");

    $petsId = $_POST["petsId"];
    $allCostPerDay = 0;
    $outputText = "";
    foreach($petsId as $petId) {
        $query = "SELECT `name` FROM `Pets` WHERE `id` = '$petId'";
        $petName = $link->query($query)->fetch_all()[0][0];
        $query = "SELECT `feedId`, `count`, `dosage`
            FROM `Diet`
            WHERE `petId` = '$petId'";
        $result = $link->query($query);
        if ($result->num_rows) {
            $row = $result->fetch_all()[0];
            $feedId = $row[0];
            $count = $row[1];
            $dosage = $row[2];
            $query = "SELECT `quantity`, `price` FROM `Feeds` WHERE `id` = '$feedId'";
            $result = $link->query($query);
            $row = $result->fetch_all()[0];
            $quantity = $row[0];
            $price = $row[1];

            $costPerDay = $count * $dosage / $quantity * $price;
            $allCostPerDay += $costPerDay;
            $outputText .= "Содержание за сутки $petName: $costPerDay<br>";
        } else {
            $outputText .= "У питомца $petName не задан рацион<br>";
        };
    }
    $outputText = "Содержание всех выбранных питомцев за сутки: $allCostPerDay<br>".$outputText;
    echo ($outputText);
?>