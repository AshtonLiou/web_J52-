<?php include_once "./db.php";

    $sql = "SELECT * FROM `admin` WHERE `acc` = '{$p['acc']}' AND `pw` = '{$p['pw']}'";
    $result = $conn -> query($sql) -> fetch();
    if (empty($result)) {
        echo 0;
    } else {
        echo 1;
    };