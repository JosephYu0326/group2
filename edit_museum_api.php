<?php
require __DIR__ . '/parts/connect_db.php';

header('Content-Type: application/json'); //用json 傳遞參數資料


$output = [
    'success' => false,
    'error' => '沒有表單資料',
    'code' => 0,
    'postData' => [],
    'rowCount' => 0,
];
$output['postData'] = $_POST;

if(empty($_POST['museum_name']) or empty($_POST['Museum_id'])){
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}


$sql = "UPDATE `museum_museum` SET
        `Museum_name`=?,
        `Museum_location_id`=?,
        `Museum_kind_id`=?,
        `Museum_features`=?,
        `Museum_introduce`=?,
        `Museum_booking_notice`=?,
        `Museum_more_information`=? 
        WHERE `Museum_id` = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_POST['museum_name'] ?? '',
    $_POST['Museum_location_id'] ?? '',
    $_POST['Museum_kind_id'] ?? '',
    $_POST['Museum_features'] ?? '',
    $_POST['Museum_introduce'] ?? '',
    $_POST['Museum_booking_notice'] ?? '',
    $_POST['Museum_more_information'] ?? '',
    $_POST['Museum_id'],
]);

$output['rowCount'] = $stmt->rowCount(); 
if($stmt->rowCount()){
    $output['error'] = '';
    $output['success'] = true;
}else{
    $output['error'] = '資料沒有修改成功';
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);