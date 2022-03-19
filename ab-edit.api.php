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

$output['postData'] = $_POST;  // 讓前端做資料查看,資料是否一致


if( empty($_POST['name']) or empty($_POST['Activity_id'])){
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}




// TODO: 欄位檢查

$sql = "UPDATE `activity` SET 
`Activity_Name`=?,
`Activity_Img`=?,
`Activity_Star_Time`=?,
`Activity_End_Time`=?,
`Activity_Place`=?,
`Activity_Links`=?,
`Activity_Introduction`=?,
`Activity_Text`=?,
`fk_Activity_Types_id`=?,
`fk_Activity_Organizers_id`=?
 WHERE `Activity_id`=?";

$stmt = $pdo->prepare($sql);


$stmt->execute([
    $_POST['name'],
    $_POST['pic'] ?? NULL,
    $_POST['s-time'] ?? '',
    $_POST['e-time'] ?? '',
    $_POST['place'] ?? NULL,
    $_POST['a-url'] ?? '',
    $_POST['intro'] ?? '',
    $_POST['text'] ?? null,
    $_POST['Activity_Types_id'] ?? NULL,
    $_POST['fk_Activity_Organizers_id'] ?? NULL,
    $_POST['Activity_id'] ,

]);
 

$output['rowCount'] = $stmt->rowCount(); // 新增資料的筆數
if($stmt->rowCount()){
    $output['error'] = '';
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有修改';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);

