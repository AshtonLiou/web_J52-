<?php include_once "./db.php";

    if ($p["del"] == 1) {
        $sql = "UPDATE `playermsg` SET `delTime` = NOW() WHERE `id` = {$p["id"]}";
        $conn -> exec($sql);
    } else {
        # code...
    }