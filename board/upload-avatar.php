<?php

// 過濾檔案並決定副檔名
$exts = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
];


$output =[
    'success'=>false,
    'error'=>'',
    'filename'=>'',
];


if(empty($_FILES) or empty($_FILES['avatar'])){
    $output['error'] = '沒有上傳檔案';
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
    exit;
}

// 判斷是不是我們要的類型
$ext = $exts[ $_FILES['avatar']['type']];
if(empty($ext)){
    $output['error'] = '檔案類型錯誤';
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
    exit;
}

$output['filename'] = sha1(uniqid().$_FILES['avatar']['name']). $ext;


if(
    move_uploaded_file(
        $_FILES['avatar']['tmp_name'],
        __DIR__. '/0303/'. $output['filename']
        )
){
    $output['success'] = true;
} else {
    $output['error'] = '無法搬動檔案';
}





echo json_encode($output,JSON_UNESCAPED_UNICODE);


