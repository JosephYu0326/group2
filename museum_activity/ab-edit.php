<?php
require __DIR__ . '../../parts/connect_db.php';

$title = '修改活動';
$pageName = 'ab-edit';


$sid = isset($_GET['Activity_id']) ? intval($_GET['Activity_id']) : 0;

$sql = "SELECT * FROM activity WHERE Activity_id=$sid";
$row = $pdo->query($sql)->fetch();

if(empty($row)){
    header('Location: ab-list-guest.php'); // 找不到資炓轉向列表頁
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

<?php
//活動類型選擇
$stmt = $pdo->query("SELECT * FROM activity_types ORDER BY Activity_Types_id");
$raw_data = $stmt->fetchAll();

$Activity_Types_id = [];

foreach ($raw_data as $r) {
    if ($r['Activity_Types_id'] != '') {
        $Activity_Types_id[] = $r;
    }
}
//選擇主辦單位
$stmt2 = $pdo->query("SELECT * FROM activity_organizers ORDER BY Activity_Organizers_id");
$raw_data2 = $stmt2->fetchAll();

$Activity_Organizers_id = [];

foreach ($raw_data2 as $r) {
    if ($r['Activity_Organizers_id'] != '') {
        $Activity_Organizers_id[] = $r;
    }
}
?>



<div class="content-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg">
                <div class="card mt-3">
                    <div class="card-body">



                        <form name="avatar_form" onsubmit="return false;" style="display: none;">
                            <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png">
                        </form>




                        <h5 class="card-title">修改活動</h5>
                        <br>
                        <form name="form1" method="post" novalidate onsubmit="checkForm(); return false;">
                            <input type="hidden" name="Activity_id" value="<?= $row['Activity_id'] ?>">


                            <input type="hidden" id="pic" name="pic">

                            <br>
                            <img src="" alt="" id="myimg" class="img-fluid" >
                            <br>
                            <button type="button" onclick="avatar.click()" class="btn btn-dark">上傳圖片</button>


                            <div class="mb-3">
                                <label for="name" class="form-label">* 活動名稱</label>
                                <input type="text" class="form-control" id="name" name="name" required value="<?= htmlentities($row['Activity_Name']) ?>">
                                <div class="form-text"></div>
                            </div>

                            <div class="mb-3">
                                <label for="s-time" class="form-label">* 開始時間</label>
                                <input type="datetime-local" class="form-control" id="s-time" name="s-time" required value="<?= htmlentities($row['Activity_Star_Time']) ?>">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="e-time" class="form-label">* 結束時間</label>
                                <input type="datetime-local" class="form-control" id="e-time" name="e-time" required value="<?= htmlentities($row['Activity_End_Time']) ?>">
                                <div class="form-text"></div>
                            </div>

                            <div class="mb-3">
                                <label for="a-url" class="form-label">* 參考網站</label>
                                <input type="url" class="form-control" id="a-url" name="a-url" required value="<?= htmlentities($row['Activity_Links']) ?>">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="intro" class="form-label">* 活動簡介</label>
                                <input type="text" class="form-control" id="intro" name="intro" required value="<?= htmlentities($row['Activity_Introduction']) ?>">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="text" class="form-label">詳細介紹</label>
                                <textarea class="form-control" name="text" id="text" cols="30" rows="3"><?= htmlentities($row['Activity_Text']) ?></textarea>

                                <div class="form-text"></div>
                            </div>
                            <!-- bug 如何確定以選的選項-->
                            <div class="mb-3">活動類型
                                <select class="form-select" name="Activity_Types_id" aria-label="Default select example">
                                    <?php foreach ($Activity_Types_id as $ai) : ?>
                                        <option value="<?= $ai['Activity_Types_id'] ?>"><?= $ai['Activity_Types_Name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">活動主辦單位
                                <select class="form-select" name="fk_Activity_Organizers_id" aria-label="Default select example">
                                    <?php foreach ($Activity_Organizers_id as $ai) : ?>
                                        <option value="<?= $ai['Activity_Organizers_id'] ?>"><?= $ai['Activity_Organizers_Name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>



                            <!-- 忘了縣市 -->
                            <div class="mb-3">
                                <label for="place" class="form-label">* 活動地點</label>
                                <input type="text" class="form-control" id="place" name="place" required value="<?= htmlentities($row['Activity_Place']) ?>">
                                <div class="form-text">
                                    <div class="form-text"></div>
                                </div>



                                <div class="mt-3 d-grid gap-2">
                                    <button type="submit" class="btn btn-dark">修改</button>
                                </div>

                    </div>
                </div>
            </div>
        </div>





    </div>
</div>
<?php include __DIR__ . '../../parts/scripts.php'; ?>
<script>
    const name = document.form1.name; // DOM element
    const name_msg = name.closest('.mb-3').querySelector('.form-text');

    function checkForm() {
        let isPass = true; // 有沒有通過檢查

        name_msg.innerText = ''; // 清空訊息


        // TODO: 表單資料送出之前, 要做格式檢查

        if (name.value.length < 2) {
            isPass = false;
            name_msg.innerText = '請填寫正確的名稱'
        }

        if (isPass) {
            const fd = new FormData(document.form1);

            fetch('ab-edit.api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert('修改成功');
                        location.href = 'ab-list.php';

                    } else {
                        alert('修改失敗');
                    }

                })


        }


    }
</script>
<script>
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
                    pic.value = obj.filename;
                }
            });
    }

    avatar.onchange = sendData;
</script>


<?php include __DIR__ . '../../parts/html-foot.php'; ?>