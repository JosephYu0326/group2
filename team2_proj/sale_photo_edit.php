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
$stmt = $pdo->query("SELECT * FROM products_sale ORDER BY product_id DESC");
$raw_data = $stmt->fetchAll();

$reload_id = [];

foreach ($raw_data as $r) {
    if ($r['product_id'] != '') {
        $reload_id[] = $r;
    }
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
                            <input type="text" class="form-control" style="display: none" id="sale_photo_url" name="sale_photo_url" required value="<?= htmlentities($row['sale_photo_url']) ?>">
                            <br>
                            <label for="reload" class="form-label" id="reload" name="reload">*商品編號</label>
                            <select name="reload_id" id="reload_id" require value="<?= htmlentities($row['product_sale_id']) ?>"></select>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    const pt_data = <?= json_encode($reload_id, JSON_UNESCAPED_UNICODE) ?>;
    const reload_id = $("#reload_id");

    let str = '';
    for(let pt of pt_data){
        str += `<option value="${pt.product_id}">${pt.product_name}</option>`
    }
    reload_id.html(str);
    reload_id.val(<?= htmlentities($row['product_sale_id']) ?>);
    

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