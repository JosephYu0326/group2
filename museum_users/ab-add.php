<?php
$title = '新增會員資料';
$pageName = 'ab-add';
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
                        <h5 class="card-title">新增會員資料</h5><br>
                        <form name="form1" method="post" novalidate onsubmit="checkForm(); return false;">
                            <!--至checkForm()逐項進行格式檢查-->
                            <div class="mb-3">
                                <label for="username" class="form-label addredstar">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="4-20位數的英文或數字" pattern="[A-Za-z0-9]{4,20}">
                                <div class="form-text"></div>
                                <!--紅字提醒區-->
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label addredstar">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="6位數以上(需含大寫字母、小寫字母、數字、符號至少各1)" pattern="^(?=.*[^a-zA-Z0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{6,}$">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label addredstar">Email</label>
                                <input type="email" class="form-control" id="email" name="email" pattern="^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="真實姓名">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile</label>
                                <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="09xxxxxxxx" pattern="09\d{2}-?\d{3}-?\d{3}">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="nickname" class="form-label">Nickname</label>
                                <input type="text" class="form-control" id="nickname" name="nickname">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="avatar" class="form-label">Avatar</label>
                                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/jpeg,image/png">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="birthday" class="form-label">Birthday</label>
                                <input type="date" class="form-control" id="birthday" name="birthday">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label><br>
                                <!-- <input type="type" class="form-control" id="gender" name="gender"> -->

                                <div class="form-check form-check-inline">
                                    <label for="gender" class="form-check-label">
                                        不公開
                                    </label>
                                    <input type="radio" class="form-check-input" id="gender" name="gender" value="0" checked>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label for="gender" class="form-check-label">
                                        女
                                    </label>
                                    <input type="radio" class="form-check-input" id="gender" name="gender" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label for="gender" class="form-check-label">
                                        男
                                    </label>
                                    <input type="radio" class="form-check-input" id="gender" name="gender" value="2">
                                </div>
                                <div class="form-text"></div>
                            </div>
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
        let isPass = true; // 是否通過檢查，true則送出

        username_msg.innerText = ''; // 清空紅字訊息
        password_msg.innerText = '';
        email_msg.innerText = '';
        mobile_msg.innerText = '';

        // 如果username小於4個字，則為fales
        // if(username.value.length<4){
        //     isPass = false;
        //     username_msg.innerText = '帳號為必填'
        // }

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

        // 如果password少於6個字，則為fales
        // if(password.value.length<6){
        //     isPass = false;
        //     password_msg.innerText = '密碼為必填'
        // }

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

        // 如果email少於1個字，則為fales
        // if(email.value.length<1){
        //     isPass = false;
        //     email_msg.innerText = '信箱為必填'
        // }

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
        //     name_msg.innerText = '請填寫正確的名字'
        // }

        const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/; // new RegExp()
        if (mobile.value) {
            // 如果不是空字串就檢查格式，格式不正確為false
            if (!mobile_re.test(mobile.value)) {
                mobile_msg.innerText = '請輸入正確的手機號碼';
                isPass = false;
            }
        }
        // } else {
        //     mobile_msg.innerText = '手機號碼為必填';
        //     isPass = false;
        // }

        if (isPass) {
            const fd = new FormData(document.form1); // FormData是將表格form1轉成key:value的方法

            fetch('ab-add-api.php', { // 透過fetch語法，向後端發出POST請求，把資料fd傳遞到後端
                    method: 'POST',
                    body: fd
                }).then(r => r.json()) // r是從後端收到的結果，收到後轉成json的檔案交換格式
                .then(obj => { // obj是r.json
                    console.log(obj);
                    if (obj.success) { // 後端會回傳給前端key success的value true or fales
                        alert('新增成功'); // 若收到的value是true，alert新增成功
                        location.href = 'ab-list.php'; //頁面轉向至ab-list.php
                    } else {
                        alert('新增失敗'); // 若收到的value是false，alert新增失敗
                    }
                })
        }
    }
</script>
<?php include __DIR__ . '../../parts/html-foot.php'; ?>