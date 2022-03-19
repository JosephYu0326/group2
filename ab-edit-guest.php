<?php
require __DIR__ . '/parts/connect_db.php';

$title = '修改資料';
$pageName = 'ab-edit-guest';

$sid = isset($_GET['Activity_Guest_id']) ? intval($_GET['Activity_Guest_id']) : 0;

$sql = "SELECT * FROM activity_guest WHERE Activity_Guest_id=$sid";
$row = $pdo->query($sql)->fetch();


if(empty($row)){
    header('Location: ab-list-guest.php'); // 找不到資炓轉向列表頁
    exit;
}
?>
<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<style>
    form .mb-3 .form-text{
        color: red;
    }

</style>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">修改資料</h5>
                    <form name="form1" method="post" novalidate onsubmit="checkForm(); return false;">
                        <input type="hidden" name="Activity_Guest_id" value="<?= $row['Activity_Guest_id'] ?>">

                       

                        <div class="mb-3">
                            <label for="name" class="form-label">* 嘉賓名稱</label>
                            <input type="text" class="form-control" id="name" name="name" required
                            value="<?= htmlentities($row['Activity_Guest_Name']) ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="img" class="form-label">* 嘉賓圖片</label>
                            <input type="text" class="form-control" id="img" name="img" required
                            value="<?= htmlentities($row['Activity_Guest_Img']) ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Profession" class="form-label">* 嘉賓職業</label>
                            <input type="text" class="form-control" id="Profession" name="Profession" required
                            value="<?= htmlentities($row['Activity_Guest_Job_Title']) ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="company" class="form-label">* 嘉賓公司</label>
                            <input type="text" class="form-control" id="company" name="company" required
                            value="<?= htmlentities($row['Activity_Guest_Company_name']) ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="a-url" class="form-label">* 嘉賓網址</label>
                            <input type="url" class="form-control" id="a-url" name="a-url" required
                            value="<?= htmlentities($row['Activity_Guest_Profiles']) ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label">嘉賓介紹</label>
                            <textarea class="form-control" name="text"
                            id="text" 
                            cols="30" 
                            rows="3"><?= $row['Activity_Guest_URL'] ?></textarea>

                            <div class="form-text"></div>
                        </div>


                        <button type="submit" class="btn btn-primary">修改</button>
                    </form>

                </div>
            </div>
        </div>
    </div>





</div>
<?php include __DIR__ . '/parts/scripts.php'; ?>
<script>
    

    const name = document.form1.name;
    const name_msg = name.closest('.mb-3').querySelector('.form-text');

    function checkForm(){
        let isPass = true; // 有沒有通過檢查

        name_msg.innerText = '';  // 清空訊息
       

        // TODO: 表單資料送出之前, 要做格式檢查

        if(name.value.length<2){
            isPass = false;
            name_msg.innerText = '請填寫正確的姓名'
        }

        

        if(isPass){
            const fd = new FormData(document.form1);

            fetch('ab-edit-guest-api.php', {
                method: 'POST',
                body: fd
            }).then(r => r.json())
            .then(obj => {
                console.log(obj);
                if(obj.success){
                    alert('修改成功');
                    // location.href = 'ab-list.php';
                } else {
                    alert('沒有修改');
                }

            })


        }


    }


</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>




<!-- 
    字串是一個一個比
    
-->

<!-- // 找資料
// 執行上面sql
// 兩種情況 拿到資料 拿不到資料
// 如果讀資料是空的代表你沒拿 
// 轉道 ab-list.php 找不到資料 就轉到列表頁
// 資料輸出到欄位 -->