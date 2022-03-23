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
$output['postData'] = $_POST;

if(empty($_POST['sn']) or empty($_POST['thema'])){
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}


//TODO：欄位檢查
$sql = "UPDATE `blog_category` SET 
`thema`=?,
`squence`=?
WHERE `sn`=?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_POST['thema']??'',
    $_POST['squence'] ?? '',
    $_POST['sn'],
]);

$output['rowCount'] = $stmt->rowCount();
if($stmt->rowCount()){
    $output['error'] = '';
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有修改成功';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);