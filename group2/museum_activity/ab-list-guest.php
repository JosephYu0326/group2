<?php
require __DIR__ . '../../parts/connect_db.php';
$title = '嘉賓列表';
$pageName = 'ab-list-guest';
$perPage = 5; // 每一頁有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;  // 用戶要看的頁碼
if ($page < 1) {
    header('Location: ab-list.php?page=1');
    exit;
}

$t_sql = "SELECT COUNT(1) FROM activity_guest";
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

    $sql = sprintf("SELECT * FROM activity_guest ORDER BY Activity_Guest_id  DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll(); // 拿到分頁資料
}

?>
<?php include __DIR__ . '../../parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<?php include __DIR__ . '../../parts/nav.php'; ?>
<div class="content-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination  justify-content-end mt-3">
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


            <div class="box-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">
                                <i class="fas fa-trash-alt"></i>
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">嘉賓姓名</th>
                            <th scope="col">嘉賓職業</th>
                            <th scope="col">嘉賓圖片</th>
                            <th scope="col">嘉濱公司</th>
                            <th scope="col">嘉賓資料介紹</th>
                            <th scope="col">嘉賓社群網址</th>

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
                                    <a href="javascript: del_it(<?= $r['Activity_Guest_id'] ?>)">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                                <td><?= $r['Activity_Guest_id'] ?></td>
                                <td><?= $r['Activity_Guest_Name'] ?></td>
                                <td><?= $r['Activity_Guest_Job_Title'] ?></td>

                                <td><img src="./imgs/<?= $r['Activity_Guest_Img'] ?>" alt="" width="200px"></td>

                                <td><?= $r['Activity_Guest_Company_name'] ?></td>
                                <td><?= $r['Activity_Guest_URL'] ?></td>
                                <td><?= $r['Activity_Guest_Profiles'] ?></td>

                                <!--
                            <td><?= htmlentities($r['address']) ?></td>
                            -->
                                <!-- <td><?= strip_tags($r['address']) ?></td> -->

                                <td>
                                    <a href="ab-edit-guest.php?Activity_Guest_id=<?= $r['Activity_Guest_id'] ?>">
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
<?php include __DIR__ . '../../parts/scripts.php'; ?>
<script>
    function del_it(Activity_Guest_id) {
        if (confirm(`確定要刪除編號為 ${Activity_Guest_id} 的資料嗎?`)) {

            location.href = 'ab-delete-guest.php?Activity_Guest_id=' + Activity_Guest_id;
        }

    }
</script>
<?php include __DIR__ . '../../parts/html-foot.php'; ?>