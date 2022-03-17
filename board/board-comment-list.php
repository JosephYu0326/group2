<?php
require __DIR__ . '/parts/connect_db.php';
// require __DIR__ . '/board-article-list.php';
$title = '留言列表';
$Apages = $_SESSION['Apages'];

$queryNum = isset($_GET['query']) ? intval($_GET['query']):0;
$board_aidNum = isset($_GET['board_aidNum']) ? intval($_GET['board_aidNum']):-1;

$pageName = 'board-comment-list';

$perPage = 5; // 每一頁最多5筆資料
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // 用戶要看的頁碼
if ($page < 1) {
    header('Location: board-comment-list.php?page=1');
    exit;
}


$t_sql = "SELECT COUNT(1) FROM board_comments";
// 取得總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$rows = []; // 預設沒有資料
$CtotalPages = 0;

if ($totalRows) {
    // 總頁數
    $CtotalPages = ceil($totalRows / $perPage);

    if ($page > $CtotalPages) {
        header("Location: board-comment-list.php?page=$CtotalPages");
        exit;
    }
    if($queryNum){
        $sql = "SELECT * FROM board_articles
        JOIN board_comments
        ON board_comments.board_article_id = board_articles.board_aid
        WHERE board_article_id = $board_aidNum";
        $rows = $pdo->query($sql)->fetchAll(); // 拿到分頁資料
    } else {
        $sql = sprintf("SELECT * FROM board_comments
        ORDER BY board_cid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
        $rows = $pdo->query($sql)->fetchAll(); // 拿到分頁資料
    }


}
$eachpage = 10; // 一次有幾頁
?>

<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/html-navbar.php'; ?>
<div class="content-wrapper">
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?=$page==1 ? 'disabled':'' ?>">
                        <a class="page-link" href="?page=<?=$page-1?>"><i class="fas fa-arrow-alt-circle-left"></i></a>
                    </li>
                    <?php
                        $pagestart = $page;
                        $i = $pagestart;
                        
                        if($i<=10){
                            $pagestart = 1;
                            $pageend = 10;
                        } else {
                            if($i%$eachpage==0){
                                $pagelevel = $i/10;
                                $pagepoint_start = $i-$eachpage+1;
                                $pagepoint_end = $i;
                            } else {
                                $pagelevel = floor($i/$eachpage);
                                $pagepoint_start = $pagelevel*$eachpage+1;
                                $pagepoint_end = ($pagelevel+1)*$eachpage;
                            }
                            $pagestart = $pagepoint_start;
                            $pageend = $pagepoint_end;
                            
                        }

                        for($i=$pagestart;$i<=$pageend;$i++):
                            if($i>=1 and $i<=$CtotalPages):
                        
                    ?>
                    <li class="page-item <?=$page==$i ? 'active':'' ?>">
                        <a class="page-link" href="?page=<?= $i?>"><?= $i?></a>
                    </li>
                    <?php endif;endfor; ?>
                    <li class="page-item <?=$page==$CtotalPages ? 'disabled':'' ?>"><a class="page-link" href="?page=<?= $page+1?>"><i class="fas fa-arrow-alt-circle-right"></i></a></li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="row py-2">
        <div class="col">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col"><i class="fas fa-trash-alt"></i></th>
                        <th scope="col">#</th>
                        <th scope="col">Content</th>
                        <th scope="col">UserId</th>
                        <th scope="col">BoardArticleId</th>
                        <th scope="col">ParentId</th>
                        <th scope="col">CreateTime</th>
                        <th scope="col">UpdateTime</th>
                        <th scope="col"><i class="fas fa-edit"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td>
                                <?php /*
                                <a href="ab-delete.php?sid=<?= $r['sid'] ?>" onclick="return confirm(`確定要刪除編號為<?= $r['sid'] ?>的資料嗎？`)">
                                */ ?>
                                <a href="javascript: del_it(<?= $r['board_cid']?>)">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                            <td><?= $r['board_cid'] ?></td>
                            <td><?= strip_tags($r['content']) ?></td>
                            <td><?= $r['user_id'] ?></td>
                            <td>
                                <a href="board-article-query.php?board_aid=<?=$r['board_article_id']?>">
                                    <?= $r['board_article_id'] ?>
                                </a>
                            </td>
                            <td><?= $r['parentid'] ?></td>
                            <td><?= $r['created_at'] ?></td>
                            <td><?= $r['updated_at'] ?></td>
                            <td>
                                <a href="board-comment-edit.php?board_cid=<?= $r['board_cid']?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>

            </table>
        </div>
    </div>
</div>
<?php include __DIR__ . '/parts/html-scripts.php'; ?>
<script>
    function del_it(board_cid){
    if(confirm(`確定要刪除編號為 ${board_cid} 的資料嗎?`)){      
        location.href = 'board-comment-delete.php?board_cid=' + board_cid;
    }
    
}
</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>
