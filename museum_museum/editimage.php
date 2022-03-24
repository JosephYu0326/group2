<?php
$title = 'Edit image';
$pageName = 'Edit image';
require_once '/xampp/htdocs/group2/parts/connect_db.php';
$sid = isset($_GET['Museum_id']) ? intval($_GET['Museum_id']) : 0;
$image_id = isset($_GET['image_id']) ? intval($_GET['image_id']) : 0;


$sql = "select Museum_id,Museum_name from museum_museum";
$sql1 = "SELECT Museum_id,Museum_name from museum_museum where Museum_id=$sid";
$sql2 = "SELECT * from museum_images where image_id=$image_id";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();
} catch (Exception $ex) {
    echo ($ex->getMessage());
}
$row = $pdo->query($sql1)->fetchAll();
$row1 = $pdo->query($sql2)->fetch();
?>


<?php include __DIR__ . '../../parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<?php include __DIR__ . '../../parts/nav.php'; ?>

<div class="content-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="statusMsg"></div>
                        <h3 class="box-title mt-3">修改圖片</h3>
                    </div>
                    <div class="box-body">
                        <form name="form1" method="post" novalidate onsubmit="checkForm(); return false;">
                            <div class="main-form">
                                <div class="col-lg-6 mt-3 ">
                                    <div class="form-group">
                                        <label for="museum_name" class="form-label">館名</label>
                                        <select name="Museum_id" id="Museum_id" class="form-select">
                                            <?php foreach ($row as $c) { ?>
                                                <option selected value="<?= $c["Museum_id"] ?>"><?= $c["Museum_name"] ?></option>
                                            <?php } ?>
                                            <option>-- select Museum --</option>
                                            <?php foreach ($results as $output) { ?>
                                                <option value="<?= $output["Museum_id"] ?>"><?= $output["Museum_name"] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <div class="form-text"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" id="pic" name="pic" required value="<?= htmlentities($row1['image_url']) ?>">
                                <img src="<?= empty($row1['image_url']) ? '' : './imgs/' . $row1['image_url'] ?>" alt="" id="myimg" class="img-fluid mb-3 mx-auto d-block">
                                <button class="btn btn-danger" type="button" onclick='location.href="javascript:remove()"'>刪除照片</button>
                                <button class="btn btn-dark" type="button" onclick="avatar.click()">上傳照片</button>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" class="form-control" id="image_id" name="image_id" required value="<?= htmlentities($row1['image_id']) ?>">
                            </div>
                            <div class="mb-3 d-grid gap-2">
                                <button type="submit" class="btn btn-dark">修改</button>
                            </div>
                        </form>
                        <form name="image_form" onsubmit="return false;" style="display: none;">
                            <input type="file" id="avatar" name="avatar" accept="image/*">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '../../parts/scripts.php'; ?>
<script>
    function remove(){
        if(confirm(`確定要刪除此圖片嗎?`)){
            $('#pic').attr('value', '');
            $('#myimg').attr('src', '');
        }
    }
</script>
<script>
    function checkForm() {

        let isPass = true;
        //TODO: 表單資料送出之前，要做格式檢查


        if (isPass) {

            const fd = new FormData(document.form1);


            fetch('editimage_api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert('修改成功');
                        location.href = 'image_list.php?Museum_id=<?= $c["Museum_id"] ?>';
                    } else {
                        alert('修改失敗');
                    }
                })

        }
    }
</script>
<script>
    const avatar = document.querySelector('#avatar');

function sendData() {
    const fd2 = new FormData(document.image_form);

    fetch('upload_edit.php', {
            method: 'POST',
            body: fd2
        }).then(r => r.json())
        .then(obj => {
            if (obj.success && obj.filename) {
                myimg.src = './imgs/' + obj.filename;
                pic.value = obj.filename;
            }
        })
}
avatar.onchange = sendData;
</script>
<?php include __DIR__ . '../../parts/html-foot.php'; ?>