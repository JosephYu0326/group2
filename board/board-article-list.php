<?php
require __DIR__ . '/parts/connect_db.php';
$title = '文章列表';
$pageName = 'board-article-list';

$orderby = isset($_GET['order']) ? intval($_GET['order']) : 0; //  排序
$queryArticle = isset($_GET['query']) ? intval($_GET['query']) : 0; // 是否從留言板過來
$board_aidNum = isset($_GET['board_aidNum']) ? intval($_GET['board_aidNum']) : 0; // 留言找文章編號
$search = isset($_GET['search']) ? strval($_GET['search']) : 0; // 搜尋關鍵字


$perPage = 5; // 每一頁最多5筆資料
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // 用戶要看的頁碼
if ($page < 1) {
    header('Location: board-article-list.php?page=1');
    exit;
}


$t_sql = "SELECT COUNT(1) FROM board_articles"; // 取得總筆數
if($board_aidNum){
    $t_sql = "SELECT COUNT(1) FROM board_articles WHERE board_aid = $board_aidNum";
}
if($search){
    $t_sql = "SELECT COUNT(1) FROM board_articles WHERE content LIKE '%$search%'";
}

$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$rows = []; // 預設沒有資料
$AtotalPages = 0;



if ($totalRows) {
    // 總頁數
    $AtotalPages = ceil($totalRows / $perPage);
    if ($page > $AtotalPages) {
        header("Location: board-article-list.php?page=$AtotalPages");
        exit;
    }

    if($orderby){ //升冪
        $sql = sprintf("SELECT * FROM board_articles
        LEFT JOIN users ON users.id = board_articles.user_id
        LEFT JOIN board_photos ON board_articles.board_aid = board_photos.board_article_id
        ORDER BY board_aid LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    } else { //降冪(預設)
        $sql = sprintf("SELECT * FROM board_articles
        LEFT JOIN users ON users.id = board_articles.user_id
        LEFT JOIN board_photos ON board_articles.board_aid = board_photos.board_article_id
        ORDER BY board_aid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    }

    if($search){ // 搜尋
        $pagevar=($page - 1) * $perPage; // 每頁變數(搜尋用)
        $sql = "SELECT * FROM board_articles
        LEFT JOIN users ON users.id = board_articles.user_id
        LEFT JOIN board_photos ON board_articles.board_aid = board_photos.board_article_id
        WHERE (`content` like '%$search%')
        ORDER BY board_aid DESC LIMIT $pagevar, $perPage";
        
    }
    if ($queryArticle) { //是否從留言板過來
        $sql = "SELECT * FROM board_articles
        LEFT JOIN users ON users.id = board_articles.user_id
        LEFT JOIN board_photos ON board_articles.board_aid = board_photos.board_article_id
        WHERE board_aid = $board_aidNum";
    }

    $rows = $pdo->query($sql)->fetchAll();

}

$eachpage = 10; // 一次有幾頁
$k = $totalRows - ($page - 1) * 5;
// $k = ($page-1)*5;

?>

<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/html-navbar.php'; ?>

<style>
    .myimg {
        width: 100%;
    }

    td {
        width: 100％;
    }
</style>

<div class="content-wrapper">
    <div class="content">
        <div class="row">
            <div class="col">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>"><i class="fas fa-arrow-alt-circle-left"></i></a>
                        </li>

                        <?php
                        $i =  $page;

                        if ($i % $eachpage == 0) { //取餘數
                            $pagelevel = $i / $eachpage;
                            $pagepoint_start = $i - $eachpage + 1;
                            $pagepoint_end = $i;
                        } else {
                            $pagelevel = floor($i / $eachpage);
                            $pagepoint_start = $pagelevel * $eachpage + 1;
                            $pagepoint_end = ($pagelevel + 1) * $eachpage;
                        }
                        $pagestart = $pagepoint_start;
                        $pageend = $pagepoint_end;

                        for ($i = $pagestart; $i <= $pageend; $i++) :
                            if ($i >= 1 and $i <= $AtotalPages) :

                        ?>
                                <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i?>&search=<?=$search?>"><?= $i ?></a>
                                </li>
                        <?php endif;
                        endfor; ?>
                        <li class="page-item <?= $page == $AtotalPages ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= $page + 1 ?>"><i class="fas fa-arrow-alt-circle-right"></i></a></li>
                    </ul>
                </nav>
            </div>
        </div>



        <div class="d-flex justify-content-between">
            <form action="board-article-list.php" method="GET">
                <input id="search" type="text" placeholder="Type here" name="search">
                <input id="submit" type="submit" value="Search">
            </form>
            
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Order
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="board-article-list.php?order=1">Ascending</a></li>
                    <li><a class="dropdown-item" href="board-article-list.php?order=0">Descending</a></li>
                </ul>
            </div>
        </div>



        <div class="row py-2">
            <div class="col">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col"><i class="fas fa-search"></i></th>
                            <th scope="col">
                                index
                            </th>

                            <th scope="col">aid</th>
                            <th scope="col">Title</th>
                            <th scope="col">Content</th>
                            <th scope="col">Image</th>
                            <th scope="col">UserId</th>
                            <th scope="col">Nickname</th>
                            <!-- <th scope="col">CreateTime</th>
                        <th scope="col">UpdateTime</th> -->
                            <th scope="col"><i class="fas fa-comment-dots"></i></th>
                            <th scope="col"><i class="fas fa-edit"></i></th>
                            <th scope="col"><i class="fas fa-trash-alt"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $r) : ?>
                            <tr>
                                <td>
                                    <a href="board-comment-query.php?board_aid=<?= $r['board_aid'] ?>">
                                        <i class="fas fa-search"></i>
                                    </a>
                                </td>
                                <td><?= $k ?></td>
                                <td><?= $r['board_aid'] ?></td>
                                <td><?= $r['title'] ?></td>
                                <td><?= strip_tags($r['content']) ?></td>
                                <td><img class="myimg" src="/board/image/<?= $r['img'] ?>" alt=""></td>
                                <td><?= $r['user_id'] ?></td>
                                <td><?= $r['nickname'] ?></td>
                                <!-- <td><?= $r['created_at'] ?></td>
                            <td><?= $r['updated_at'] ?></td> -->
                                <td>
                                    <a href="board-comment-add.php?board_aid=<?= $r['board_aid'] ?>">
                                        <i class="fas fa-comment-dots"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="board-article-edit.php?board_aid=<?= $r['board_aid'] ?>&board_pid=<?= $r['board_pid'] ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    <?php /*
                                <a href="ab-delete.php?sid=<?= $r['sid'] ?>" onclick="return confirm(`確定要刪除編號為<?= $r['sid'] ?>的資料嗎？`)">
                                */ ?>
                                    <a href="javascript: del_it(<?= $r['board_aid'] ?>)">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                                <?php $k = $k - 1; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/parts/html-scripts.php'; ?>
<script>
    function del_it(board_aid) {
        if (confirm(`確定要刪除編號為 ${board_aid} 的資料嗎?`)) {
            location.href = 'board-article-delete.php?board_aid=' + board_aid;
        }
    };
</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>