<?php
require __DIR__ . '/parts/connect_db.php';

// $sql = "INSERT INTO `address_book`(`name`, `email`, `mobile`, `birthday`, `address`, `created_at`) VALUES (?, ?, ?, ?, ?, NOW())";
$sql = "INSERT INTO `activity_organizers`(`Activity_Organizers_Name`, `Activity_Organizers_Img`)
 VALUES (?,?)";
// 避免 SQL injection 
$stmt = $pdo->prepare($sql);

$stmt->execute([
    '陳小華',
    'wa@ttt.com',
    
]);

echo $pdo->lastInsertId();  // 取得最新新增資料的PK
