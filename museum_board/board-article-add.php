<?php
$title = '新增文章';
$pageName = 'board-article-add';
?>
<?php include __DIR__ . '../../parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/html-navbar.php'; ?>
<?php include __DIR__ . '../../parts/nav.php'; ?>
<style>
    form .mb-3 .form-text {
        color: red;
    }
</style>

<div class="content-wrapper">
    <div class="content">
        <div class="row justify-content-center ">
            <div class="col-lg">
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">新增文章</h5>
                        <br>
                        <br>
                        <form name="form1" method="post" novalidate onsubmit="checkForm(); return false;">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">UserId</label>
                                <input type="text" class="form-control" id="user_id" name="user_id" required>
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                                <div class="form-text"></div>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Content</label>
                                <textarea class="form-control" name="content" id="content" cols="30" rows="3"></textarea>
                                <div class="form-text"></div>
                            </div>
                            <input type="hidden" id="pic_name" name="pic_name">
                            <img class="mb-2" src="" alt="" id="myimg" style="width: 100%;">
                            <br>

                            <button type="button" class="btn btn-dark" onclick="avatar.click()">上傳照片</button>

                            <br>
                            <br>
                            <div class="mb-3 d-grid gap-2">
                                    <button type="submit" class="btn btn-dark">新增</button>
                                </div>
                        </form>
                        <form name="image_form" onsubmit="return false;" style="display: none;">
                            <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '../../parts/scripts.php'; ?>
<script>
    const user_id = document.form1.user_id;
    const user_id_msg = user_id.closest('.mb-3').querySelector('.form-text');

    const title = document.form1.title; // DOM element
    const title_msg = title.closest('.mb-3').querySelector('.form-text');

    const content = document.form1.content;
    const content_msg = content.closest('.mb-3').querySelector('.form-text');

    function checkForm() {
        let isPass = true; // 有沒有過檢查

        user_id_msg.innerText = ''; // 清空訊息
        title_msg.innerText = ''; // 清空訊息
        content_msg.innerText = ''; // 清空訊息

        if (user_id.value <= 0) {
            // 如果不是空字串就檢查格式
            isPass = false;
            user_id_msg.innerText = '請輸入使用者id';
        }

        if (title.value == "") {
            isPass = false;
            title_msg.innerText = '請輸入標題';
        }


        // TODO: 表單資料送出前,要做格式檢查

        if (content.value <= 0) {
            // 如果不是空字串就檢查格式
            isPass = false;
            content_msg.innerText = '請輸入內文';
        }

        if (isPass) {
            const fd = new FormData(document.form1);

            fetch('board-article-add-api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert('新增成功');
                        location.href = 'board-article-list.php';
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

        fetch('board-photos-add-api.php', {
                method: 'POST',
                body: fd2
            }).then(r => r.json())
            .then(obj => {
                console.log(obj);
                if (obj.success && obj.filename) {
                    myimg.src = './image/' + obj.filename;
                    pic_name.value = obj.filename;
                }
            })
    }

    avatar.onchange = sendData;
</script>
<?php include __DIR__ . '../../parts/html-foot.php'; ?>