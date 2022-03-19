<?php
$title = '新增主辦單位';
$pageName = 'ab-add-org';
?>
<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<style>
    form .mb-3 .form-text {
        color: red;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <form name="avatar_form" onsubmit="return false;" style="display: none;">
                        <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png">
                    </form>

                    
                    <h5 class="card-title">新增主辦單位資料</h5>
                    <form name="form1" method="post" novalidate onsubmit="checkForm(); return false;">
                    <br>
                        <div class="mb-3">
                            <label for="name" class="form-label">主辦單位名稱</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="form-text"></div>
                        </div>




                        <input type="hidden" id="img" name="img">

                        <br>
                        <img src="" alt="" id="myimg" width="200px">
                        <br>
                        <button type="button" class="btn btn-primary" onclick="avatar.click()">上傳嘉賓圖片</button>
                        <!-- <div class="mb-3">
                            <label for="img" class="form-label">主辦單位圖片</label>
                            <input type="text" class="form-control" id="img" name="img" required>
                            <div class="form-text"></div>
                        </div> -->




                        <button type="submit" class="btn btn-primary">新增資料</button>
                    </form>

                </div>
            </div>
        </div>
    </div>





</div>
<?php include __DIR__ . '/parts/scripts.php'; ?>
<script>
    const name = document.form1.name; // DOM element
    const name_msg = name.closest('.mb-3').querySelector('.form-text');

    function checkForm() {
        let isPass = true; // 有沒有通過檢查

        name_msg.innerText = ''; // 清空訊息
        // mobile_msg.innerText = '';  // 清空訊息

        // TODO: 表單資料送出之前, 要做格式檢查

        if (name.value.length < 2) {
            isPass = false;
            name_msg.innerText = '請填寫正確的姓名'
        }

        if (isPass) {
            const fd = new FormData(document.form1);

            fetch('ab-add-org-api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert('新增成功');
                        location.href = 'ab-list-org.php';
                    } else {
                        alert('新增失敗');
                    }

                })


        }


    }

     // 檢查圖片
     function sendData() {
        const fd = new FormData(document.avatar_form);

        fetch('upload-avatar.php', {
                method: 'POST',
                body: fd
            }).then(r => r.json())
            .then(obj => {
                console.log(obj);
                if (obj.success && obj.filename) {
                    myimg.src = './imgs/' + obj.filename;
                    img.value = obj.filename;
                }
            });
    }

    avatar.onchange = sendData;
    // ---


</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>