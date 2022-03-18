<?php
require __DIR__ . '/conect_DB.php';
$title = '修改分類';
$pageName = 'category';
$perPage = 12;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: Blog_category.php');
    exit;
}

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;


/*怪怪的操作
$sql1 = "SELECT * FROM blog_article
    JOIN `blog_category` 
    ON blog_article.category = blog_category.sn 
    JOIN `users` 
    ON blog_article.users_id = users.id
    WHERE sn=$sid";
*/

$sql1 = "SELECT * FROM blog_category
    WHERE sn=$sid";
$row = $pdo->query($sql1)->fetch();
if (empty($row)) {
    header('Location:Blog_category.php');
    exit;
}


$t_sql = "SELECT COUNT(1) FROM blog_category";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$rows = [];
$totalPages = 0;

if ($totalRows) {
    $totalPages = ceil($totalRows / $perPage);

    if ($page > $totalPages) {
        header("Location: Blog_home.php?page=$totalPages");
        exit;
    }
    $sql = sprintf("SELECT * FROM `blog_category` 
    ORDER BY squence ASC
    LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll();
}


?>
<?php include __DIR__ . '/Blog_part/html_blog_head.php'; ?>

<div class="content-wrapper d-flex flex-column">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>分類列表</h1>
                </div>
                <div class="col-sm-6">
                    <!-- <a class="btn btn-danger btn-bg" href="Blog_category_add.php">
                        <i class="fas fa-plus"></i>
                        新增分類
                    </a> -->
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="Blog_category.php">分類</a></li>
                        <li class="breadcrumb-item"><a href="Blog_home.php">文章</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="card container" style="height:80vh;">
        <div class="card-body p-0 row m-0">
            <div class="col-7">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 1%">#</th>
                            <th class="text-center" style="width: 10%">分類</th>
                            <th class="text-center" style="width: 10%">排序</th>
                            <th class="text-center" style="width: 20%">動作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $c) : ?>
                            <tr class="text-center">
                                <td><?= $c['sn'] ?></td>
                                <td><?= $c['thema'] ?></td>
                                <td><?= $c['squence'] ?></td>
                                <td class="category-actions">
                                    <a class="btn btn-primary btn-sm" href="#">
                                        <i class="fas fa-arrow-up"></i>
                                    </a>
                                    <a class="btn btn-primary btn-sm" href="#">
                                        <i class="fas fa-arrow-down"></i>
                                    </a>
                                    <a class="btn btn-info btn-sm" href="Blog_category_edit.php?sid=<?= $c['sn'] ?>">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a class="btn btn-danger btn-sm" href="Blog_category_delete.php?sn=<?= $c['sn'] ?>
                    " onclick="return confirm (`確定刪除「<?= $c['thema'] ?>」?`)">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="card-body p-0 col-5">
                <div class="card card-warning mt-5">
                    <div class="card-header">
                        <h3 class="card-title">修改分類</h3>
                    </div>
                    <form name="cateForm" method="post" onsubmit="checkForm(); return false;">
                    <input type="hidden" name="sn" value="<?= $row['sn'] ?>">    
                    <div class="card-body">
                            <div class="form-group">
                                <label for="thema">分類名稱</label>
                                <input type="text" class="form-control" name="thema" id="thema" value="<?= htmlentities($row['thema']) ?>" require>
                                <div style="color:red" class="form-text"></div>
                            </div>
                            <div class="form-group">
                                <label for="squence">排序</label>
                                <input type="number" class="form-control" name="squence" id="squence" value="<?= intval($row['squence']) ?>">
                                <div style="color:red" class="form-text"></div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">修改</button>
                        </div>
                    </form>
                </div>
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

<script>
    //新增分類
    const thema = document.cateForm.thema; // DOM element
    const thema_msg = thema.closest('div').querySelector('.form-text');

    function checkForm() {
        let isPass = true; // 有沒有通過檢查
        thema_msg.innerText = ''; // 清空訊息
        // TODO: 表單資料送出之前, 要做格式檢查
        if (thema.value.length < 1 ) {
            isPass = false;
            thema_msg.innerText = '標題過短，請重新輸入'
        }

        if (isPass) {
            const fd = new FormData(document.cateForm);
            fetch('Blog_category_edit-api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert('編輯成功');
                        location.href = 'Blog_category.php';
                    } 
                    else {
                        alert('編輯失敗');
                    }
                })
        }
    }
</script>

<?php include __DIR__ . '/Blog_part/nav.php'; ?>
<?php include __DIR__ . '/Blog_part/html_blog_foot.php'; ?>