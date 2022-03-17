<?php
require __DIR__ . '/parts/connect_db.php';

header('Content-Type: application/json'); //用json 傳遞參數資料


$output = [
    'success' => false,
    'error' => '沒有表單資料',
    'code' => 0,
    'postData' => [],
    'insertId' => 0,
    'rowCount' => 0,
];

if(empty($_POST['museum_name'])){
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$output['postData'] = $_POST;

$sql = "INSERT INTO `museum_museum`(`Museum_name`,`Museum_location_id`,`Museum_kind_id`,`Museum_features`,`Museum_introduce`,`Museum_booking_notice`,`Museum_more_information`) Values (?, ?, ?, ?, ?, ?, ?)";
$sql2 = "INSERT INTO `museum_images`(`Museum_id`,`image_url`) Values(last_insert_id(),?)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_POST['museum_name'] ?? '',
    $_POST['museum_location_id'] ?? '',
    $_POST['Museum_kind_id'] ?? '',
    $_POST['Museum_features'] ?? '',
    $_POST['Museum_introduce'] ?? '',
    $_POST['Museum_booking_notice'] ?? '',
    $_POST['Museum_more_information'] ?? '',
]);

$stmt2 = $pdo->prepare($sql2);
$stmt2->execute([
    $_POST['pic'] ?? '',

]);

$output['insertId'] = $pdo->lastInsertId(); 
$output['rowCount'] = $stmt->rowCount(); 
if($stmt->rowCount()){
    $output['error'] = '';
    $output['success'] = true;
}else{
    $output['error'] = '資料沒有新增成功';
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);