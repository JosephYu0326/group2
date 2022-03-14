<?php
require __DIR__ . '/parts/connect_db.php';

$sid = isset($_GET['Museum_id']) ? intval($_GET['Museum_id']): 0;

$sql = "DELETE FROM `museum_museum` WHERE Museum_id = $sid";

$stmt = $pdo->query($sql);

// echo $stmt -> rowCount(); //刪除幾筆
if(!empty($_SERVER['HTTP_REFERER'])){
    //從哪裡來回哪裡去
    header('Location:'. $_SERVER['HTTP_REFERER']);
}else{

    header('location: museum_list.php');
}
