<?php
require __DIR__ . '../../parts/connect_db.php';
$title = '修改優惠圖片';
$pageName = 'discount_photo_edit';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "SELECT * FROM products_discount_photos WHERE discount_photo_id=$sid";
$row = $pdo->query($sql)->fetch();
if (empty($row)) {
    header('Location: discount_photo_list.php');
    exit;
}
?>

<?php include __DIR__ . '../../parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<?php include __DIR__ . '../../parts/nav.php'; ?>


<style>
    form .mb-3 .form-text {
        color: red;
    }
</style>

<div class="content-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">修改優惠圖片資訊</h5><br>
                        <form name="discount_photo_edit_form" method="post" novalidate onsubmit="checkForm(); return false;">
                            <input type="hidden" name="discount_photo_id" value="<?= $row['discount_photo_id'] ?>">
                            <div class="mb-3">
                                <label for="discount_photo_name" class="form-label">*圖片名稱</label>
                                <input type="text" class="form-control" id="discount_photo_name" name="discount_photo_name" required value="<?= htmlentities($row['discount_photo_name']) ?>">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <input type="text" style="display: none" class="form-control" id="discount_photos_url" name="discount_photos_url" required value="<?= htmlentities($row['discount_photos_url']) ?>">
                                <br>
                                <img src="" alt="" id="discount_photo_preview" width="200px">
                                <button type="button" class="btn btn-dark" onclick="discount_photo_update.click()">重新上傳圖片</button>
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3 d-grid gap-2">
                                    <button type="submit" class="btn btn-dark">修改</button>
                                </div>
                        </form>

                        <form name="discount_photo_update_form" onsubmit="return false;" style="display: none">
                            <input type="file" id="discount_photo_update" name="discount_photo_update" accept="image/jpeg,image/png">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '../../parts/scripts.php'; ?>
<script>
    function sendData() {
        const fd = new FormData(document.discount_photo_update_form);

        fetch('discount_photo_update.php', {
                method: 'POST',
                body: fd
            }).then(r => r.json())
            .then(obj => {
                console.log(obj);
                if (obj.success && obj.filename) {
                    discount_photo_preview.src = 'discount_imgs/' + obj.filename;
                    discount_photos_url.value = obj.filename;
                }
            });
    }
    discount_photo_update.onchange = sendData;

    function checkForm() {
        const fd = new FormData(document.discount_photo_edit_form);

        fetch('discount_photo_edit_api.php', {
                method: 'POST',
                body: fd
            }).then(r => r.json())
            .then(obj => {
                console.log(obj);
                if (obj.success) {
                    alert('修改成功');
                    location.href = 'discount_photo_list.php';
                } else {
                    alert('沒有修改');
                }
            })
    }
</script>
<?php include __DIR__ . '../../parts/html-foot.php'; ?>