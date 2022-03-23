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

$ext = $exts[$_FILES['avatar']['type']];

$output['filename'] = sha1(uniqid().$_FILES['avatar']['name']). $ext;


move_uploaded_file(
    $_FILES['avatar']['tmp_name'],
    __DIR__. '/image/'. $output['filename']
);

$output['success'] = true;
echo json_encode($output,JSON_UNESCAPED_UNICODE);


