<?php
require __DIR__ . '../../parts/connect_db.php';
$title = '新增優惠圖';
$pageName = 'discount_photo_add';

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
                        <h5 class="card-title">新增優惠圖片</h5><br><br>
                        <form name="discount_photo_add_form" method="post" novalidate onsubmit="checkForm(); return false;">

                            <div class="mb-3">
                                <label for="discount_photo_name" class="form-label">圖片名稱</label>
                                <input type="text" class="form-control" id="discount_photo_name" name="discount_photo_name">
                                <br>
                                <input type="text" class="form-control" style="display: none" id="discount_photos_url" name="discount_photos_url">
                                <br>
                                <img src="" alt="" id="discount_photo_preview" width="200px">
                                <button type="button" class="btn btn-dark" onclick="discount_photo.click()">上傳優惠圖片</button>
                                <div class="form-text"></div>
                            </div>
                            <br>
                            <div class="mb-3 d-grid gap-2">
                                    <button type="submit" class="btn btn-dark">新增</button>
                                </div>
                        </form>

                        <form name="discount_photo_form" onsubmit="return false;" style="display: none">
                            <input type="file" id="discount_photo" name="discount_photo" accept="image/jpeg,image/png">
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
        const fd = new FormData(document.discount_photo_form);

        fetch('discount_photo_upload.php', {
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
    discount_photo.onchange = sendData;

    function checkForm() {
        let isPass = true; // 有沒有通過檢查

        /*name_msg.innerText = ''; // 清空訊息
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
            const fd = new FormData(document.discount_photo_add_form);

            fetch('discount_photo_add_api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert('新增成功');
                        location.href = 'discount_photo_list.php';
                    } else {
                        alert('新增失敗');
                    }
                })
        }
    }
</script>
<?php include __DIR__ . '../../parts/html-foot.php'; ?>