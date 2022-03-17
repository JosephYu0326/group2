<?php
require __DIR__. '/parts/connect_db.php';

$id = isset($_GET['board_cid'])? intval($_GET['board_cid']):0;

$sql = "DELETE FROM `board_comments` WHERE board_cid = $id";

$stmt = $pdo->query($sql);

echo $stmt->rowCount();

if($_SERVER['HTTP_REFERER']){
    // 從哪裡來回哪裡去
    header('Location:'.$_SERVER['HTTP_REFERER']);
} else {
    header("Location: board-comment-list.php");
}

