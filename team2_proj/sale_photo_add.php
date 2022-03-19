<?php
require __DIR__ . '/parts/connect_db.php';
$title = '新增商品圖';
$pageName = 'sale_photo_add';
$stmt = $pdo->query("SELECT * FROM products_sale ORDER BY product_id DESC");
$raw_data = $stmt->fetchAll();

$product_sale_id = [];

foreach($raw_data as $r) {
    if($r['product_id']!=''){
        $product_sale_id[] = $r;
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
                    <h5 class="card-title">新增商品圖片</h5><br><br>
                    <form name="sale_photo_add_form" method="post" novalidate onsubmit="checkForm(); return false;">

                        <div class="mb-3">
                            <input type="text" class="form-control" style="display:none" id="sale_photo_url" name="sale_photo_url">
                            <img src="" alt="" id="sale_photo_preview" width="200px">
                            <button type="button" onclick="sale_photo.click()">上傳商品圖片</button>
                            <br><br>
                            <label for="product_sale_id" class="form-label" id="product_sale_id" name="product_sale_id">商品編號</label>
                            <select name="product_sale_id" id="product_sale_id">
                                <?php foreach ($product_sale_id as $p) : ?>
                                    <option value="<?= $p['product_id']?>"><?= $p['product_name']?></option>
                                <?php endforeach; ?>
                            </select>
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
</script>
<?php include __DIR__ . '/parts/html_foot.php'; ?>