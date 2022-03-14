<?php
require __DIR__ . '/parts/connect_db.php';

header('Content-Type: application/json');
//  輸出的資料格式
$output = [
    'success' => false,
    'error' => '沒有表單資料',
    'code' => 0,
    'postData' => [],
    'insertId' => 0,
    'rowCount' => 0,
];

if (empty($_POST['product_name'])) {
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
};

$output['postData'] = $_POST; // 讓前端做資料查看, 資料是否一致

// TODO: 欄位檢查

$sql = "INSERT INTO `products_sale`(`product_name`, `product_intro`, `product_main`, `product_more_info`, `product_size`, `product_orign_price`, `product_price`, `product_store_quantity`, `product_category`, `product_location`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

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
]);

$output['insertId'] = $pdo->lastInsertId(); // 取得最近加入資料的 PK
$output['rowCount'] = $stmt->rowCount(); // 新增資料的筆數
if($stmt->rowCount()){
    $output['error'] = ''; 
    $output['success'] = true; 
} else {
    $output['error'] = '資料沒有新增成功';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
