<?php
require __DIR__ . '/conect_DB.php';

header('Content-Type:application/json');

$output = [
    'success' => false,
    'error' => '沒有表單資料',
    'code' => 0,
    'postData' => [],

];

if (empty($_POST['title'])) {
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
$output['postData'] = $_POST;

//TODO：欄位檢查
$sql = "INSERT INTO `blog_article`(
`title`, `content`, `category`,`created_time`, `visible`, `users_id`
) VALUES (?,?,?,NOW(),?,?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['title'],
    $_POST['content'] ?? '',
    $_POST['category'] ?? NULL,
    $_POST['visible'] ?? '',
    $_POST['users_id'],
]);

$output['insertId'] = $pdo->lastInsertId();
$output['rowCount'] = $stmt->rowCount();
if ($stmt->rowCount()) {
    $output['error'] = '';
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有增新成功';
}

//用表單action的新增成功後轉向
// header("Location: Blog_home.php");

//用Ajax的新增成功後轉向
echo json_encode($output, JSON_UNESCAPED_UNICODE);
