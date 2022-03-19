<?php
require __DIR__ . '/parts/connect_db.php';
$title = '圖片列表';
$pageName = 'Museum_image_list';

$sid = isset($_GET['Museum_id']) ? intval($_GET['Museum_id']) : 0;
$image_id = isset($_GET['image_id']) ? intval($_GET['image_id']) : 0;
$sql1 = "SELECT Museum_name,Museum_id from museum_museum where Museum_id=$sid";

$row1 = $pdo->query($sql1)->fetch();

$perPage = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header("Location: image_list.php?Museum_id=$sid&page=1");
    exit;
}
$t_sql = "SELECT COUNT(1) FROM museum_images";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$rows = [];
if ($totalRows) {
    $totalPages = ceil($totalRows / $perPage);
    if ($page > $totalPages) {
        header("Location: image_list.php?Museum_id=$sid&page = $totalPages");
        exit;
    }
    $sql3 = sprintf(" SELECT * from museum_images where Museum_id=$sid order by image_id Limit %u,%u", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql3)->fetchAll();
}
$k=($page-1)*$perPage

?>
<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<?php include __DIR__ . '/parts/nav.php'; ?>
<style>
</style>

<div class="content-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title mt-3"><?= $row1['Museum_name'] ?>圖片
                            <button type="button" class=" float-end me-3 btn btn-dark" onclick="location.href='addimage.php?Museum_id=<?= $row1['Museum_id'] ?>'">新增圖片</button>
                        </h3>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                                    <a href="?Museum_id=<?= $sid?>&page=<?= $page - 1 ?>" class="page-link">
                                        <i class="fas fa-arrow-alt-circle-left"></i>
                                    </a>
                                </li>
                                <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                                    if ($i >= 1 and $i <= $totalPages) :
                                ?>
                                        <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                            <a class="page-link" href="?Museum_id=<?= $sid?>&page=<?= $i ?>"><?= $i ?></a>
                                        </li>
                                <?php endif;
                                endfor; ?>
                                <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                                    <a href="?Museum_id=<?= $sid?>&page=<?= $page + 1 ?>" class="page-link">
                                        <i class="fas fa-arrow-alt-circle-right"></i>
                                    </a>
                                </li>
                            </ul>
                    </div>

                    <div class="box-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <i class="fas fa-trash-alt"></i>
                                    </th>
                                    <th scope="sol">#</th>
                                    <th scope="sol">圖片</th>
                                    <th scope="col">
                                        <i class="fas fa-edit"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="number">
                                <?php foreach ($rows as $r) : ?>
                                    <?php $k=$k+1 ?>
                                    <tr>
                                        <td>
                                            <a href="javascript: del_it(<?= $r['image_id'] ?>)">
                                                <i class="fas fa-trash-alt"></i>
                                        </td>
                                        <td>
                                            <?= $k?>
                                        </td>
                                        <td>
                                            <img class="myimg img-thumbnail mx-auto d-block " src="./imgs/<?= $r['image_url'] ?>" alt="">
                                        </td>
                                        <td><a href="editimage.php?Museum_id=<?= $r['Museum_id'] ?>&image_id=<?= $r['image_id'] ?>">
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
        </div>
    </div>
</div>

<?php include __DIR__ . '/parts/scripts.php'; ?>
<script>
    // window.onload = function() {
    //     var tableLine = document.getElementById("number");
    //     for (var i = 0; i < tableLine.rows.length; i++) {
    //         tableLine.rows[i].cells[1].innerHTML = (i + 1);
    //     }
    // }

    function del_it(image_id) {
        if (confirm(`確定要刪除票號為${image_id}的資料嗎?`)) {
            location.href = 'image_delete.php?image_id=' + image_id;
        }
    }
</script>

<?php include __DIR__ . '/parts/html-foot.php'; ?>