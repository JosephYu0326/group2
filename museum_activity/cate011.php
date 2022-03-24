<?php
require __DIR__ . '/parts/connect_db.php';

$stmt = $pdo->query("SELECT * FROM categories");
$raw_data = $stmt->fetchAll();

$first = [];

// 把第一層的資料放到陣列裡
foreach($raw_data as $r){
    if($r['parent_sid']==0){
        $first[] = $r;
    }
}

// 把第二層的資料放到陣列裡
foreach($first as &$f){
    foreach($raw_data as $r){
        if($f['sid']==$r['parent_sid']){
            $f['children'][] = $r;
        }
    }
}

echo json_encode($first);