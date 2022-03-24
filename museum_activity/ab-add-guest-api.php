<?php
require __DIR__ . '../../parts/connect_db.php';

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




$sql = "INSERT INTO  `activity_guest`(
     `Activity_Guest_Name`, `Activity_Guest_Job_Title`, `Activity_Guest_Img`, `Activity_Guest_Company_name`, `Activity_Guest_Profiles`, `Activity_Guest_URL`,`fk_Activity_id` 
    ) VALUES (?,?,?,?,?,?,?)";



$stmt = $pdo->prepare($sql);


$stmt->execute([
    $_POST['name'],
    $_POST['Profession'] ?? null,
    $_POST['img'] ?? NULL,
    $_POST['company'] ?? null,
    $_POST['a-url'] ?? null,
    $_POST['text'] ?? null,
    $_POST['Activity_id'] ?? null,
   
]);

$output['insertId'] = $pdo->lastInsertId(); // 取得最近加入資料的 PK
$output['rowCount'] = $stmt->rowCount(); // 新增資料的筆數
if($stmt->rowCount()){
    $output['error'] = '';
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有新增成功';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);

