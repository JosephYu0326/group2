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

if (empty($_POST['product_id']) or empty($_POST['product_name'])) {
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
};

$sql = "UPDATE `products_sale` SET
        `product_name`=?, 
        `product_intro`=?, 
        `product_main`=?, 
        `product_more_info`=?, 
        `product_size`=?,
        `product_orign_price`=?,
        `product_price`=?,
        `product_store_quantity`=?,
        `product_category`=?,
        `product_location`=?
        WHERE `product_id`=?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_POST['product_name'] ?? '',
    $_POST['product_intro'] ?? '',
    $_POST['product_main'] ?? '',
    $_POST['product_more_info'] ?? '',
    $_POST['product_size'] ?? '',
    $_POST['product_orign_price'] ?? '',
    $_POST['product_price'] ?? '',
    $_POST['product_store_quantity'] ?? '',
    $_POST['product_category'] ?? '',
    $_POST['product_location'] ?? '',
    $_POST['product_id'],
]);

$output['rowCount'] = $stmt->rowCount(); // 修改資料的筆數
if ($stmt->rowCount()) {
    $output['error'] = '';
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有修改';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
