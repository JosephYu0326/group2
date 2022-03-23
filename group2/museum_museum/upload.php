<?php

$exts = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
];


$countfiles = count($_FILES['avatar']['type']);

for($i =0; $i<$countfiles ; $i++){
    $output[$i] = [
        'success' => false,
        'error' => '',
        'filename' => '',
    ];
    if(empty($_FILES) or empty($_FILES['avatar'])){
        $output[$i]['error'] = '沒有上傳檔案';
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    // 判斷是不是我們要的類型
    $ext = $exts[ $_FILES['avatar']['type'][$i] ];
    if(empty($ext)){
        $output['error'] = '檔案類型錯誤';
        echo json_encode($output[$i], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    $output[$i]['filename'] = sha1(uniqid(). $_FILES['avatar']['name'][$i]). $ext;
    
    if(
        move_uploaded_file(
            $_FILES['avatar']['tmp_name'][$i], 
            __DIR__. '/imgs/'. $output[$i]['filename']
            )
    ){
        $output[$i]['success'] = true;
    } else {
        $output[$i]['error'] = '無法搬動檔案';
    }
}
echo json_encode($output, JSON_UNESCAPED_UNICODE);

