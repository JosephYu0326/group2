<?php
require __DIR__ . '../../parts/connect_db.php';
$title = '會員列表';
$pageName = 'ab-list';
$perPage = 5; // 每一頁有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;  // 用戶要看的頁碼
if ($page < 1) {
    header('Location: ab-list.php?page=1');
    exit;
}

$t_sql = "SELECT COUNT(1) FROM users";
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

    $sql = sprintf("SELECT * FROM users ORDER BY id DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll(); // 拿到分頁資料
}

?>
<?php include __DIR__ . '../../parts/html-head.php'; ?>
<?php include __DIR__ . '../../parts/nav.php'; ?>
<?php include __DIR__ . './parts/navbar.php'; ?>
<div class=" content-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination mt-3 justify-content-end">
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
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">Password</th>
                            <th scope="col">Email</th>
                            <th scope="col">Name</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Address</th>
                            <th scope="col">Nickname</th>
                            <th scope="col">Avatar</th>
                            <th scope="col">Birthday</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Created_at</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $r) : ?>
                            <!--foreach迴圈，對於陣列中的每一個元素都做下面的事情-->
                            <tr>
                                <!--縮寫 <td><?= $r['id'] ?></td> -->
                                <td><?php echo $r['id'] ?></td>
                                <td><?php echo $r['username'] ?></td>
                                <td><?php echo substr(password_hash($r['password'], PASSWORD_BCRYPT), 0, 10) ?></td>
                                <td><?php echo $r['email'] ?></td>
                                <td><?php echo $r['name'] ?></td>
                                <td><?php echo $r['mobile'] ?></td>
                                <!--不解讀html的標籤，直接印出來
                            <td><?php echo htmlentities($r['address']) ?></td>
                            -->
                                <td><?php echo strip_tags($r['address']) ?></td>
                                <!--刪除字串中html的標籤-->
                                <td><?php echo $r['nickname'] ?></td>
                                <td>
                                    <!-- <?php echo $r['avatar'] ?> -->
                                    <!-- <img style= "height: 50px" src="./imgs/<?php echo $r['avatar'] ?>"></td> -->
                                    <?php
                                    $avatar_img = '<img style= "height: 50px" src="./imgs/' . $r['avatar'] . '">';
                                    if ($r['avatar'] == '') {
                                        echo '';
                                    } else {
                                        echo $avatar_img;
                                    }
                                    ?>
                                </td>
                                <td><?php echo $r['birthday'] ?></td>
                                <td>
                                    <?php
                                    if ($r['gender'] == 1) {
                                        echo '女';
                                    } else if ($r['gender'] == 2) {
                                        echo '男';
                                    } else {
                                        echo '不公開';
                                    }
                                    ?>
                                </td>
                                <td><?php echo $r['created_at'] ?></td>
                                <td>
                                    <a href="ab-edit.php?id=<?= $r['id'] ?>">
                                        <!--連結到ab-edit.php這支php，用get的方式傳遞id給ab-edit.php-->
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    <?php /*
                                <a href="ab-delete.php?id=<?= $r['id'] ?>" onclick="return confirm(`確定要刪除編號為 <?= $r['id'] ?> 的資料嗎?`)">
                                */ ?>
                                    <a href="javascript: del_it(<?= $r['id'] ?>)">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                        <!--迴圈終止-->
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
</div>

</div>
<?php include __DIR__ . '../../parts/scripts.php'; ?>
<script>
    function del_it(id) {
        if (confirm(`確定要刪除編號為 ${id} 的資料嗎?`)) {

            location.href = 'ab-delete.php?id=' + id;
        }
    }
</script>
<?php include __DIR__ . '../../parts/html-foot.php'; ?>