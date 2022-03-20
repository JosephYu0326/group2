<?php
require __DIR__ . '/parts/connect_db.php';
$title = '活動主列表';
$pageName = 'ab-list-types';
$perPage = 5; // 每一頁有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;  // 用戶要看的頁碼
if ($page < 1) {
    header('Location: ab-list.php?page=1');
    exit;
}

$t_sql = "SELECT COUNT(1) FROM activity_types";
// 取得總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];





$rows = []; // 預設沒有資料
$totalPages = 0;
if ($totalRows) {
    // 總頁數
    $totalPages = ceil($totalRows / $perPage);
    if ($page > $totalPages) {
        header("Location: ab-list.php?page=$totalPages");
        exit;
    }

    $sql = sprintf("SELECT * FROM activity_types ORDER BY Activity_Types_id  DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll(); // 拿到分頁資料
}

?>
<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>

<div class="content-wrapper">
    <div class="container">

    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">
                            <i class="fas fa-arrow-alt-circle-left"></i>
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
                            <i class="fas fa-arrow-alt-circle-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>


    <div class="row">
        <div class="col">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">
                            <i class="fas fa-trash-alt"></i>
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">活動類型名稱</th>

                        <th scope="col">
                            <i class="fas fa-edit"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td>
                                <?php /*
                                <a href="ab-delete.php?sid=<?= $r['sid'] ?>" onclick="return confirm(`確定要刪除編號為 <?= $r['sid'] ?> 的資料嗎?`)">
                                */ ?>
                                <a href="javascript: del_it(<?= $r['sid'] ?>)">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                            <td><?= $r['Activity_Types_id'] ?></td>
                            <td><?= $r['Activity_Types_Name'] ?></td>

                            
                            <!-- <td><?= htmlentities($r['address']) ?></td>
                           
                            <td><?= strip_tags($r['address']) ?></td> -->

                            <td>
                                <a href="ab-edit-types.php?Activity_Types_id=<?= $r['Activity_Types_id'] ?>">
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










    <?php include __DIR__ . '/parts/scripts.php'; ?>
    <script>
        function del_it(Activity_Types_id) {
            if (confirm(`確定要刪除編號為 ${Activity_Types_id} 的資料嗎?`)) {

                location.href = 'ab-delete-types.php?Activity_Types_id=' + Activity_Types_id;
            }

        }
    </script>
    <?php include __DIR__ . '/parts/html-foot.php'; ?>