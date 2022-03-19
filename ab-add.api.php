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


// $_SESSION['activity_form1'] = $_POST;

// $output['success'] = true;
// echo json_encode($output);
// exit;

// TODO: 欄位檢查

$sql = "INSERT INTO `activity`(
     `Activity_Name`, `Activity_Img`, `Activity_Star_Time`, `Activity_End_Time`, `Activity_Place`, `Activity_Links`, `Activity_Introduction`, `Activity_Text`,`fk_Activity_Types_id`, `fk_Activity_Organizers_id`
    ) VALUES (?,?,?,?,?,?,?,?,?,?)";

$stmt = $pdo->prepare($sql);


$stmt->execute([
    $_POST['name'],
    $_POST['pic'] ?? NULL,
    $_POST['s-time'] ?? '',
    $_POST['e-time'] ?? '',
    $_POST['place'] ?? '',
    $_POST['a-url'] ?? '',
    $_POST['intro'] ?? null,
    $_POST['text'] ?? NULL,
    $_POST['Activity_Types_id'] ?? NULL,
    $_POST['fk_Activity_Organizers_id'] ?? NULL,
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



