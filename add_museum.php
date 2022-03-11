<?php
$title = 'Add Museum';
$pageName = 'Add Museum';
require_once 'parts/connect_db.php';
// if (isset($_POST['insert'])) {

//     $name = $_POST['museum_name'];
//     $l_id = $_POST['museum_location_id'];
//     $kind = $_POST['Museum_kind_id'];
//     $feature = $_POST['Museum_features'];
//     $introduce = $_POST['Museum_introduce'];
//     $notice = $_POST['Museum_booking_notice'];
//     $information = $_POST['Museum_more_information'];

//     $sql = "INSERT INTO museum_museum(Museum_name,Museum_location_id,Museum_kind_id,Museum_features,Museum_introduce,Museum_booking_notice,Museum_more_information) Values (:mn, :ml, :mk, :mf, :mi, :mno, :minfo)";

//     $query = $pdo->prepare($sql);

//     $query->bindParam(':mn', $name, pdo::PARAM_STR);
//     $query->bindParam(':ml', $l_id, pdo::PARAM_INT);
//     $query->bindParam(':mk', $kind, pdo::PARAM_INT);
//     $query->bindParam(':mf', $feature, pdo::PARAM_STR);
//     $query->bindParam(':mi', $introduce, pdo::PARAM_STR);
//     $query->bindParam(':mno', $notice, pdo::PARAM_STR);
//     $query->bindParam(':minfo', $information, pdo::PARAM_STR);


//     $query->execute();


//     $lastInsertId = $pdo->lastInsertId();
//     if ($lastInsertId) {

//         echo "<script>alert('Record inserted successfully');</script>";
//         echo "<script>window.location.href='home_.php'</script>";
//     } else {
//         echo "<script>alert('Something went wrong. Please try');</script>";
//         echo "<script>window.location.href='home_.php'</script>";
//     }
// }
$sql1 = "select museum_location_id, museum_direction,Museum_city
    from museum_location
    join museum_direction on museum_direction.museum_direction_id = museum_location.museum_direction_id
    join museum_city on museum_city.museum_city_id = museum_location.museum_city_id";

$sql2 = "select museum_kind_id, museum_kind from museum_kind";

try {
    $stmt = $pdo->prepare($sql1);
    $stmt1 = $pdo->prepare($sql2);
    $stmt->execute();
    $stmt1->execute();
    $results = $stmt->fetchAll();
    $results1 = $stmt1->fetchAll();
} catch (Exception $ex) {
    echo ($ex->getMessage());
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
                    <h5 class="card-title">Add Museum</h5>
                    <form name="form1" method="post" novalidate onsubmit="checkForm(); return false;">
                        <div class="mb-3">
                            <label for="museum_name" class="form-label">館名</label>
                            <input type="text" class="form-control" id="museum_name" name="museum_name" required>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="museum_location_id" class="form-label">位置</label>
                            <select class="form-select" aria-label="Default select example" name="museum_location_id">
                                <option selected>-- select Location --</option>
                                <?php foreach ($results as $output) { ?>
                                    <option value="<?php echo $output["museum_location_id"]; ?>"><?php echo $output["museum_direction"]; ?>-<?php echo $output["Museum_city"]; ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- <div class="mb-3">
                            <label for="museum_location_id" class="form-label">位置</label>
                            <input type="text" class="form-control" id="museum_location_id" name="museum_location_id">
                            <div class="form-text"></div>
                        </div> -->
                        <div class="mb-3">
                            <label for="Museum_kind_id" class="form-label">類型</label>
                            <select class="form-select" aria-label="Default select example" name="Museum_kind_id">
                                <option selected>-- select kind --</option>
                                <?php foreach ($results1 as $output) { ?>
                                    <option value="<?php echo $output["museum_kind_id"]; ?>"><?php echo $output["museum_kind"]; ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- <div class="mb-3">
                            <label for="Museum_kind_id" class="form-label">類型</label>
                            <input type="text" class="form-control" id="Museum_kind_id" name="Museum_kind_id">
                            <div class="form-text"></div>
                        </div> -->
                        <div class="mb-3">
                            <label for="Museum_features" class="form-label">特色</label>
                            <textarea class="form-control" name="Museum_features" id="Museum_features" cols="30" rows="3"></textarea>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Museum_introduce" class="form-label">詳細介紹</label>
                            <textarea class="form-control" name="Museum_introduce" id="Museum_introduce" cols="30" rows="3"></textarea>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Museum_booking_notice" class="form-label">購票須知</label>
                            <textarea class="form-control" name="Museum_booking_notice" id="Museum_booking_notice" cols="30" rows="3"></textarea>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Museum_more_information" class="form-label">更多資訊</label>
                            <textarea class="form-control" name="Museum_more_information" id="Museum_more_information" cols="30" rows="3"></textarea>
                            <div class="form-text"></div>
                        </div>
                        <button type="submit"  class="btn btn-primary">新增</button>
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

            
            fetch('add_museum_api.php',{
                method:'POST',
                body: fd
            }).then(r => r.json())
            .then(obj=>{
                console.log(obj);
                if(obj.success){
                    alert('新增成功');
                    // location.href='ab-list.php';
                }else{
                    alert('新增失敗');
                }
            })
         
        }
    }

</script>

<?php include __DIR__ . '/parts/html-foot.php'; ?>

<? // https://phpgurukul.com/php-crud-operation-using-pdo-extension/ 
//https://sleepy-coder.blogspot.com/2020/05/how-to-insert-multi-drop-down-using-php.html
?>