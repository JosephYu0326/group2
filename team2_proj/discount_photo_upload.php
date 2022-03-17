<?php

// 過濾檔案並且決定副檔名
$exts = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
];

// 要輸出的訊息
$output = [
    'success' => false,
    'error' => '',
    'filename' => '',
];

if (empty($_FILES) or empty($_FILES['discount_photo'])) {
    $output['error'] = '沒有上傳檔案';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

// 判斷是不是我們要的類型
$ext = $exts[$_FILES['discount_photo']['type']];
if (empty($ext)) {
    $output['error'] = '檔案類型錯誤';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$output['filename'] = sha1(uniqid(). $_FILES['discount_photo']['name']). $ext;

if (
    move_uploaded_file(
        $_FILES['discount_photo']['tmp_name'],
        __DIR__. '/'. '/discount_imgs/'. $output['filename']
        )
) {
    $output['success'] = true;
} else {
    $output['error'] = '無法搬動檔案';
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
