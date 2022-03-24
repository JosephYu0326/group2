<?php
require __DIR__ . '../../parts/connect_db.php';

header('Content-Type:application/json');

$output = [
    'success' => false,
    'error' => '沒有表單資料',
    'code' => 0,
    'postData' => [],
    'rowCount' => 0,
];

if(empty($_POST['article_id']) or empty($_POST['title'])){
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
$output['postData'] = $_POST;


//TODO：欄位檢查
$sql = "UPDATE `blog_article` SET 
`title`=?,
`content`=?,
`visible`=?,
`category`=?,
`users_id`=? 
WHERE `article_id`=?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_POST['title'],
    $_POST['content'] ?? '',
    $_POST['visible'] ?? '',
    $_POST['category'] ??'',
    $_POST['users_id'] ?? '',
    $_POST['article_id'],
]);

$output['rowCount'] = $stmt->rowCount();
if($stmt->rowCount()){
    $output['error'] = '';
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有修改成功';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);