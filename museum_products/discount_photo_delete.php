<?php
require __DIR__ . '../../parts/connect_db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "DELETE FROM `products_discount_photos` WHERE discount_photo_id=$sid";

$stmt = $pdo->query($sql);

echo $stmt->rowCount(); // 刪除幾筆

if (!empty($_SERVER['HTTP_REFERER'])) {
    // 從哪裡來回哪裡去
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header('Location:discount_photo_list.php');
}
