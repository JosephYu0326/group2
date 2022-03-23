<?php
require __DIR__ . '../../parts/connect_db.php';

$title = '修改會員資料';
$pageName = 'ab-edit';

// 如果有取得id的話，將字串轉為整數存到$id，否則將0存到$id
$id = isset($_GET['id']) ? intval($_GET['id']) : 0; // isset判斷變數是否存在，intval將字串轉為整數
// if(isset($_GET['id'])){
//     $id = intval($_GET['id']);
// }else{
//     $id = 0;
// }

$sql = "SELECT * FROM users WHERE id=$id";
$row = $pdo->query($sql)->fetch();
if (empty($row)) {
    header('Location: ab-list.php'); // 如果找不到資炓，轉向列表頁ab-list.php
    exit; // 程式到此結束
}
?>
<?php include __DIR__ . '../../parts/html-head.php'; ?>
<?php include __DIR__ . '../../parts/nav.php'; ?>
<?php include __DIR__ . './parts/navbar.php'; ?>
<style>
    form .mb-3 .form-text {
        color: red;
    }

    label.addredstar:after {
        content: ' *';
        color: red;
    }
</style>
<div class=" content-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg">
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">修改會員資料</h5><br>
                        <form name="form1" method="post" novalidate onsubmit="checkForm(); return false;">
                            <!--至checkForm()逐項進行格式檢查-->
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <div class="mb-3">
                                <label for="username" class="form-label addredstar">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="4-20位數的英文或數字" pattern="[A-Za-z0-9]{4,20}" value="<?php echo strip_tags($row['username']) ?>">
                                <div class="form-text"></div>
                                <!--紅字提醒區-->
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label addredstar">Password</label>
                                <input type="text" class="form-control" id="password" name="password" placeholder="6位數以上(需含大寫字母、小寫字母、數字、符號至少各1)" pattern="^(?=.*[^a-zA-Z0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{6,}$" value="<?php echo strip_tags($row['password']) ?>">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label addredstar">Email</label>
                                <input type="email" class="form-control" id="email" name="email" pattern="^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$" value="<?php echo strip_tags($row['email']) ?>">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="真實姓名" value="<?php echo strip_tags($row['name']) ?>">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile</label>
                                <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="09xxxxxxxx" pattern="09\d{2}-?\d{3}-?\d{3}" value="<?php echo strip_tags($row['mobile']) ?>">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo strip_tags($row['address']) ?>">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="nickname" class="form-label">Nickname</label>
                                <input type="text" class="form-control" id="nickname" name="nickname" value="<?php echo strip_tags($row['nickname']) ?>">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="avatar" class="form-label">Avatar</label>
                                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/jpeg,image/png">
                                <!-- <img style= "height: 50px" src="./imgs/<?php echo $r['avatar'] ?>"> -->
                                <div class=""><?php echo strip_tags($row['avatar']) ?></div>
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="birthday" class="form-label">Birthday</label>
                                <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo strip_tags($row['birthday']) ?>">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label><br>
                                <div class="form-check form-check-inline">
                                    <label for="gender" class="form-check-label">
                                        不公開
                                    </label>
                                    <input type="radio" class="form-check-input" id="gender" name="gender" value="0" <?php
                                                                                                                        if (isset($row['gender']) && $row['gender'] == '0')
                                                                                                                            echo "checked='checked'";
                                                                                                                        ?> />
                                </div>
                                <div class="form-check form-check-inline">
                                    <label for="gender" class="form-check-label">
                                        女
                                    </label>
                                    <input type="radio" class="form-check-input" id="gender" name="gender" value="1" <?php
                                                                                                                        if (isset($row['gender']) && $row['gender'] == '1')
                                                                                                                            echo "checked='checked'";
                                                                                                                        ?> />
                                </div>
                                <div class="form-check form-check-inline">
                                    <label for="gender" class="form-check-label">
                                        男
                                    </label>
                                    <input type="radio" class="form-check-input" id="gender" name="gender" value="2" <?php
                                                                                                                        if (isset($row['gender']) && $row['gender'] == '2')
                                                                                                                            echo "checked='checked'";
                                                                                                                        ?> />
                                </div>
                                <div class="form-text"></div>
                            </div>
                            <!-- https://stackoverflow.com/questions/5167596/receiving-radio-box-value-in-php -->
                            <div class="mb-3 d-grid gap-2">
                                    <button type="submit" class="btn btn-dark">送出</button>
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
    // 表單資料送出之前, 要做格式檢查
    const username = document.form1.username; // DOM element
    const username_msg = username.closest('.mb-3').querySelector('.form-text');

    const password = document.form1.password;
    const password_msg = password.closest('.mb-3').querySelector('.form-text');

    const email = document.form1.email;
    const email_msg = email.closest('.mb-3').querySelector('.form-text');

    const mobile = document.form1.mobile;
    const mobile_msg = mobile.closest('.mb-3').querySelector('.form-text');

    // const name = document.form1.name;
    // const name_msg = name.closest('.mb-3').querySelector('.form-text');

    function checkForm() {
        let isPass = true; // 有沒有通過檢查

        username_msg.innerText = ''; // 清空紅字訊息
        password_msg.innerText = '';
        email_msg.innerText = '';
        mobile_msg.innerText = '';

        //檢查username是否為4-20位數的英文或數字
        const username_re = /[A-Za-z0-9]{4,20}/; // new RegExp()
        if (username.value) {
            // 如果不是空字串就檢查格式，格式不正確為false
            if (!username_re.test(username.value)) {
                username_msg.innerText = '請輸入正確的帳號';
                isPass = false;
            }
        } else { // 如果是空字串為flase
            username_msg.innerText = '帳號為必填';
            isPass = false;
        }

        //檢查password是否為6位數以上(需含大寫字母、小寫字母、數字、符號至少各1)
        const password_re = /^(?=.*[^a-zA-Z0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{6,}$/;
        if (password.value) {
            // 如果不是空字串就檢查格式，格式不正確為false
            if (!password_re.test(password.value)) {
                password_msg.innerText = '請輸入正確的密碼';
                isPass = false;
            }
        } else { // 如果是空字串為flase
            password_msg.innerText = '密碼為必填';
            isPass = false;
        }

        // 檢查email格式是否正確
        const email_re = /[\S]{1,}\@[\S]{1,}/;
        if (email.value) {
            // 如果不是空字串就檢查格式，格式不正確為false
            if (!email_re.test(email.value)) {
                email_msg.innerText = '請輸入正確的信箱';
                isPass = false;
            }
        } else { // 如果是空字串為flase
            email_msg.innerText = '信箱為必填';
            isPass = false;
        }

        // if(name.value.length<2){
        //     isPass = false;
        //     name_msg.innerText = '請填寫正確的姓名'
        // }

        const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/; // new RegExp()
        if (mobile.value) {
            // 如果不是空字串就檢查格式，格式不正確為false
            if (!mobile_re.test(mobile.value)) {
                mobile_msg.innerText = '請輸入正確的手機號碼';
                isPass = false;
            }
        }

        if (isPass) {
            const fd = new FormData(document.form1);

            fetch('ab-edit-api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert('修改成功');
                        location.href = 'ab-list.php';
                    } else {
                        alert('沒有修改');
                    }
                })
        }
    }
</script>
<?php include __DIR__ . '../../parts/html-foot.php'; ?>