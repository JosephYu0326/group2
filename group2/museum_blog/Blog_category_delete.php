<?php
require __DIR__ . '../../parts/connect_db.php';

$id = isset($_GET['sn']) ? intval($_GET['sn']) : 0; 

$sql = "DELETE FROM `blog_category` WHERE sn= $id";

$stmt = $pdo->query($sql);


if(! empty ($_SERVER['HTTP_REFERER'])){
    header('Location:'.$_SERVER['HTTP_REFERER']);
}else{
header('Location:Blog_category.php');
};