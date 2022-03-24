<?php
require __DIR__ . '../../parts/connect_db.php';
$title = '商品照庫';
$pageName = 'sale_photo_list';

$perPage = 5; // 每一頁有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; //用戶要看的頁碼
if ($page < 1) {
    header('Location: sale_photo_list.php?page=1');
    exit;
}


$t_sql = "SELECT * FROM products_sale_photo";

// 取得總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$rows = []; //預設沒有資料
$totalPages = 0;


if ($totalRows) {
    // 總頁數
    $totalPages = ceil($totalRows / $perPage);
    if ($page > $totalPages) {
        header("Location: sale_photo_list.php?page=$totalPages");
        exit;
    }
}


$sql = sprintf("SELECT * FROM products_sale_photo ORDER BY sale_photo_id DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
$rows = $pdo->query($sql)->fetchAll(); // 拿到分頁資料


?>

<?php include __DIR__ . '../../parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<?php include __DIR__ . '../../parts/nav.php'; ?>

<style>
    .myimg {
        width: 35%;
    }
</style>

<div class="content-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-xs-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end mt-3">
                        <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>">
                                <i class="far  fa-arrow-alt-circle-left"></i>
                            </a>
                        </li>


                        <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                            if ($i >= 1 and $i <= $totalPages) : ?>
                                <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                        <?php endif;
                        endfor;  ?>


                        <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page + 1 ?>">
                                <i class="far  fa-arrow-alt-circle-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="box-body">

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">
                            <i class="fas fa-trash-alt"></i>
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">商品編號</th>
                        <th scope="col">商品照預覽</th>
                        <th>
                            <i class="fas fa-edit"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) :  ?>
                        <tr>
                            <td>
                                <a href="javascript: del_it(<?= $r['sale_photo_id'] ?>)">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                            <td><?= $r['sale_photo_id'] ?></td>
                            <td><?= $r['product_sale_id'] ?></td>
                            <td><img class="myimg" src="./images/<?= $r['sale_photo_url'] ?>"></td>
                            <td>
                                <a href="sale_photo_edit.php?sid=<?= $r['sale_photo_id'] ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach  ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php include __DIR__ . '../../parts/scripts.php'; ?>
<script>
    function del_it(sid) {

        if (confirm(`確定要刪除編號為 ${sid}的資料嗎?`)) {
            location.href = 'sale_photo_delete.php?sid=' + sid;
        }
    }
</script>
<?php include __DIR__ . '../../parts/html-foot.php'; ?>