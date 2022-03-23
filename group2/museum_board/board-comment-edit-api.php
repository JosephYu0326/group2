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
];

$output['postData'] = $_POST;  // 讓前端做資料查看,資料是否一致

// if(empty($_POST['board_cid'])){
//     echo json_encode($output, JSON_UNESCAPED_UNICODE);
//     exit;
// }


// TODO: 欄位檢查


$sql = "UPDATE `board_comments` SET 
        `content`=?,
        `parentid`=?,
        `user_id`=?,
        `board_article_id`=?
        WHERE `board_cid`=?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_POST['content'],
    $_POST['parentid'],
    $_POST['user_id'],
    $_POST['board_article_id'],
    $_POST['board_cid'],
]);

$output['rowCount'] = $stmt->rowCount(); // 修改資料的筆數
if($stmt->rowCount()){
    $output['error'] = '';
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有修改';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);