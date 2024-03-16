<?php include_once "./db.php";

    $sql = "SELECT * FROM `playermsg` WHERE `id` = {$p['id']}";
    $result = $conn -> query($sql) -> fetch();
    if ($p['msgNum'] == $result['msgNumber']) {
        echo 1;
    } else {
        echo 0;
    }