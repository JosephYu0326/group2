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

$output['postData'] =  $_POST;
if(empty($_POST['Museum_ticket_id'])){
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$sql = "UPDATE `museum_price` SET `Museum_id`=?,`Museum_price_kind`=?,`Museum_ticket_price`=? WHERE `museum_price`.`Museum_ticket_id` = ?";

    

$stmt = $pdo->prepare($sql);
        


    $stmt->execute([
        $_POST['Museum_id'] ?? '',
        $_POST['Museum_price_kind'] ?? '',
        $_POST['Museum_ticket_price'] ?? '',
        $_POST['Museum_ticket_id'],

    ]);


    $output['rowCount'] = $stmt->rowCount(); 
    if($stmt->rowCount()){
        $output['error'] = '';
        $output['success'] = true;
    }else{
        $output['error'] = '資料沒有新增成功';
    }

echo json_encode($output, JSON_UNESCAPED_UNICODE);




