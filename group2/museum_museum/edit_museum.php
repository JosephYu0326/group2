<?php
$title = '編輯美術館';
$pageName = '編輯美術館';
require_once '/xampp/htdocs/group2/parts/connect_db.php';
$sid = isset($_GET['Museum_id']) ? intval($_GET['Museum_id']) : 0;

$sql = "SELECT * from museum_museum join museum_location on museum_location.museum_location_id = museum_museum.museum_location_id join museum_kind on museum_kind.museum_kind_id = museum_museum.museum_kind_id join museum_direction on museum_direction.museum_direction_id = museum_location.museum_direction_id join museum_city on museum_city.museum_city_id = museum_location.museum_city_id where Museum_id=$sid";
$sql1 = "select museum_location_id, museum_direction,Museum_city
    from museum_location
    join museum_direction on museum_direction.museum_direction_id = museum_location.museum_direction_id
    join museum_city on museum_city.museum_city_id = museum_location.museum_city_id";

$sql3 = "select museum_kind_id, museum_kind from museum_kind";
$row = $pdo->query($sql)->fetch();
$row1 = $pdo->query($sql)->fetchAll();
$row2 = $pdo->query($sql1)->fetchAll();
$row3 = $pdo->query($sql3)->fetchAll();
if (empty($row)) {
    header('Location: museum_list.php');
    exit;
}

?>

<?php include __DIR__ . '../../parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<?php include __DIR__ . '../../parts/nav.php'; ?>
<style>
    form .mb-3 .form-text {
        color: red;
    }
</style>
</style>
<div class="content-wrapper">
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-xs-12  mt-3 ">
                <div class="box ">
                    <div class="box-header">
                        <h3 class="box-title">編輯美術館</h3>
                    </div>
                    <br>
                    <div class="box-body">
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
                                        <option selected value="<?= $output["Museum_location_id"]; ?>"><?= $output["Museum_direction"]; ?>-<?= $output["Museum_city"]; ?></option>
                                    <?php } ?>
                                    <option>-- select Location --</option>
                                    <?php foreach ($row2 as $output) { ?>
                                        <option value="<?= $output["museum_location_id"]; ?>"><?= $output["museum_direction"]; ?>-<?= $output["Museum_city"]; ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="Museum_kind_id" class="form-label">類型</label>
                                <select class="form-select" aria-label="Default select example" name="Museum_kind_id">
                                    <?php foreach ($row1 as $output) { ?>
                                        <option selected value="<?= $output["Museum_kind_id"]; ?>"><?= $output["Museum_kind"]; ?></option>
                                    <?php } ?>
                                    <option>-- select kind --</option>
                                    <?php foreach ($row3 as $output) { ?>
                                        <option value="<?= $output["museum_kind_id"]; ?>"><?= $output["museum_kind"]; ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="Museum_features" class="form-label">特色</label>
                                <textarea class="form-control" name="Museum_features" id="Museum_features" cols="30" rows="30"><?= $row['Museum_features'] ?></textarea>
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="Museum_introduce" class="form-label">詳細介紹</label>
                                <textarea class="form-control" name="Museum_introduce" id="Museum_introduce" cols="30" rows="30"><?= $row['Museum_introduce'] ?></textarea>
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="Museum_booking_notice" class="form-label">購票須知</label>
                                <textarea class="form-control" name="Museum_booking_notice" id="Museum_booking_notice" cols="30" rows="30"><?= $row['Museum_booking_notice'] ?></textarea>
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="Museum_more_information" class="form-label">更多資訊</label>
                                <textarea class="form-control" name="Museum_more_information" id="Museum_more_information" cols="30" rows="30"><?= $row['Museum_more_information'] ?></textarea>
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3 d-grid gap-2">
                                <button type="submit" class="btn btn-dark">修改</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '../../parts/scripts.php'; ?>
<script>
    const name = document.form1.museum_name;
    const name_msg = museum_name.closest('.mb-3').querySelector('.form-text');
    const features_msg = Museum_features.closest('.mb-3').querySelector('.form-text');
    const introduce_msg = Museum_introduce.closest('.mb-3').querySelector('.form-text');
    const notice_msg = Museum_booking_notice.closest('.mb-3').querySelector('.form-text');
    const information_msg = Museum_more_information.closest('.mb-3').querySelector('.form-text');

    function checkForm() {
        let isPass = true;
        if (museum_name.value.length < 2) {
            isPass = false;
            name_msg.innerText = '請填寫正確的姓名'
        }
        if (Museum_features.value.length > 500) {
            isPass = false;
            features_msg.innerText = '字數不得超過500字'
        }
        if (Museum_introduce.value.length > 5000) {
            isPass = false;
            introduce_msg.innerText = '字數不得超過5000字'
        }
        if (Museum_booking_notice.value.length > 5000) {
            isPass = false;
            notice_msg.innerText = '字數不得超過5000字'
        }
        if (Museum_more_information.value.length > 5000) {
            isPass = false;
            information_msg.innerText = '字數不得超過5000字'
        }

        //TODO: 表單資料送出之前，要做格式檢查


        if (isPass) {

            const fd = new FormData(document.form1);


            fetch('edit_museum_api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert('修改成功');
                        location.href='museum_list.php';
                    } else {
                        alert('修改失敗');
                    }
                })

        }
    }
</script>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        plugins: [
          'advlist autolink lists link image charmap print preview anchor',
          'searchreplace visualblocks code fullscreen textcolor colorpicker',
          'insertdatetime media table contextmenu paste code hr pagebreak nonbreaking'
          ],
          toolbar:['newdocument preview fullscreen code print searchreplace selectall | bold italic underline strikethrough superscript subscript removeformat forecolor backcolor | alignleft aligncenter alignright alignjustify| undo redo cut copy paste pastetext pasteword|bullist numlist outdent indent',
        'blockquote nonbreaking hr pagebreak charmap anchor link unlink image table'],
        
        setup: function (editor) {
        editor.on('change', function () {
            tinymce.triggerSave();
        });
    }
    });
</script>

<?php include __DIR__ . '../../parts/html-foot.php'; ?>

<? // https://phpgurukul.com/php-crud-operation-using-pdo-extension/ 
//https://sleepy-coder.blogspot.com/2020/05/how-to-insert-multi-drop-down-using-php.html
?>