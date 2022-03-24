<?php
require __DIR__ . '../../parts/connect_db.php';

header('Content-Type: application/json'); //用json 傳遞參數資料


$output = [
    'success' => false,
    'error' => '沒有表單資料',
    'code' => 0,
    'postData' => [],
    'insertId' => 0,
    'rowCount' => 0,
];

if(empty($_POST['Museum_id'])){
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
$output['postData'] = $_POST;

$sql2 = "UPDATE `museum_images` SET  `Museum_id`=?,`image_url`=? WHERE `image_id`=?";

$stmt = $pdo->prepare($sql2);

$stmt->execute([
    $_POST['Museum_id'] ?? '',
    $_POST['pic'] ?? '',
    $_POST['image_id'] ?? '',
]);


$output['rowCount'] = $stmt->rowCount(); 
if($stmt->rowCount()){
    $output['error'] = '';
    $output['success'] = true;
}else{
    $output['error'] = '資料沒有修改成功';
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);