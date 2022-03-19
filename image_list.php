<?php
require __DIR__ . '/parts/connect_db.php';
$title = '圖片列表';
$pageName = 'Museum_image_list';

$sid = isset($_GET['Museum_id']) ? intval($_GET['Museum_id']) : 0;
$image_id = isset($_GET['image_id']) ? intval($_GET['image_id']) : 0;
$sql = "SELECT * from museum_images where Museum_id=$sid";
$sql1 = "SELECT Museum_name,Museum_id from museum_museum where Museum_id=$sid";
$sql2 = "SELECT * from museum_images where image_id=$image_id";

$row = $pdo->query($sql)->fetchAll();
$row1 = $pdo->query($sql1)->fetch();
$row2 = $pdo->query($sql2)->fetchAll();
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
                                <?php foreach ($row as $r) : ?>
                                    <tr>
                                        <td>
                                        <a href="javascript: del_it(<?= $r['image_id']?>)">
                                            <i class="fas fa-trash-alt"></i>
                                        </td>
                                        <td>

                                        </td>
                                        <td>
                                        <img class="myimg img-thumbnail mx-auto d-block " src="./imgs/<?= $r['image_url']?>" alt="">
                                        </td>
                                        <td><a href="editimage.php?Museum_id=<?= $row1['Museum_id'] ?>&image_id=<?= $r['image_id'] ?>">
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
    function del_it(image_id){
        if(confirm(`確定要刪除票號為${image_id}的資料嗎?`)){
            location.href = 'image_delete.php?image_id=' + image_id;
        }
    }

</script>

<?php include __DIR__ . '/parts/html-foot.php'; ?>