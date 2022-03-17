<?php
require __DIR__ . '/parts/connect_db.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'error' => '沒有表單',
    'code' => 0,
    'postData' => [],
    'insertId' => 0,
    'rowCount' => 0,
];

// if(empty($_POST['title'])){
//     echo json_encode($output, JSON_UNESCAPED_UNICODE);
//     exit;
// }


$output['postData'] = $_POST; // 讓前端做資料查看,資料是否一致

$sql = "INSERT INTO `board_comments`(`user_id`,`content`,`board_article_id`,`parentid`)
VALUES (?,?,?,?)";


$stmt = $pdo -> prepare($sql);

$stmt->execute([
    $_POST['user_id'],
    $_POST['content'],
    $_POST['board_article_id'],
    $_POST['parentid'],
]);

$output['insertId'] = $pdo->lastInsertId(); // 取得最新加入的資料的primary key
$output['rowCount'] = $stmt->rowCount(); // 新增資料的筆數

if($stmt->rowCount()){
    $output['success'] = true;
    $output['error'] = '';
} else {
    $output['error'] = '資料沒有新增成功';
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);