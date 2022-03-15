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
                    <h5 class="card-title">新增商品圖片</h5><br>
                    <form name="form_sale_photo" method="post" novalidate onsubmit="checkForm(); return false;">

                        <div class="mb-3">
                            <label for="sale_photo_name" class="form-label">圖片名稱</label>
                            <input type="text" class="form-control" id="sale_photo_name" name="sale_photo_name">
                            <br>
                            <input type="text" class="form-control" id="product_intro" name="product_intro">
                            <br>
                            <img src="" alt="" id="sale_photo_url" width="200px">
                            <button type="button" onclick="sale_photo.click()">上傳商品圖片</button>
                            <div class="form-text"></div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">新增</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/parts/scripts.php'; ?>
<script>
    /*const mobile = document.form_1.mobile; // DOM element
    const mobile_msg = mobile.closest('.mb-3').querySelector('.form-text');

    const name = document.form_1.name;
    const name_msg = name.closest('.mb-3').querySelector('.form-text');*/

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
            const fd = new FormData(document.form_sale_photo);

            fetch('sale_photo_add_api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert('新增成功');
                        // location.href = 'ab_list.php';
                    } else {
                        alert('新增失敗');
                    }
                })
        }
    }
</script>
<?php include __DIR__ . '/parts/html_foot.php'; ?>