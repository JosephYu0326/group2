<?php
$title = 'Edit Ticket';
$pageName = 'Edit Ticket';
require_once 'parts/connect_db.php';
$sid = isset($_GET['Museum_id']) ? intval($_GET['Museum_id']) : 0;
$ticket_id = isset($_GET['Museum_ticket_id']) ? intval($_GET['Museum_ticket_id']) : 0;


$sql = "select Museum_id,Museum_name from museum_museum";
$sql1 = "SELECT Museum_id,Museum_name from museum_museum where Museum_id=$sid";
$sql2 = "SELECT * from museum_price where Museum_ticket_id=$ticket_id";

try{
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();
} catch(Exception $ex){
    echo ($ex->getMessage());
}
$row = $pdo->query($sql1)->fetchAll();
$row1= $pdo->query($sql2)->fetch();
?>


<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<?php include __DIR__ . '/parts/nav.php'; ?>

<div class="content-wrapper">
    <div class="content ">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title mt-3">修改票券</h3>
                    </div>
                    <div class="box-body">
                        <form name="form1" method="post" novalidate onsubmit="checkForm(); return false;">
                            <div class="main-form">
                                <div class="col-lg-6 mt-3 ">
                                    <div class="form-group">
                                    <input type="hidden" name="Museum_id" value="<?= $row1["Museum_id"]?>">
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-3">
                                    <div class="form-group">
                                        <label for="Museum_price_kind" class="form-label">票種</label>
                                        <input type="text" class="form-control" id="Museum_price_kind" name="Museum_price_kind" required value="<?= htmlentities($row1['Museum_price_kind']) ?>">
                                        <div class="form-text"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-3">
                                    <div class="form-group">
                                        <label for="Museum_ticket_price" class="form-label">票價</label>
                                        <input type="text" class="form-control" id="Museum_ticket_price" name="Museum_ticket_price" required value="<?= htmlentities($row1['Museum_ticket_price']) ?>">
                                        <div class="form-text"></div>
                                    </div>
                                </div>
                            </div>
                                <div class="col-lg-6 mt-3">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="Museum_ticket_price" name="Museum_ticket_id" required value="<?= htmlentities($row1['Museum_ticket_id']) ?>">
                                        <div class="form-text"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="paste-new-forms">

                            </div>
                            <div class="col-lg-6 mt-3">
                                <button type="submit" class="btn btn-dark mb-3">修改</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/parts/scripts.php'; ?>
<script>
    // const name = document.form1.museum_name;
    // const name_msg = museum_name.closest('.mt-3').querySelector('.form-text');
    // const features_msg = Museum_features.closest('.mb-3').querySelector('.form-text');

    function checkForm(){
        let isPass = true;
        // if( museum_name.value.length<2){
        //     isPass = false;
        //     name_msg.innerText= '請填寫正確的姓名'
        // }
        // if(Museum_features.value.length>50){
        //     isPass = false;
        //     features_msg.innerText='字數不得超過50字'
        // }

        //TODO: 表單資料送出之前，要做格式檢查


        if(isPass){
            
            const fd = new FormData(document.form1);

            
            fetch('edit_ticket_api.php',{
                method:'POST',
                body: fd
            }).then(r => r.json())
            .then(obj=>{
                console.log(obj);
                if(obj.success){
                    alert('修改成功');
                    location.href='museum_ticket_list.php?Museum_id=<?=$sid?>';
                }else{
                    alert('修改失敗');
                }
            })
         
        }
    }
</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>