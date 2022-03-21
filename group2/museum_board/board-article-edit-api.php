<?php
require __DIR__ . '../../parts/connect_db.php';

header('Content-Type: application/json');
// 輸出的資料格式
$output = [
    'success' => false,
    'error' => '沒有表單資料',
    'code' => 0,
    'postData' => [],
    'rowCount' => 0,
    // 'InsertId' => 0,
];

$output['postData'] = $_POST;  // 讓前端做資料查看,資料是否一致

if(empty($_POST['board_aid']) or empty($_POST['title'])){
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}


// TODO: 欄位檢查


$sql = "UPDATE `board_articles` SET 
        `user_id`=?,
        `title`=?,
        `content`=?
        WHERE `board_aid`=?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_POST['user_id'],
    $_POST['title'],
    $_POST['content'],
    $_POST['board_aid'],
]);


$aid = intval($_POST['board_aid']);

$sql = "DELETE FROM `board_photos` WHERE board_article_id = $aid";

// echo $sql; exit; // test
$stmt = $pdo->query($sql);


$sql2 = "INSERT INTO `board_photos`(`img`,`board_article_id`)
VALUES (?,?)";


$stmt2 = $pdo -> prepare($sql2);

$stmt2->execute([
    $_POST['pic_name'] ?? '',
    $_POST['board_aid'],
]);



$output['rowCount'] = $stmt->rowCount(); // 修改資料的筆數
$output['rowCount'] = $stmt2->rowCount(); // 修改資料的筆數
if($stmt->rowCount() or $stmt2->rowCount()){
    $output['error'] = '';
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有修改';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);