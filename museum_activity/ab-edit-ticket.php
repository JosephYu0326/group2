<?php
require __DIR__ . '../../parts/connect_db.php';

$title = '修改票券';
$pageName = 'ab-edit-ticket';

//活動選擇
$stmt = $pdo->query("SELECT * FROM activity ORDER BY Activity_id");
$raw_data = $stmt->fetchAll();

$Activity_id = [];

foreach ($raw_data as $r) {
    if ($r['Activity_id'] != '') {
        $Activity_id[] = $r;
    }
}



$Activity_ticket_id = isset($_GET['Activity_ticket_id']) ? intval($_GET['Activity_ticket_id']) : 0;

$sql = "SELECT * FROM activity_ticket WHERE Activity_ticket_id =$Activity_ticket_id";
$row = $pdo->query($sql)->fetch();


if (empty($row)) {
    header('Location: ab-list-ticket.php'); // 找不到資炓轉向列表頁
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


<div class="content-wrapper">
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-lg">
                <div class="card">
                    <div class="card-body mt-3">

                        <h5 class="card-title">修改票券</h5>
                        <form name="form1" method="post" novalidate onsubmit="checkForm(); return false;">

                        <input type="hidden" name="Activity_ticket_id" value="<?= $row['Activity_ticket_id'] ?>">

                            <div class="mb-3">
                                <label for="name" class="form-label">* 票券名稱</label>
                                <input type="text" class="form-control" id="name" name="name" required value="<?= htmlentities($row['ticket_name']) ?>">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">* 票券價格</label>
                                <input type="text" class="form-control" id="price" name="price" required value="<?= htmlentities($row['ticket_price']) ?>"> 
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="text" class="form-label">票券說明</label>
                                <textarea class="form-control" name="text" id="text" cols="30" rows="3"><?= htmlentities($row['Activity_ticket_description']) ?></textarea>

                                <div class="form-text"></div>
                            </div>

                            <div class="mb-3">
                                <label for="start" class="form-label">* 售票時間(開始)</label>
                                <input type="datetime-local" class="form-control" id="start" name="start" required value="<?= htmlentities($row['Activity_ticket_Star_Time']) ?>">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="end" class="form-label">* 售票時間(結束)</label>
                                <input type="datetime-local" class="form-control" id="end" name="end" required value="<?= htmlentities($row['Activit_ticket_End_Time']) ?>"> 
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="startTime" class="form-label">* 票券期限(開始)</label>
                                <input type="datetime-local" class="form-control" id="startTime" name="startTime" required value="<?= htmlentities($row['Valid_start_time']) ?>">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="endTime" class="form-label">* 票券期限(結束)</label>
                                <input type="datetime-local" class="form-control" id="endTime" name="endTime" required value="<?= htmlentities($row['Valid_End_time']) ?>">
                                <div class="form-text"></div>
                            </div>

                            <div class="mb-3">活動票券
                                <select class="form-select" name="Activity_id" aria-label="Default select example">
                                    <?php foreach ($Activity_id as $ai) : ?>
                                        <option value="<?= $ai['Activity_id'] ?>"><?= $ai['Activity_Name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>



                            <div class="mb-3 d-grid gap-2">
                                    <button type="submit" class="btn btn-dark">確定更新</button>
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
    const name = document.form1.name; // DOM element
    const name_msg = name.closest('.mb-3').querySelector('.form-text');
   
    // const email = document.querySelector('#start');
    // const name_msg = name.closest('.mb-3').querySelector('.form-text');

    function checkForm() {
        let isPass = true; // 有沒有通過檢查

        name_msg.innerText = ''; // 清空訊息


        // TODO: 表單資料送出之前, 要做格式檢查

        if (name.value.length < 2) {
            isPass = false;
            name_msg.innerText = '請填寫正確的名稱'
        }

        // if (name.value.length < 2) {
        //     isPass = false;
        //     name_msg.innerText = '請填寫'
        // }


        if (isPass) {
            const fd = new FormData(document.form1);

            fetch('ticket-edit.api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert('新增成功');
                        // location.href = 'ab-list.php';
                    } else {
                        alert('新增失敗');
                    }

                })


        }


    }
</script>
<?php include __DIR__ . '../../parts/html-foot.php'; ?>