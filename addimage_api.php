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
for($i=0; $i<count($_POST['Museum_id']);$i++){

    $output['postData'] = [
        [$_POST['Museum_id'][$i],$_POST['pic'][$i]]
    ];
    
    $sql2 = "INSERT INTO `museum_images`(`Museum_id`,`image_url`) Values(?,?)";
    
    $stmt = $pdo->prepare($sql2);
    
    $stmt->execute([
        $_POST['Museum_id'][$i] ?? '',
        $_POST['pic'][$i] ?? '',
    ]);
    
    
    $output['insertId'] = $pdo->lastInsertId(); 
    $output['rowCount'] = $stmt->rowCount(); 
    if($stmt->rowCount()){
        $output['error'] = '';
        $output['success'] = true;
    }else{
        $output['error'] = '資料沒有新增成功';
    }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);