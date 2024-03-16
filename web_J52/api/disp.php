<?php include_once "./db.php";

    $sql = "SELECT * FROM `playermsg` ORDER BY `id` DESC";
    $stmt = $conn -> query($sql) -> fetchAll();
    echo json_encode($stmt);