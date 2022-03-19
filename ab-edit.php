<?php
require __DIR__ . '/parts/connect_db.php';

$title = '修改活動';
$pageName = 'ab-edit';
//檢查id
$sid = isset($_GET['Activity_id']) ? intval($_GET['Activity_id']) : 0;

$sql = "SELECT * FROM activity WHERE Activity_id=$sid";
$row = $pdo->query($sql)->fetch();

if(empty($row)){
    header('Location: ab-list.php'); // 找不到資炓轉向列表頁
    exit;
}

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

// echo json_encode($Activity_Organizers_id);

// echo json_encode($Activity_Types_id);
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
            <div class="col-lg">
                <div class="card">
                    <div class="card-body">


                        <!-- 圖片 -->
                        <form name="avatar_form" onsubmit="return false;" style="display: none;">
                            <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png">
                        </form>
                        <!-- 活動 -->
                        <h5 class="card-title">修改活動</h5>
                        <input type="hidden" name="Activity_Types_id" value="<?= $row['Activity_Types_id'] ?>">
                        <br>
                        <!-- 圖片 -->
                        <form name="form1" method="post" novalidate onsubmit="checkForm(); return false;">
                            <input type="text" id="pic" name="pic">

                            <br>
                            <img src="" alt="" id="myimg" width="200px">
                            <br>
                            <button type="button" onclick="avatar.click()">上傳圖片</button>

                        <!-- 名稱 -->
                            <div class="mb-3">
                                <label for="name" class="form-label">* 活動名稱</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                value="<?= htmlentities($row['Activity_Name']) ?>">
                                <div class="form-text"></div>
                            </div>
                            <!-- <div class="mb-3">
                                <label for="img" class="form-label">* 活動圖片</label>
                                <input type="text" class="form-control" id="img" name="img" required>
                                <div class="form-text"></div>
                            </div> -->
                            <!-- 上傳圖片 -->
                            <!-- <div class="mb-3">
                                <input type="text" id="pic" name="img">
                                <br>
                                <img src="" class="img" id="img" alt="">
                                <br>
                                <button type="button" onclick="avatar.click()">上傳活動圖片</button>
                                <br>
                                <input type="text">
                                <br>
                                <input type="submit">
                                <form name="form1" onsubmit="return false;" style="display: none;">
                                    <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png">
                                </form>
                            </div> -->
                            <!-- 上傳圖片 -->
                            <div class="mb-3">
                                <label for="s-time" class="form-label">* 開始時間</label>
                                <input type="datetime-local" class="form-control" id="s-time" name="s-time" required
                                value="<?= htmlentities($row['Activity_Star_Time']) ?>">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="e-time" class="form-label">* 結束時間</label>
                                <input type="datetime-local" class="form-control" id="e-time" name="e-time" required value="<?= htmlentities($row['Activity_End_Time']) ?>">
                                <div class="form-text"></div>
                            </div>

                            <div class="mb-3">
                                <label for="a-url" class="form-label">* 參考網站</label>
                                <input type="url" class="form-control" id="a-url" name="a-url" required
                                value="<?= htmlentities($row['Activity_Links']) ?>">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="intro" class="form-label">* 活動簡介</label>
                                <input type="text" class="form-control" id="intro" name="intro" required
                                value="<?= htmlentities($row['Activity_Introduction']) ?>">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="text" class="form-label">詳細介紹</label>
                                <textarea class="form-control" name="text" id="text" cols="30" rows="3"
                                value="<?= htmlentities($row['Activity_Text']) ?>"></textarea>

                                <div class="form-text"></div>
                            </div>

                            <div class="mb-3">活動類型
                                <select class="form-select" name="Activity_Types_id" aria-label="Default select example">
                                    <?php foreach ($Activity_Types_id as $ai): ?>
                                        <option value="<?= $ai['Activity_Types_id'] ?>"><?= $ai['Activity_Types_Name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">活動主辦單位
                                <select class="form-select" name="fk_Activity_Organizers_id" aria-label="Default select example">
                                    <?php foreach ($Activity_Organizers_id as $ai): ?>
                                        <option value="<?= $ai['Activity_Organizers_id'] ?>"><?= $ai['Activity_Organizers_Name'] ?></option>
                                    <?php endforeach; ?>
                                </select> 
                            </div>

                            
                           
                            <!-- 忘了縣市 -->
                            <div class="mb-3">
                                <label for="place" class="form-label">* 活動地點</label>
                                <input type="text" class="form-control" id="place" name="place" required value="<?= htmlentities($row['Activity_Place']) ?>">
                                <div class="form-text"></div>
                            </div>



                            <button type="submit" class="btn btn-primary">更新</button>
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

        if (name.value.length < 2) {
            isPass = false;
            name_msg.innerText = '請填寫兩個字以上的名稱'
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
                        alert('新增成功');
                        //成功轉跳 ab-list.php
                        // location.href = 'ab-list.php';

                    } else {
                        alert('新增失敗');
                    }

                })


        }


    }
</script>
<script>
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
<!-- 圖片上傳  -->

<?php include __DIR__ . '/parts/html-foot.php'; ?>