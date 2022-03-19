<?php
require __DIR__ . '/parts/connect_db.php';

header('Content-Type: application/json');
//  輸出的資料格式
$output = [
    'success' => false,
    'error' => '沒有表單資料',
    'code' => 0,
    'postData' => [],
    'rowCount' => 0,
];

$output['postData'] = $_POST; // 讓前端做資料查看, 資料是否一致

if (empty($_POST['discount_photo_id']) or empty($_POST['discount_photo_name'])) {
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
};

$sql = "UPDATE `products_discount_photos` SET
        `discount_photo_name`=?, 
        `discount_photos_url`=?
        WHERE `discount_photo_id`=?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_POST['discount_photo_name'] ?? '',
    $_POST['discount_photos_url'] ?? '',
    $_POST['discount_photo_id'],
]);

$output['rowCount'] = $stmt->rowCount(); // 修改資料的筆數
if ($stmt->rowCount()) {
    $output['error'] = '';
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有修改';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);