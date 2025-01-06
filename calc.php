<?php
    session_start();
    include_once("scripts/connectDB.php");
    $userId = $_SESSION["userId"];
    
    if (isset($_POST["calc"])) {
        include_once("scripts/calc.php");
    }

?>
<form action="calc.php" method="POST">
    <select name="diet">
    <?php

        $query = "SELECT `id`, (SELECT `brand` FROM `Diet`, `Feeds` WHERE `feedId` = `Feeds`.`id`) AS `feed`
            FROM `Diet`";
        $result = $link->query($query);
        $rows = $result->fetch_all();
        foreach ($rows as $row) {
            $id = $row[0];
            $feed = $row[1];
            echo ("<option value='$id'>$feed</option>");
        }

    ?>
    </select>
    <input type="submit" name="calc" value="calc">
</form>