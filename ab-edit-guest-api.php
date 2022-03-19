<?php
require __DIR__ . '/parts/connect_db.php';

header('Content-Type: application/json');
// 輸出的資料格式
$output = [
    'success' => false,
    'error' => '沒有表單資料',
    'code' => 0,
    'postData' => [],
    'rowCount' => 0,
];
$output['postData'] = $_POST;  // 讓前端做資料查看,資料是否一致

if(empty($_POST['name']) or empty($_POST['Activity_Guest_id'])){
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}


// TODO: 欄位檢查

$sql = "UPDATE `activity_guest` SET 
`Activity_Guest_Name`=?,
`Activity_Guest_Job_Title`=?,
`Activity_Guest_Img`=?,
`Activity_Guest_Company_name`=?,
`Activity_Guest_Profiles`=?,
`Activity_Guest_URL`=?,
`fk_Activity_id`=?
 WHERE `Activity_Guest_id`=?";

$stmt = $pdo->prepare($sql);


$stmt->execute([
    $_POST['name'],
    $_POST['img'] ?? NULL,
    $_POST['Profession'] ?? null,
    $_POST['company'] ?? null,
    $_POST['a-url'] ?? null,
    $_POST['text'] ?? null,
    $_POST['fk_Activity_id'] ?? null,
    $_POST['Activity_Guest_id'],
]);

$output['rowCount'] = $stmt->rowCount(); // 修改資料的筆數
if($stmt->rowCount()){
    $output['error'] = '';
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有修改';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);

