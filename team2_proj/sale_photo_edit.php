<?php
require __DIR__ . '/parts/connect_db.php';
$title = '修改商品圖片';
$pageName = 'sale_photo_edit';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "SELECT * FROM products_sale_photo WHERE sale_photo_id=$sid";
$row = $pdo->query($sql)->fetch();
if (empty($row)) {
    header('Location: sale_photo_list.php');
    exit;
}
?>

<?php include __DIR__ . '/parts/html_head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<?php include __DIR__ . '/parts/aside.php'; ?>


<style>
    form .mb-3 .form-text {
        color: red;
    }
</style>

<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">修改商品圖資訊</h5><br>
                    <form name="form_sale_photo_edit" method="post" novalidate onsubmit="checkForm(); return false;">
                        <input type="hidden" name="sale_photo_id" value="<?= $row['sale_photo_id'] ?>">
                        <div class="mb-3">
                            <label for="sale_photo_name" class="form-label">*圖片名稱</label>
                            <input type="text" class="form-control" id="sale_photo_name" name="sale_photo_name" required value="<?= htmlentities($row['sale_photo_name']) ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="sale_photo_url" class="form-label">*圖片檔名</label>
                            <input type="text" class="form-control" id="sale_photo_url" name="sale_photo_url" required value="<?= htmlentities($row['sale_photo_url']) ?>">
                            <br>
                            <img src="" alt="" id="sale_photo_preview" width="200px">
                            <button type="button" onclick="sale_photo_update.click()">重新上傳圖片</button>
                            <div class="form-text"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">修改</button>
                    </form>

                    <form name="sale_photo_update_form" onsubmit="return false;" style="display: none">
                        <input type="file" id="sale_photo_update" name="sale_photo_update" accept="image/jpeg,image/png">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/parts/scripts.php'; ?>
<script>
    function sendData() {
        const fd = new FormData(document.sale_photo_update_form);

        fetch('sale_photo_update.php', {
                method: 'POST',
                body: fd
            }).then(r => r.json())
            .then(obj => {
                console.log(obj);
                if (obj.success && obj.filename) {
                    sale_photo_preview.src = 'images/' + obj.filename;
                    sale_photo_url.value = obj.filename;
                }
            });
    }
    sale_photo_update.onchange = sendData;

    function checkForm() {
        let isPass = true; // 有沒有通過檢查

        /*

        name_msg.innerText = ''; // 清空訊息
        mobile_msg.innerText = ''; // 清空訊息

        // TODO: 表單資料送出之前, 要做格式檢查

        if (name.value.length < 2) {
            isPass = false;
            name_msg.innerText = '請填寫正確的姓名'
        }

        const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/; // new RegExp()

        if (mobile.value) {
            // 如果不是空字串就檢查格式
            if (!mobile_re.test(mobile.value)) {
                mobile_msg.innerText = '請輸入正確的手機號碼';
                isPass = false;
            }
        }

        */

        if (isPass) {
            const fd = new FormData(document.form_sale_photo_edit);

            fetch('sale_photo_edit_api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert('修改成功');
                        location.href = 'sale_photo_list.php';
                    } else {
                        alert('沒有修改');
                    }
                })
        }
    }
</script>
<?php include __DIR__ . '/parts/html_foot.php'; ?>