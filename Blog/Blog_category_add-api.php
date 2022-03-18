<?php
require __DIR__ .  '/conect_DB.php';
header('Content-Type:application/json');

$output = [
    'success' => false,
    'error' => '沒有表單資料',
    'code' => 0,
    'postData' => [],

];

if (empty($_POST['thema'])) {
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$output['postData'] = $_POST;

//TODO：欄位檢查
$sql = "INSERT INTO `blog_category`(`thema`, `squence`) 
VALUES (?, ?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['thema'],
    $_POST['squence'] ?? '',
]);

$output['insertId'] = $pdo->lastInsertId();
$output['rowCount'] = $stmt->rowCount();
if ($stmt->rowCount()) {
    $output['error'] = '';
    $output['success'] = true;
} else {
    $output['error'] = '分類增新';
}

//新增成功後轉向
//header("Location: Blog_category.php");

//用Ajax的新增成功後轉向
echo json_encode($output, JSON_UNESCAPED_UNICODE);