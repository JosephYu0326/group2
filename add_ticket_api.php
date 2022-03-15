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

if(empty($_POST['Museum_id'])){
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$output['postData'] = $_POST;
$data = [
    ':id' => $_POST['Museum_id'],
    ':kind'=>$_POST['Museum_price_kind'],
    ':price' =>$_POST['Museum_ticket_price']
];

$sql = "INSERT INTO `museum_price`(`Museum_id`,`Museum_price_kind`,`Museum_ticket_price`) Values (:id, :kind, :price)";

$stmt = $pdo->prepare($sql);

foreach($data as $row){
    $stmt->execute(array($data));
}


$output['insertId'] = $pdo->lastInsertId(); 
$output['rowCount'] = $stmt->rowCount(); 
if($stmt->rowCount()){
    $output['error'] = '';
    $output['success'] = true;
}else{
    $output['error'] = '資料沒有新增成功';
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);