<?php
require __DIR__ . '/parts/connect_db.php';

$title = '修改主辦單位';
$pageName = 'ab-edit-org';
$sid = isset($_GET['Activity_Organizers_id']) ? intval($_GET['Activity_Organizers_id']) : 0;


$sql="SELECT * From  activity_organizers where Activity_Organizers_id=$sid" ;
$row = $pdo->query($sql)->fetch();


if(empty($row)){
    header('Location: ab-list-org.php'); // 找不到資炓轉向列表頁
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
                    <h5 class="card-title">新增主辦單位資料</h5>
                    <form name="form1" method="post" novalidate onsubmit="checkForm(); return false;">
                    <input type="hidden" name="sid" value="<?=$row['Activity_Organizers_id']?>">

                        <div class="mb-3">
                            <label for="name" class="form-label">主辦單位名稱</label>
                            <input type="text" class="form-control" id="name" name="name" required
                            value="<?=htmlentities($row['name'])?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="img" class="form-label">主辦單位圖片</label>
                            <input type="text" class="form-control" id="img" name="img" required
                            value="<?=htmlentities($row['img'])?>">
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
    
    const name = document.form1.name;// DOM element
    const name_msg = name.closest('.mb-3').querySelector('.form-text');
  
    function checkForm(){
        let isPass = true; // 有沒有通過檢查

         name_msg.innerText = '';  // 清空訊息
        // mobile_msg.innerText = '';  // 清空訊息

        // TODO: 表單資料送出之前, 要做格式檢查

        if(name.value.length<2){
            isPass = false;
            name_msg.innerText = '請填寫正確的姓名'
        }

        if(isPass){
            const fd = new FormData(document.form1);

            fetch('ab-edit-org-api.php', {
                method: 'POST',
                body: fd
            }).then(r => r.json())
            .then(obj => {
                console.log(obj);
                if(obj.success){
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