<?php
require __DIR__ . '/parts/connect_db.php';

header('Content-Type: application/json');
// 輸出的資料格式
$output = [
    'success' => false,
    'error' => '沒有表單資料',
    'code' => 0,
    'postData' => [],
    'insertId' => 0,
    'rowCount' => 0,
];

if(empty($_POST['name'])){
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$output['postData'] = $_POST;  // 讓前端做資料查看,資料是否一致

// TODO: 欄位檢查

$sql = "INSERT INTO `activity_ticket`( 
    `ticket_name`,
    `ticket_price`,
    `Activity_ticket_description`,
    `Activity_ticket_Star_Time`,
    `Activit_ticket_End_Time`,
    `Valid_start_time`, 
    `Valid_End_time` 
) VALUES (?,?,?,?,?,?,?)";
//`fk_Activity_id`

$stmt = $pdo->prepare($sql);


$stmt->execute([
    $_POST['name'],
    $_POST['price'] ?? '',
    $_POST['text'] ?? null,
    $_POST['start'] ?? '',
    $_POST['end'] ?? '',
    $_POST['startTime'] ?? '',
    $_POST['endTime'] ?? '',
    
]);
// $_POST['fk_Activity_id'] ?? '',

$output['insertId'] = $pdo->lastInsertId(); // 取得最近加入資料的 PK
$output['rowCount'] = $stmt->rowCount(); // 新增資料的筆數
if($stmt->rowCount()){
    $output['error'] = '';
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有新增成功';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);

