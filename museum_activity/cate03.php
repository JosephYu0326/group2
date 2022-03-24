<?php
require __DIR__ . '/parts/connect_db.php';

$stmt = $pdo->query("SELECT * FROM categories ORDER BY sid DESC");
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
    <form action="">

    <select name="first" id="first" data-sid="2">
    </select>

    <select name="second" id="second" data-sid="7">
    </select>


    </form>
    

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    const cateData = <?= json_encode($first, JSON_UNESCAPED_UNICODE) ?>;
    const first = $('#first');
    const second = $('#second');

    let str = '';
    for(let cate of cateData){
       str += `<option value="${cate.sid}">${cate.name}</option>`
    }
    first.html(str); // 呈現第一層
    first.val(first.attr('data-sid'));
    
    function genCate2(p_id){
        let pCate = [];

        // Array.filter()
        for(let cate of cateData){
            if(cate.sid==p_id){
                pCate = cate;
                break;
            }
        }

        let str = '';
        if(pCate.children && pCate.children.length)
            for(let c2 of pCate.children) {
                str += `<option value="${c2.sid}">${c2.name}</option>`
            }
        second.html(str);
    }
    genCate2(first.val()); // 呈現第二層
    second.val(second.attr('data-sid'));

    first.on('change', function(){
        genCate2(first.val());
    });


</script>
</body>
</html>