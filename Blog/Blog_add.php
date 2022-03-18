<?php
require __DIR__ . '/conect_DB.php';
$title = '新增文章';
$pageName = 'add';
$sql = sprintf("SELECT * FROM `blog_category` 
    ORDER BY squence ASC");
$options = [];
$options = $pdo->query($sql)->fetchAll();
?>
<?php include __DIR__ . '/Blog_part/html_blog_head.php'; ?>


<div class="content-wrapper h-100">
    <!-- 麵包屑 -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>新增文章</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary btn-bg" href="Blog_home.php">
                        <i class="fas fa-reply"></i>
                        返回
                    </a>
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="Blog_category.php">分類</a></li>
                        <li class="breadcrumb-item active">文章</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="content">
        <div class="card card-outline card-primary mt-20">
            <form name="form_article" method="POST" onsubmit="checkForm(event); return false;">
                <!-- <form name="form_article" method="POST" action="Blog_add-api.php"> -->
                <div class="card-header">
                    <label for="title" class="form-label">文章標題</label>
                    <input type="text" class="form-control form-control-lg" id="title" name="title" placeholder="請輸入標題" aria-label="文章標題" require>
                    <div style="color:red" class="form-text"></div>
                </div>
                <div class="card-body">
                    <label for="content" class="form-label">文章內容</label>
                    <textarea id="content" name="content"></textarea>
                    <div class="form-text"></div>
                </div>
                <div class="card-footer">
                    <div class="input-group mb-5">
                        <label class="input-group-text" for="category">文章分類</label>
                        <select class="form-select" id="category" name="category">
                            <?php foreach ($options as $c) : ?>
                                <option value="<?= $c['sn'] ?>"><?= $c['thema'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="bd-example">
                        <label for="users_id" class="form-label">用戶id</label>
                        <input type="text" class="form-control  mb-5" id="user_id" name="users_id" require>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="visible" id="visible" value="1">
                            <label class="form-check-label" for="visible">顯示</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="visible" id="invisible" value="0">
                            <label class="form-check-label" for="invisible">
                                不顯示
                            </label>
                        </div>
                        <div class="form-text"></div>
                    </div>
                </div>

                <button type="submit" class="btn btn-danger btn-bg m-2">
                    <i class="fas fa-plus "></i>新增文章
                </button>

            </form>
        </div>
    </div>
</div>

<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'image code',
        toolbar: ' styleselect | forecolor | fontsizeselect | bold italic  |image | aligncenter | alignleft | alignright | code',
        images_upload_url:'Blog_uploadImage.php',
        height: '60vh',
        language: 'zh_TW',
        //用Ajax送出資料的設定
        setup: function(editor) {
            editor.on('change', function() {
                tinymce.triggerSave();
            });
        }

    });

    const title = document.form_article.title; // DOM element
    const title_msg = title.closest('div').querySelector('.form-text');

    function checkForm(evt) {
        evt.preventDefault();
        console.log(document.querySelector('#content').value);
        let isPass = true; // 有沒有通過檢查

        title_msg.innerText = ''; // 清空訊息

        // TODO: 表單資料送出之前, 要做格式檢查
        if (title.value.length < 3 || title.value.length > 100) {
            isPass = false;
            title_msg.innerText = '標題字數限制3~100，請重新輸入'

        }


        if (isPass) {
            const fd = new FormData(document.form_article);
            fetch('Blog_add-api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert('新增成功');
                        location.href = 'Blog_home.php';
                    }
                }).catch(function(error) {
                    console.log('catch作用');
                    alert('新增失敗，有欄位未填');
                })
        }
    }
</script>


<!--側邊選單-->
<?php include __DIR__ . '/Blog_part/nav.php'; ?>
<?php include __DIR__ . '/Blog_part/html_blog_foot.php'; ?>