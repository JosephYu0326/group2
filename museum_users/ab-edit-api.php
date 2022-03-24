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
    'filename' => '',
];

// 如果id或username為空就離開
if(empty($_POST['id']) or empty($_POST['username'])){
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$output['postData'] = $_POST;  // 讓前端做資料查看,資料是否一致

if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {  // 如果有上傳圖片
    // 判斷圖片是不是我們要的檔案格式
    if ($_FILES['avatar']['type'] == 'image/jpeg') // 如果圖片的檔案類型為jpeg
        $ext = '.jpg'; // $ext為.jpg
    elseif ($_FILES['avatar']['type'] == 'image/png') // 如果圖片的檔案類型png
        $ext = '.png'; // $ext為.png
    else
        $ext = ''; //其他則顯示空字串

    if (empty($ext)) { //如果$ext為空
        $output['error'] = '檔案類型錯誤';
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;        
    } else {
        $output['filename'] = sha1(uniqid().$_FILES['avatar']['name']).$ext; // 圖片檔名(sha1為雜湊)
        move_uploaded_file(
            $_FILES['avatar']['tmp_name'], // 取得上傳檔案暫存名稱
            __DIR__.'/imgs/'. $output['filename'] // 目的路徑及檔名
        );
    }
}

$sql = "UPDATE `users` SET  
        `username`=?,
        `password`=?,
        `email`=?,
        `name`=?,
        `mobile`=?,
        `address`=?,
        `nickname`=?,
        `avatar`=?,
        `birthday`=?,
        `gender`=?
        WHERE `id`=?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_POST['username'],
    $_POST['password'],
    $_POST['email'] ?? '',
    $_POST['name'],
    $_POST['mobile'] ?? '',
    $_POST['address'] ?? '',
    $_POST['nickname'] ?? '',
    $output['filename'] ?? '',
    empty($_POST['birthday']) ? null : $_POST['birthday'],
    empty($_POST['gender']) ? 0 : intval($_POST['gender']),
    $_POST['id'],
]);


$output['rowCount'] = $stmt->rowCount(); // 修改資料的筆數
if($stmt->rowCount()){
    $output['error'] = '';
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有修改';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);

