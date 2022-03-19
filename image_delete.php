<?php
require __DIR__ . '/parts/connect_db.php';

$sid = isset($_GET['Museum_id']) ? intval($_GET['Museum_id']): 0;
$image_id = isset($_GET['image_id']) ? intval($_GET['image_id']) : 0;

$sql1 = "DELETE FROM `museum_images` WHERE image_id = $image_id";


$stmt1 = $pdo->query($sql1);

// echo $stmt -> rowCount(); //刪除幾筆
if(!empty($_SERVER['HTTP_REFERER'])){
    //從哪裡來回哪裡去
    header('Location:'. $_SERVER['HTTP_REFERER']);
}else{

    header('location: image_list.php');
}
