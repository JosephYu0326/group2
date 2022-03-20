<?php
require __DIR__ . '/parts/connect_db.php';
$title = '票價列表';
$pageName = 'Museum_ticket_list';

$sid = isset($_GET['Museum_id']) ? intval($_GET['Museum_id']) : 0;
$ticket_id = isset($_GET['Museum_ticket_id']) ? intval($_GET['Museum_ticket_id']) : 0;

$sql = "SELECT museum_price_kind,Museum_ticket_price,Museum_ticket_id from museum_price where Museum_id=$sid";
$sql1 = "SELECT Museum_name,Museum_id from museum_museum where Museum_id=$sid";
$sql2 = "SELECT museum_price_kind,Museum_ticket_price,Museum_ticket_id from museum_price where Museum_ticket_id=$ticket_id";

$row = $pdo->query($sql)->fetch();
$rows = $pdo->query($sql)->fetchAll();
$row1 = $pdo->query($sql1)->fetch();
$row2 = $pdo->query($sql2)->fetchAll();
// if (empty($row)) {
//     header('Location: museum_list.php');
//     exit;
// }


?>
<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<?php include __DIR__ . '/parts/nav.php'; ?>

<div class="content-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title mt-3"><?= $row1['Museum_name'] ?>票價
                            <button type="button" class=" float-end me-3 btn btn-dark" onclick="location.href='add_ticket.php?Museum_id=<?= $row1['Museum_id'] ?>'">新增票種</button>
                        </h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <i class="fas fa-trash-alt"></i>
                                    </th>
                                    <th scope="sol">#</th>
                                    <th scope="sol">票種</th>
                                    <th scope="sol">票價</th>
                                    <th scope="col">
                                        <i class="fas fa-edit"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="number">
                                <?php foreach ($rows as $r) : ?>
                                    <tr>
                                        <td>
                                        <a href="javascript: del_it(<?= $r['Museum_ticket_id']?>)">
                                            <i class="fas fa-trash-alt"></i>
                                        </td>
                                        <td>

                                        </td>
                                        <td>
                                            <?= $r['museum_price_kind'] ?>
                                        </td>
                                        <td>
                                            <?= $r['Museum_ticket_price'] ?>
                                        </td>
                                        <td><a href="edit_ticket.php?Museum_id=<?= $row1['Museum_id'] ?>&Museum_ticket_id=<?= $r['Museum_ticket_id'] ?>">
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
    window.onload = function() {
        var tableLine = document.getElementById("number");
        for (var i = 0; i < tableLine.rows.length; i++) {
            tableLine.rows[i].cells[1].innerHTML = (i + 1);
        }
    }
    function del_it(Museum_ticket_id){
        if(confirm(`確定要刪除票號為${Museum_ticket_id}的資料嗎?`)){
            location.href = 'ticket_delete.php?Museum_ticket_id=' + Museum_ticket_id;
        }
    }

</script>

<?php include __DIR__ . '/parts/html-foot.php'; ?>