<?php
require __DIR__ . '/parts/connect_db.php';
$title = '新增商品圖';
$pageName = 'sale_photo_add';

/*
$perPage = 5; // 每一頁有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; //用戶要看的頁碼
if ($page < 1) {
    header('Location: ab_list.php?page=1');
    exit;
}
*/

/*
$t_sql = "SELECT * FROM products_sale";

// 取得總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$rows = []; //預設沒有資料
$totalPages = 0;

if ($totalRows) {
    // 總頁數
    $totalPages = ceil($totalRows / $perPage);
    if ($page > $totalPages) {
        header("Location: ab_list.php?page=$totalPages");
        exit;
    }
}
*/

/*
$sql = sprintf("SELECT * FROM products_sale ORDER BY sid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
$rows = $pdo->query($sql)->fetchAll(); // 拿到分頁資料
*/

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
                    <h5 class="card-title">新增商品圖片</h5><br><br>
                    <form name="sale_photo_add_form" method="post" novalidate onsubmit="checkForm(); return false;">

                        <div class="mb-3">
                            <label for="sale_photo_name" class="form-label">圖片名稱</label>
                            <input type="text" class="form-control" id="sale_photo_name" name="sale_photo_name">
                            <br>
                            <label for="sale_photo_url" class="form-label">圖片檔名</label>
                            <input type="text" class="form-control" id="sale_photo_url" name="sale_photo_url">
                            <br>
                            <img src="" alt="" id="sale_photo_preview" width="200px">
                            <button type="button" onclick="sale_photo.click()">上傳商品圖片</button>
                            <div class="form-text"></div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">新增</button>
                    </form>

                    <form name="sale_photo_form" onsubmit="return false;" style="display: none">
                        <input type="file" id="sale_photo" name="sale_photo" accept="image/jpeg,image/png">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/parts/scripts.php'; ?>
<script>
    function sendData() {
            const fd = new FormData(document.sale_photo_form);

            fetch('sale_photo_upload.php', {
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
        sale_photo.onchange = sendData;

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
            const fd = new FormData(document.sale_photo_add_form);

            fetch('sale_photo_add_api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert('新增成功');
                        location.href = 'sale_photo_list.php';
                    } else {
                        alert('新增失敗');
                    }
                })
        }
    }

</script>
<?php include __DIR__ . '/parts/html_foot.php'; ?>