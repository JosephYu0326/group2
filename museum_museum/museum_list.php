<?php
require __DIR__ . '../../parts/connect_db.php';
$title = '美術館列表';
$pageName = 'Museum';
$perPage = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: museum_list.php?page=1');
    exit;
}
$t_sql = "SELECT COUNT(1) FROM museum_museum";

$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$rows = [];
$totalPages = 0;
if ($totalRows) {
    $totalPages = ceil($totalRows / $perPage);
    if ($page > $totalPages) {
        header("Location: museum_list.php?page = $totalPages");
        exit;
    }

    $sql = sprintf("SELECT Museum_id,Museum_name,Museum_direction,Museum_city,Museum_kind,Museum_features,Museum_introduce,Museum_booking_notice,Museum_more_information from museum_museum join museum_location on museum_location.museum_location_id = museum_museum.museum_location_id join museum_kind on museum_kind.museum_kind_id = museum_museum.museum_kind_id join museum_direction on museum_direction.museum_direction_id = museum_location.museum_direction_id join museum_city on museum_city.museum_city_id = museum_location.museum_city_id order by Museum_id desc Limit %u,%u", ($page - 1) * $perPage, $perPage);

    $rows = $pdo->query($sql)->fetchAll();
}
$k=($page-1)*$perPage


?>
<?php include __DIR__ . '../../parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<?php include __DIR__ . '../../parts/nav.php'; ?>
<div class="content-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header d-flex">
                        <h3 class="box-title mt-3 me-auto ">美術館</h3>
                            <ul class="pagination mt-3">
                                <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                                    <a href="?page=<?= $page - 1 ?>" class="page-link">
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
                                    <a href="?page=<?= $page + 1 ?>" class="page-link">
                                        <i class="fas fa-arrow-alt-circle-right"></i>
                                    </a>
                                </li>
                            </ul>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <i class="fas fa-trash-alt"></i>
                                    </th>
                                    <th scope="col">#</th>
                                    <th scope="col">館名</th>
                                    <th scope="col">位置</th>
                                    <th scope="col">城市</th>
                                    <th scope="col">類別</th>
                                    <th scope="col">特色</th>
                                    <th scope="col">介紹</th>
                                    <th scope="col">購票須知</th>
                                    <th scope="col">更多資訊</th>
                                    <th scope="col">票價查詢</th>
                                    <th scope="col">圖片查詢</th>
                                    <th scope="col">
                                        <i class="fas fa-edit"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows as $r) : ?>
                                    <?php $k=$k+1 ?>
                                    <tr>
                                        <td>
                                            <a href="javascript: del_it(<?= $r['Museum_id']?>)">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                        <td><?= $k?></td>
                                        <td><?= $r['Museum_name'] ?></td>
                                        <td><?= $r['Museum_direction'] ?></td>
                                        <td><?= $r['Museum_city'] ?></td>
                                        <td><?= $r['Museum_kind'] ?></td>
                                        <td><button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#myModal-<?= strip_tags($r['Museum_features']) ?>"><?= $r['Museum_name'] ?>特色</button>
                                            <div class="modal fade" id="myModal-<?= strip_tags($r['Museum_features']) ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"><?= $r['Museum_name'] ?>-特色</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?= $r['Museum_features'] ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#myModal-<?= strip_tags($r['Museum_introduce']) ?>"><?= $r['Museum_name'] ?>介紹</button>
                                            <div class="modal fade" id="myModal-<?= strip_tags($r['Museum_introduce']) ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"><?= $r['Museum_name'] ?>-介紹</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?= $r['Museum_introduce'] ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#myModal-<?= strip_tags($r['Museum_booking_notice']) ?>"><?= $r['Museum_name'] ?>購票須知</button>
                                            <div class="modal fade" id="myModal-<?=strip_tags($r['Museum_booking_notice']) ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"><?= $r['Museum_name'] ?>-購票須知</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?= $r['Museum_booking_notice'] ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#myModal-<?= strip_tags($r['Museum_more_information']) ?>"><?= $r['Museum_name'] ?>更多資訊</button>
                                            <div class="modal fade" id="myModal-<?= strip_tags($r['Museum_more_information']) ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"><?= $r['Museum_name'] ?>-更多資訊</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?= $r['Museum_more_information'] ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class=" btn btn-secondary" onclick="location.href='museum_ticket_list.php?Museum_id=<?= $r['Museum_id'] ?>'">查詢<?= $r['Museum_name'] ?>票價</button>
                                        </td>
                                        <td>
                                            <button type="button" class=" btn btn-secondary" onclick="location.href='image_list.php?Museum_id=<?= $r['Museum_id'] ?>'">查詢<?= $r['Museum_name'] ?>圖片</button>
                                        </td>
                                        <td>
                                            <a href="edit_museum.php?Museum_id=<?= $r['Museum_id'] ?>">
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

<?php include __DIR__ . '../../parts/scripts.php'; ?>
<script>
    function del_it(Museum_id){
        if(confirm(`確定要刪除此美術館嗎?`)){
            location.href = 'museum_delete.php?Museum_id=' + Museum_id;
        }
    }
</script>
<?php include __DIR__ . '../../parts/html-foot.php'; ?>