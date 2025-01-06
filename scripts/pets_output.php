<?php
    include_once('connectDB.php');
    $search = isset($_POST["search"]) ? $_POST["search"] : "";
    $filters = isset($_POST["filters"]) ? $_POST["filters"] : [];
    for ($i = 0; $i < count($filters); $i++) {
        $filters[$i] = $filters[$i] == "true";
    }
    $userId = $_POST["userId"];
    $query = "SELECT *
        FROM `Pets`
        WHERE `userId` = '$userId'";

    if (!empty($filters)) {
        if (!($filters[0] or $filters[1] or $filters[2])) {
            $query .= " AND `gender` LIKE '.'";
        } elseif ($filters[0] == $filters[1]) {
            $query .= " AND `gender` LIKE '%'";
        } elseif ($filters[0]) {
            $query .= " AND `gender` LIKE 'Самец'";
        } elseif ($filters[1]) {
            $query .= " AND `gender` LIKE 'Самка'";
        }
        if ($filters[2]) {
            $query .= " AND `age` <= '3'";
        }
    }
    if (!empty($search)) {
        $query .= " AND (`name` LIKE '$search' OR `breed` LIKE '$search')";
    }

    $result = $link->query($query);
    if ($result->num_rows > 0) {
        $rows = $result->fetch_all();
        foreach ($rows as $row) {
            $petId = $row[0];
            $name = $row[2];
            $gender = $row[5];
            $breed = $row[6];
            $img = file_exists("../img/$petId.png") ? "<img src='../img/$petId.png'>" : "<p class='photo-text'>".mb_substr($name, 0, 1)."</p>";
            echo ("<button class='block-animals' data-id='$petId'>");
            echo ("<div class='img-block'>$img</div>");
            echo ("<div class='animal-info'><p>$name</p>");
            echo ("<p>$breed</p>");
            echo ("<p>$gender</p></div>");
            echo ("<div class='selectPetDiv'><input type='checkbox' name='selectPet' class='hiddenObject'></div>");
            echo ("</button>");
        }
    }

?>