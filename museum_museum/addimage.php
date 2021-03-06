<?php
$title = 'Add image';
$pageName = 'Add image';
require_once '/xampp/htdocs/group2/parts/connect_db.php';
$sid = isset($_GET['Museum_id']) ? intval($_GET['Museum_id']) : 0;


$sql = "select Museum_id,Museum_name from museum_museum";
$sql1 = "SELECT Museum_id,Museum_name from museum_museum where Museum_id=$sid";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();
} catch (Exception $ex) {
    echo ($ex->getMessage());
}
$row = $pdo->query($sql1)->fetchAll();
?>


<?php include __DIR__ . '../../parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<?php include __DIR__ . '../../parts/nav.php'; ?>

<div class="content-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="statusMsg"></div>
                        <h3 class="box-title mt-3">上傳圖片</h3>
                    </div>
                    <div class="box-body">
                        <form name="form1" method="post" novalidate onsubmit="checkForm(); return false;">
                            <div class="main-form">
                                <div class="col-lg-6 mt-3 ">
                                    <div class="form-group">
                                        <label for="museum_name" class="form-label">館名</label>
                                        <select name="Museum_id" id="Museum_id" class="form-select">
                                            <?php foreach ($row as $c) { ?>
                                                <option selected value="<?= $c["Museum_id"] ?>"><?= $c["Museum_name"] ?></option>
                                            <?php } ?>
                                            <option>-- select Museum --</option>
                                            <?php foreach ($results as $output) { ?>
                                                <option value="<?= $output["Museum_id"] ?>"><?= $output["Museum_name"] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <div class="form-text"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div id="image_preview">
                                    
                                </div>
                                <!-- <input type="hidden" id="pic" name="pic[]">
                                <img src="" alt="" id="myimg" style="width: 100%;"> -->
                                <button class="btn btn-dark" type="button" onclick="avatar.click()">上傳照片</button>
                            </div>
                            <div class="mb-3 d-grid gap-2">
                                <button type="submit" class="btn btn-dark">新增</button>
                            </div>
                        </form>
                        <form name="image_form" onsubmit="return false;" style="display: none;">
                            <input type="file" id="avatar" name="avatar[]" multiple accept="image/*">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '../../parts/scripts.php'; ?>
<script>
    function checkForm() {

        let isPass = true;
        //TODO: 表單資料送出之前，要做格式檢查


        if (isPass) {

            const fd = new FormData(document.form1);


            fetch('addimage_api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert('新增成功');
                        location.href = 'image_list.php?Museum_id=<?= $c["Museum_id"] ?>';
                    } else {
                        alert('新增失敗');
                    }
                })

        }
    }
</script>
<script>
    const avatar = document.querySelector('#avatar');

    function sendData() {
        const fd2 = new FormData(document.image_form);

        fetch('upload.php', {
                method: 'POST',
                body: fd2
            }).then(r => r.json())
            .then(obj => {
                console.log(obj);
                var total_file = document.getElementById("avatar").files.length;
                for (var i=0; i<total_file; i++){
                    if (obj[i].success && obj[i].filename) {
                        $('#image_preview').append("<div class='main'><input type='hidden'id='pic"+[i]+"' value = '"+obj[i].filename+"' name='pic[]'><img src='./imgs/"+ obj[i].filename+"' alt='' id='myimg"+[i]+"' class = 'img-fluid mb-3 mx-auto d-block' ><button type='button' class ='btn btn-danger delete-image'>刪除圖片</button> <hr><br> <input type='hidden' name='Museum_id[]' value='<?= $c["Museum_id"]?>'></div>")

                        // $("#"+"myimg"+[i]+"").attr('src', './imgs/'+ obj[i].filename);
                        // $("#"+"pic"+[i]+"").attr('value', obj[i].filename);
                        $(document).on('click', '.delete-image',function(){
                            $(this).closest('.main').remove();
                        })
                        // myimg.src = './imgs/' + obj.filename;
                        // pic.value = obj.filename;
                    }
                }
            })
    }
    avatar.onchange = sendData;
</script>
<?php include __DIR__ . '../../parts/html-foot.php'; ?>