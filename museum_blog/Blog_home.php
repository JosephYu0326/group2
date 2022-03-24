<?php
require __DIR__ . '../../parts/connect_db.php';
$title = '文章列表';
$pageName = 'home';
$perPage = 6;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: Blog_home.php');
    exit;
}


$t_sql = "SELECT COUNT(1) FROM blog_article";
// "SELECT * FROM `blog_article` JOIN `blog_category` ON blog_article.category = blog_category.sn";


$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$rows = [];
$totalPages = 0;

if ($totalRows) {
    $totalPages = ceil($totalRows / $perPage);

    if ($page > $totalPages) {
        header("Location: Blog_home.php?page=$totalPages");
        exit;
    }
    $sql = sprintf("SELECT * FROM `blog_article` 
    LEFT JOIN `blog_category` 
    ON blog_article.category = blog_category.sn	 
    JOIN `users` 
    ON blog_article.users_id = users.id 
    ORDER BY blog_article.article_id 
    DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll();
}

?>

<?php include __DIR__ . '/Blog_part/html_blog_head.php'; ?>

<div class="content-wrapper d-flex flex-column h-100">
    <!-- 麵包屑 -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>文章列表</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-danger btn-bg" href="Blog_add.php">
                        <i class="fas fa-plus"></i>
                        新增文章
                    </a>
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="Blog_category.php">分類</a></li>
                        <li class="breadcrumb-item active">文章</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- 文章列表 -->
    <section class="content" style="height:85vh;">

        <div class="card" style="height:80vh;">

            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th style="width: 1%">#</th>
                            <th style="width: 10%">分類</th>
                            <th style="width: 20%">標題</th>
                            <th style="width: 20%">內文</th>
                            <th style="width: 8%">作者</th>
                            <th style="width: 8%">狀態</th>
                            <th style="width: 10%">動作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $status = isset($_POST['visible']) ? intval($_POST['visible']) : 0;
                        ?>
                        <?php foreach ($rows as $r) : ?>
                            <tr>
                                <td><?= $r['article_id'] ?></td>
                                <td><?php
                                    if ($r['category'] == NULL) : ?>
                                        未分類
                                    <?php else : ?>
                                        <?= $r['thema'] ?></td>
                            <?php endif; ?>
                            <td><?= $r['title'] ?></td>
                            <td>
                                <div style="height:10vh; overflow:hidden;"><?= $r['content'] ?></div>
                            </td>
                            <td><?= $r['username'] ?></br><?= $r['nickname'] ?></td>
                            <td class="article-status">
                                <?php
                                if ($r['visible'] == 0) : ?>
                                    <span class="badge badge-danger">Offline</span>
                                <?php else : ?>
                                    <span class="badge badge-success">Online</span>
                                <?php endif; ?>
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="Blog_view.php?sid=<?= $r['article_id'] ?>">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-info btn-sm" href="Blog_edit.php?sid=<?= $r['article_id'] ?>">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                </a>
                                <a class="btn btn-danger btn-sm" href="Blog_delete.php?article_id=<?= $r['article_id'] ?>
                            " onclick="return confirm (`確定刪除「<?= $r['title'] ?>」?`)">
                                    <i class="fas fa-trash">
                                    </i>
                                </a>
                            </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

        </div>

    </section>
    <!-- 頁碼 -->
    <div class="coontainer align-self-center">
        <div class="row">
            <div class="col">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item <? $page == $i ? 'disable' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        </li>
                        <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                            if ($i >= 1 and $i <= $totalPages) :
                        ?>
                                <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                        <?php endif;
                        endfor; ?>
                        <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page + 1 ?>">
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>






<!--SIDE-->
<?php include __DIR__ . '../../parts/nav.php'; ?>

<?php include __DIR__ . '../../parts/html-foot.php'; ?>