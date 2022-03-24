<?php 
require




$first = [];
// 把第一層的資料放到陣列
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

// 有加& 兩層可以這樣寫
// 三層不行
// 輸出
// echo json_encode($first);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  

<!-- php 生 json 就是js -->
<select name="first" id="first"></select>
    <?php foreach($first as $f):?>
        <?php foreach($first as $f):?>
            <option value="">
            <!-- 第二層就不能把值寫死在這裡 他會因為一層去抽換內容 -->
        </php>
    </php>


    <Script>
        // for of 字串一個個 加起來
    </Script>
</body>
</html>