<?php
require __DIR__ . '../../parts/connect_db.php';
$title = '商品清單';
$pageName = 'products_list';

$perPage = 5; // 每一頁有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; //用戶要看的頁碼
if ($page < 1) {
    header('Location: products_list.php?page=1');
    exit;
}


$t_sql = "SELECT * FROM products_sale LEFT JOIN products_sale_photo ON products_sale.product_id = products_sale_photo.product_sale_id ORDER BY product_id DESC";

// 取得總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$rows = []; //預設沒有資料
$totalPages = 0;


if ($totalRows) {
    // 總頁數
    $totalPages = ceil($totalRows / $perPage);
    if ($page > $totalPages) {
        header("Location: products_list.php?page=$totalPages");
        exit;
    }
}


$sql = sprintf("SELECT * FROM products_sale LEFT JOIN products_sale_photo ON products_sale.product_id = products_sale_photo.product_sale_id ORDER BY product_id DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
$rows = $pdo->query($sql)->fetchAll(); // 拿到分頁資料


?>

<?php include __DIR__ . '../../parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<?php include __DIR__ . '../../parts/nav.php'; ?>

<style>
    .myimg {
        width: 75%;
    }
</style>

<div class="content-wrapper">
    <div class="content">
        <div class="row">
            <div class="co-xs-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination mt-3 justify-content-end">
                        <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>">
                                <i class="fas fa-arrow-alt-circle-left"></i>
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
                                <i class="fas fa-arrow-alt-circle-right"></i>
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
                        <th scope="col">商品圖片</th>
                        <th scope="col">商品名稱</th>
                        <th scope="col">商品簡介</th>
                        <th scope="col">商品完整介紹</th>
                        <th scope="col">商品相關故事</th>
                        <th scope="col">商品規格</th>
                        <th scope="col">建議售價</th>
                        <th scope="col">優惠售價</th>
                        <th scope="col">庫存量</th>
                        <th scope="col">商品類別</th>
                        <th scope="col">商品地點</th>
                        <th scope="col">
                            <i class="fas fa-edit"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) :  ?>
                        <tr>
                            <td>
                                <a href="javascript: del_it(<?= $r['product_id'] ?>)">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>

                            <td><?= $r['product_id'] ?></td>
                            <td><img class="myimg" id="myImg" onerror='this.style.display = "none"' src="./images/<?= $r['sale_photo_url'] ?>"></td>
                            <td><?= $r['product_name'] ?></td>
                            <td><?= $r['product_intro'] ?></td>
                            <td><?= $r['product_main'] ?></td>
                            <td><?= $r['product_more_info'] ?></td>
                            <td><?= $r['product_size'] ?></td>
                            <td><?= $r['product_orign_price'] ?></td>
                            <td><?= $r['product_price'] ?></td>
                            <td><?= $r['product_store_quantity'] ?></td>
                            <td><?= $r['product_category'] ?></td>
                            <td><?= $r['product_location'] ?></td>

                            <td>
                                <a href="products_edit.php?sid=<?= $r['product_id'] ?>">
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
            location.href = 'products_delete.php?sid=' + sid;
        }
    }
</script>
<?php include __DIR__ . '../../parts/html-foot.php'; ?>