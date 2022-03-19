<?php
$title = '新增資料';
$pageName = 'ab-add-ticket';
?>
<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<style>
    form .mb-3 .form-text {
        color: red;
    }
</style>
<div class="content-wrapper">

<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">新增資料</h5>
                    <form name="form1" method="post" novalidate onsubmit="checkForm(); return false;">
                        <div class="mb-3">
                            <label for="name" class="form-label">* 票券名稱</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">* 票券價格</label>
                            <input type="text" class="form-control" id="price" name="price" required>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label">票券說明</label>
                            <textarea class="form-control" name="text" id="text" cols="30" rows="3"></textarea>

                            <div class="form-text"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="start" class="form-label">* 售票時間(開始)</label>
                            <input type="datetime-local" class="form-control" id="start" name="start" required>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="end" class="form-label">* 售票時間(結束)</label>
                            <input type="datetime-local" class="form-control" id="end" name="end" required>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="startTime" class="form-label">* 票券期限(開始)</label>
                            <input type="datetime-local" class="form-control" id="startTime" name="startTime" required>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="endTime" class="form-label">* 票券期限(結束)</label>
                            <input type="datetime-local" class="form-control" id="endTime" name="endTime" required>
                            <div class="form-text"></div>
                        </div>

                       

                        

                        <button type="submit" class="btn btn-primary">新增</button>
                    </form>

                </div>
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
       

        // TODO: 表單資料送出之前, 要做格式檢查

        if (name.value.length < 2){
            isPass = false;
            name_msg.innerText = '請填寫正確的名稱'
        }

        if (isPass){
            const fd = new FormData(document.form1);

            fetch('ab-add-ticket.api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success){
                        alert('新增成功');
                        // location.href = 'ab-list.php';
                    } else {
                        alert('新增失敗');
                    }

                })


        }


    }


    
</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>