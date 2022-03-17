<?php
require __DIR__. '/parts/connect_db.php';


$sql = "INSERT INTO `board_articles`(`title`, `content`,  `user_id`) 
VALUES (?,?,?)";

// $sql = "INSERT INTO `board_comments`(`content`, `parentid`, `user_id`, `board_article_id`) VALUES (?,?,?,?)";

// 避免SQL injection

$stmt = $pdo->prepare($sql);
for($i=0;$i<100;$i++){
    $stmt->execute([
        "這是文章標題".$i,
        "這是內文這是內文這是內文這是內文這是內文這是內文".$i,
        rand(1,3),
    ]);
}

// $stmt = $pdo->prepare($sql);
// for($i=0;$i<100;$i++){
//     $stmt->execute([
//         "這是留言".$i,
//         "0",
//         rand(1,3),
//         rand(0,59)
//     ]);
// }

echo $pdo->lastInsertId(); //拿到最新新增資料的primary key