<?php
require __DIR__ . '/parts/connect_db.php';
$title = '活動主列表';
$pageName = 'ab-list';
$perPage = 5; // 每一頁有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;  // 用戶要看的頁碼
if ($page < 1) {
    header('Location: ab-list.php?page=1');
    exit;
}

$t_sql = "SELECT COUNT(1) FROM activity";
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

    //試試看的
    // $sql2 = sprintf("SELECT * FROM activity  
    // JOIN activity_guest
    // ON activity_guest.fk_Activity_id = activity.Activity_id
    // ORDER BY Activity_id");
    // $rows2 = $pdo->query($sql2)->fetchAll();


    // $sql = sprintf("SELECT * FROM activity 
    // -- JOIN activity_organizers
    // -- ON activity.fk_Activity_Organizers_id = activity_organizers.Activity_Organizers_id;
    // ORDER BY Activity_id
    // DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    // $rows = $pdo->query($sql)->fetchAll(); // 拿到分頁資料

    $sql = sprintf(
    "SELECT activity.*,activity_guest.Activity_Guest_Name ,Activity_Organizers_Name,Activity_Organizers_id, ticket_name,Activity_Types_Name 
    FROM activity  
       left JOIN activity_guest
       ON activity_guest.fk_Activity_id = activity.Activity_id
       left join activity_organizers
       on activity.fk_Activity_Organizers_id =activity_organizers.Activity_Organizers_id
       left join activity_ticket
       on activity_ticket.fk_Activity_id =activity.Activity_id
       left join activity_types
       on activity.fk_Activity_Types_id =activity_types.Activity_Types_id
       ORDER BY Activity_id
    DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll(); // 拿到分頁資料
}

?>
<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?= $page==1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page-1 ?>">
                            <i class="fas fa-arrow-alt-circle-left"></i>
                        </a>
                    </li>
                    <?php for($i=$page-5; $i<=$page+5; $i++): 
                        if($i>=1 and $i<=$totalPages):
                        ?>
                    <li class="page-item <?= $page==$i ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                    <?php endif; endfor; ?>
                    <li class="page-item <?= $page==$totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page+1 ?>">
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
                        <th scope="col">活動名稱</th>
                        <th scope="col">活動圖片</th>
                        <th scope="col">開始時間</th>
                        <th scope="col">結束時間</th>
                        <th scope="col">活動地點</th>
                        <th scope="col">活動網址</th>
                        <th scope="col">活動簡介</th>
                        <th scope="col">詳細介紹</th>
                        <th scope="col">活動類型</th>
                        <th scope="col">主辦單位</th>
                        <th scope="col">嘉賓</th>
                        <th scope="col">票價類型名稱</th> 
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
                                <a href="javascript: del_it(<?= $r['Activity_id'] ?>)">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                            <td><?= $r['Activity_id'] ?></td>
                            <td><?= $r['Activity_Name'] ?></td>
                            <td><img src="/Team2_museum/imgs/<?= $r['Activity_Img'] ?>" alt="" width="200px"></td>
                            <td><?= $r['Activity_Star_Time'] ?></td>
                            <td><?= $r['Activity_End_Time'] ?></td>
                            <td><?= $r['Activity_Place'] ?></td>
                            <td><?= $r['Activity_Links'] ?></td>
                            <td><?= strip_tags($r['Activity_Introduction']) ?></td>
                            <td><?= $r['Activity_Text'] ?></td>
                            <td><?= $r['Activity_Tag_name'] ?></td>
                            <td><?= $r['Activity_Organizers_Name'] ?></td>
                            <td><?= $r['Activity_Guest_Name'] ?></td>
                            <td><?= $r['ticket_name'] ?></td>
                          
                            

                            <!--把字符轉換為HTML 實體
                            <td><?= htmlentities($r['address']) ?></td>
                            -->
                            <!-- 
                                剝去字符串中的HTML 標籤
                                <td><?= strip_tags($r['address']) ?></td> -->
                            <td>
                                <a href="ab-edit.php?sid=<?= $r['Activity_id'] ?>">
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
    function del_it(Activity_id){
        if(confirm(`確定要刪除編號為 ${Activity_id} 的資料嗎?`)){

            location.href = 'ab-delete.php?sid=' + Activity_id;
        }

    }


</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>