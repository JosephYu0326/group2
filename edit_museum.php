<?php
$title = 'Edit Museum';
$pageName = 'Edit Museum';
require_once 'parts/connect_db.php';
$sid = isset($_GET['Museum_id']) ? intval($_GET['Museum_id']) : 0;

$sql = "SELECT * from museum_museum join museum_location on museum_location.museum_location_id = museum_museum.museum_location_id join museum_kind on museum_kind.museum_kind_id = museum_museum.museum_kind_id join museum_direction on museum_direction.museum_direction_id = museum_location.museum_direction_id join museum_city on museum_city.museum_city_id = museum_location.museum_city_id where Museum_id=$sid";
$sql1 = "select museum_location_id, museum_direction,Museum_city
    from museum_location
    join museum_direction on museum_direction.museum_direction_id = museum_location.museum_direction_id
    join museum_city on museum_city.museum_city_id = museum_location.museum_city_id";
    
$sql3 = "select museum_kind_id, museum_kind from museum_kind";
$row = $pdo->query($sql)->fetch();
$row1=$pdo->query($sql)->fetchAll();
$row2=$pdo->query($sql1)->fetchAll();
$row3=$pdo->query($sql3)->fetchAll();
if(empty($row)){
    header('Location: museum_list.php');
    exit;
}

?>

<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<?php include __DIR__ . '/parts/nav.php'; ?>
<style>
        form .mb-3 .form-text{
        color: red;
    }
</style>
</style>
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-6  mt-3 ">
            <div class="card text-white bg-dark">
                <div class="card-body">
                    <h5 class="card-title">Edit Museum</h5><br>
                    <form name="form1" method="post" novalidate onsubmit="checkForm(); return false;">
                    <input type="hidden" name="Museum_id" value="<?= $row['Museum_id'] ?>">
                        <div class="mb-3">
                            <label for="museum_name" class="form-label">館名</label>
                            <input type="text" class="form-control" id="museum_name" name="museum_name" required value="<?= htmlentities($row['Museum_name']) ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Museum_location_id" class="form-label">位置</label>
                            <select class="form-select" aria-label="Default select example" name="Museum_location_id">
                                <?php foreach ($row1 as $output) { ?>
                                    <option selected value="<?= $output["Museum_location_id"]; ?>" ><?= $output["Museum_direction"]; ?>-<?=$output["Museum_city"]; ?></option>
                                    <?php } ?>
                                    <option >-- select Location --</option>
                                <?php foreach ($row2 as $output) { ?>
                                    <option value="<?= $output["museum_location_id"]; ?>"><?= $output["museum_direction"]; ?>-<?=$output["Museum_city"]; ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Museum_kind_id" class="form-label">類型</label>
                            <select class="form-select" aria-label="Default select example" name="Museum_kind_id">
                                <?php foreach ($row1 as $output) { ?>
                                    <option selected value="<?= $output["Museum_kind_id"]; ?>"><?= $output["Museum_kind"]; ?></option>
                                    <?php } ?>
                                    <option >-- select kind --</option>
                                <?php foreach ($row3 as $output) { ?>
                                    <option value="<?= $output["museum_kind_id"]; ?>"><?= $output["museum_kind"]; ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Museum_features" class="form-label">特色</label>
                            <textarea class="form-control" name="Museum_features" id="Museum_features" cols="30" rows="3"><?= $row['Museum_features'] ?></textarea>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Museum_introduce" class="form-label">詳細介紹</label>
                            <textarea class="form-control" name="Museum_introduce" id="Museum_introduce" cols="30" rows="3"><?= $row['Museum_introduce'] ?></textarea>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Museum_booking_notice" class="form-label">購票須知</label>
                            <textarea class="form-control" name="Museum_booking_notice" id="Museum_booking_notice" cols="30" rows="3"><?= $row['Museum_booking_notice'] ?></textarea>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Museum_more_information" class="form-label">更多資訊</label>
                            <textarea class="form-control" name="Museum_more_information" id="Museum_more_information" cols="30" rows="3"><?= $row['Museum_more_information'] ?></textarea>
                            <div class="form-text"></div>
                        </div>
                        <button type="submit"  class="btn btn-primary">修改</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/parts/scripts.php'; ?>
<script>

    const name = document.form1.museum_name;
    const name_msg = museum_name.closest('.mb-3').querySelector('.form-text');
    const features_msg = Museum_features.closest('.mb-3').querySelector('.form-text');

    function checkForm(){
        let isPass = true;
        if(museum_name.value.length<2){
            isPass = false;
            name_msg.innerText= '請填寫正確的姓名'
        }
        if(Museum_features.value.length>50){
            isPass = false;
            features_msg.innerText='字數不得超過50字'
        }

        //TODO: 表單資料送出之前，要做格式檢查


        if(isPass){
            
            const fd = new FormData(document.form1);

            
            fetch('edit_museum_api.php',{
                method:'POST',
                body: fd
            }).then(r => r.json())
            .then(obj=>{
                console.log(obj);
                if(obj.success){
                    alert('修改成功');
                    // location.href='ab-list.php';
                }else{
                    alert('修改失敗');
                }
            })
         
        }
    }

</script>

<?php include __DIR__ . '/parts/html-foot.php'; ?>

<? // https://phpgurukul.com/php-crud-operation-using-pdo-extension/ 
//https://sleepy-coder.blogspot.com/2020/05/how-to-insert-multi-drop-down-using-php.html
?>