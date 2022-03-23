<?php
require __DIR__ . '../../parts/connect_db.php';

$Activity_Types_id = isset($_GET['Activity_Types_id']) ? intval($_GET['Activity_Types_id']) : 0;

$sql = "DELETE FROM `activity_types` WHERE Activity_Types_id=$Activity_Types_id";

$stmt = $pdo->query($sql);

// echo $stmt->rowCount(); // 刪除幾筆
if(! empty($_SERVER['HTTP_REFERER'])){
    // 從哪裡來回哪裡去
    header('Location: '. $_SERVER['HTTP_REFERER']);
} else {
    header('Location: ab-list-types.php');
}

