<?php
require __DIR__ . '../../parts/connect_db.php';
$sid = isset($_GET['board_aid']) ? intval($_GET['board_aid']):0;

$sql = "SELECT count(*) FROM board_comments WHERE board_article_id = $sid";
$sql2 = "SELECT * FROM board_comments WHERE board_article_id = $sid";

$row = $pdo->query($sql)->fetch();
$row2 = $pdo->query($sql2)->fetchAll();

// foreach($row2 as $r){
//     print_r($r);
//     echo '<br>';
// }

foreach($row as $r){
    $num = $r;
}
if($num){
    // foreach($row2 as $r2){
    //     print_r($r2);
    //     echo '<br>';
    // }
    header('Location: board-comment-list.php?query=1&board_aidNum='.$sid);
} else {
    echo '無資料';
}

?>