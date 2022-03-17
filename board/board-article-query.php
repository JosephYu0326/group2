<?php
require __DIR__ . '/parts/connect_db.php';
$sid = isset($_GET['board_aid']) ? intval($_GET['board_aid']):0;


$sql = "SELECT count(*) FROM board_articles WHERE board_aid = $sid";
$sql2 = "SELECT * FROM board_articles WHERE board_aid = $sid";


$row = $pdo->query($sql)->fetch();
$row2 = $pdo->query($sql2)->fetch();

foreach($row as $r){
    $num = $r;
}
if($num){
    // foreach($row2 as $r2){
    //     print_r($r2);
    //     echo '<br>';
    // }
    header('Location: board-article-list.php?query=1&board_aidNum='.$sid);
} else {
    echo '無資料';
}

?>