<?php
require __DIR__ . '../../parts/connect_db.php';

$id = isset($_GET['article_id']) ? intval($_GET['article_id']) : 0; 

$sql = "DELETE FROM `blog_article` WHERE article_id= $id";

$stmt = $pdo->query($sql);

echo '刪除'.$stmt->rowCount().'篇文章';
if(! empty ($_SERVER['HTTP_REFERER'])){
    header('Location:'.$_SERVER['HTTP_REFERER']);
}else{
header('Location:Blog_home.php');
};
