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

$museum_name = $_POST["museum_name"];
$sql3 = "select * from museum_museum where museum_name =?";
$stmt3 = $pdo->prepare($sql3);
$stmt3->execute([$museum_name]);
$user = $stmt3->fetch();
if ($user) {
    $output['error'] = '館名重複';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
$sql = "INSERT INTO `museum_museum`(`Museum_name`,`Museum_location_id`,`Museum_kind_id`,`Museum_features`,`Museum_introduce`,`Museum_booking_notice`,`Museum_more_information`) Values (?, ?, ?, ?, ?, ?, ?)";


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


$output['insertId'] = $pdo->lastInsertId(); 
$output['rowCount'] = $stmt->rowCount(); 
if($stmt->rowCount()){
    $output['error'] = '';
    $output['success'] = true;
}else{
    $output['error'] = '資料沒有新增成功';
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);