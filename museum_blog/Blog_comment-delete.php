<?php
require __DIR__ . '../../parts/connect_db.php';

$id = isset($_GET['blog_comment_id']) ? intval($_GET['blog_comment_id']) : 0; 

$sql = "DELETE FROM `blog_comment` WHERE blog_comment_id= $id";

$stmt = $pdo->query($sql);


if(! empty ($_SERVER['HTTP_REFERER'])){
    header('Location:'.$_SERVER['HTTP_REFERER']);
}else{
header('Location:Blog_view.php');
};