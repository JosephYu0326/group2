<?php
require __DIR__. '/parts/connect_db.php';

$id = isset($_GET['board_pid'])? intval($_GET['board_pid']):0;

$sql = "DELETE FROM `board_photos` WHERE board_pid = $id";

$stmt = $pdo->query($sql);

echo $stmt->rowCount();

if($stmt->rowCount()){
    header("Location: board-article-edit.php");
} else {
    header("Location: board-article-edit.php");
}

