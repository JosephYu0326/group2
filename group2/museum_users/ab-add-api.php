<?php
require __DIR__ . '../../parts/connect_db.php';

header('Content-Type: application/json'); //使用header表頭函式定義文件的Content-Type頁面編碼方式

// 後端輸出到前端的key value資料格式
$output = [
    'success' => false,
    'error' => '沒有表單資料',
    'code' => 0,
    'postData' => [], // postData是一個array
    'insertId' => 0,
    'rowCount' => 0,
    'filename' => '',
];

// 如果username為空就離開程式
if(empty($_POST['username'])){
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$output['postData'] = $_POST;  // 讓前端做資料查看，資料是否一致

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

// 連接sql資料庫
// 把資料insert到sql的users table
$sql = "INSERT INTO `users`(
    `username`, `password`, `email`, `name`,
    `mobile`, `address`, `nickname`, `avatar`,
    `birthday`, `gender`, `created_at`
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_POST['username'], // username一定有東西，因為前端檢查為必填選項，所以
    $_POST['password'],
    $_POST['email'],
    $_POST['name'] ?? '', // 從前端用POST方法收到name的value，如果有東西的話顯示??內容，若沒東西則顯示空字串
    $_POST['mobile'] ?? '',
    $_POST['address'] ?? '',
    $_POST['nickname'] ?? '',
    $output['filename'] ?? '',
    empty($_POST['birthday']) ? null : $_POST['birthday'],
    empty($_POST['gender']) ? 0 : intval($_POST['gender']),
]);

$output['insertId'] = $pdo->lastInsertId(); // 取得最近加入資料的PK
$output['rowCount'] = $stmt->rowCount(); // 新增資料的筆數
if($stmt->rowCount()){
    $output['error'] = '';
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有新增成功';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE); //後端把$output這個東西轉成json檔案交換格式回傳到前端

