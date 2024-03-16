<?php include_once "./db.php";

    $sql = "INSERT INTO `playermsg`(`name`, `email`, `tel`, `msgContent`, `uploadImg`, `msgNumber`)
        VALUES ('{$p['name']}','{$p['email']}','{$p['tel']}','{$p['msgContent']}','{$p['uploadImg']}','{$p['msgNumber']}')";
    $conn -> exec($sql);
    header("location: ../index.php");