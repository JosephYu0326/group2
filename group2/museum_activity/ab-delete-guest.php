<?php
require __DIR__ . '../../parts/connect_db.php';

$sid = isset($_GET['Activity_Guest_id']) ? intval($_GET['Activity_Guest_id']) : 0;

$sql = "DELETE FROM `activity_guest` WHERE Activity_Guest_id=$sid";

$stmt = $pdo->query($sql);

// echo $stmt->rowCount(); // 刪除幾筆
if(! empty($_SERVER['HTTP_REFERER'])){
    // 從哪裡來回哪裡去
    header('Location: '. $_SERVER['HTTP_REFERER']);
} else {
    header('Location: ab-list-guest.php');
}


