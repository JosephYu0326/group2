<?php
$title = '新增商品';
$pageName = 'products_add';

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
                    <h5 class="card-title">新增商品</h5><br>
                    <form class="p-4" name="form_products" method="post" novalidate onsubmit="checkForm(); return false;">

                        <div class="mb-3">
                            <label for="product_name" class="form-label">商品名稱</label>
                            <input type="text" class="form-control" id="product_name" name="product_name">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="product_intro" class="form-label">商品簡介</label>
                            <input type="text" class="form-control" id="product_intro" name="product_intro">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="product_main" class="form-label">商品完整介紹</label>
                            <textarea class="form-control" id="product_main" name="product_main"></textarea>
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="product_more_info" class="form-label">商品相關故事</label>
                            <textarea class="form-control" id="product_more_info" name="product_more_info"></textarea>
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="porduct_size" class="form-label">商品規格</label>
                            <textarea name="product_size" id="product_size" cols="30" rows="3" class="form-control"></textarea>

                            <div class="form-text"></div>
                        </div>

                        <label for="product_orign_price" class="form-label">建議售價</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control" id="product_orign_price" name="product_orign_price" aria-label="Amount (to the nearest dollar)" pattern="/^\d*$/">
                            <span class="input-group-text">.00</span>

                            <div class="form-text"></div>
                        </div>

                        <label for="porduct_price" class="form-label">優惠售價</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" id="product_price" name="product_price" pattern="/^\d*$/">
                            <span class="input-group-text">.00</span>

                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="product_store_quantity" class="form-label">商品庫存量</label>
                            <input type="text" class="form-control" id="product_store_quantity" name="product_store_quantity" pattern="/^\d*$/">

                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="product_category" class="form-label">商品類別</label>
                            <input type="text" class="form-control" id="product_category" name="product_category">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="product_location" class="form-label">商品地點</label>
                            <input type="text" class="form-control" id="product_location" name="product_location">
                            <div class="form-text"></div>
                        </div>

                        <button type="submit" class="btn btn-primary">新增</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/parts/scripts.php'; ?>
<script>
    const name = document.form_products.product_name; // DOM element
    const name_msg = name.closest('.mb-3').querySelector('.form-text');

    const orign_price = document.form_products.product_orign_price;
    const orign_price_msg = orign_price.closest('.mb-3').querySelector('.form-text');

    const price = document.form_products.product_price;
    const price_msg = price.closest('.mb-3').querySelector('.form-text');

    const quantity = document.form_products.product_store_quantity;
    const quantity_msg = quantity.closest('.mb-3').querySelector('.form-text');

    function checkForm() {
        let isPass = true; // 有沒有通過檢查

        name_msg.innerText = ''; // 清空訊息
        orign_price_msg.innerText = ''; // 清空訊息
        price_msg.innerText = ''; // 清空訊息
        quantity_msg.innerText = ''; // 清空訊息

        // TODO: 表單資料送出之前, 要做格式檢查

        if (name.value.length < 1) {
            isPass = false;
            name_msg.innerText = '請輸入商品名'
        }

        const orign_price_re = /^\d*$/; // new RegExp()
        const price_re = /^\d*$/;
        const quantity_re = /^\d*$/;

        if (orign_price.value.length < 1) {
            isPass = false;
            orign_price_msg.innerText = '請輸入價格'
            // 如果不是空字串就檢查格式
        } else if (!orign_price_re.test(orign_price.value)) {
                orign_price_msg.innerText = '請輸入數字';
                isPass = false;
            }
        

        if (price.value.length < 1) {
            isPass = false;
            price_msg.innerText = '請輸入價格'
            // 如果不是空字串就檢查格式
        } else if (!price_re.test(price.value)) {
                price_msg.innerText = '請輸入數字';
                isPass = false;
            }
        

        if (quantity.value.length < 1) {
            isPass = false;
            quantity_msg.innerText = '請輸入數量'
            // 如果不是空字串就檢查格式
        } else if (!quantity_re.test(quantity.value)) {
            quantity_msg.innerText = '請輸入數字';
            isPass = false;
        }
        
    

    if (isPass) {
        const fd = new FormData(document.form_products);

        fetch('products_add_api.php', {
                method: 'POST',
                body: fd
            }).then(r => r.json())
            .then(obj => {
                console.log(obj);
                if (obj.success) {
                    alert('新增成功');
                    location.href = 'products_list.php';
                } else {
                    alert('新增失敗');
                }
            })
        }
    }
</script>
<?php include __DIR__ . '/parts/html_foot.php'; ?>