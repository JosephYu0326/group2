<?php
require __DIR__ . '/parts/connect_db.php';

$title = '新增留言';
$pageName = 'board-comment-add';

$sid = isset($_GET['board_aid']) ? intval($_GET['board_aid']):0;


$sql = "SELECT board_aid FROM board_articles WHERE board_aid = $sid";
$row = $pdo->query($sql)->fetch();



?>
<?php include __DIR__. '/parts/html-head.php'; ?>
<?php include __DIR__. '/parts/html-navbar.php'; ?>
<style>
    form .mb-3 .form-text{
        color: red;
    }
</style>

<div class="content-wrapper">
        <div class="row justify-content-center align-items-center py-4">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">新增留言</h5>
                        <br>
                        <br>
                        <form name="form1" method="post" novalidate onsubmit="checkForm(); return false;">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">UserId</label>
                                <input type="text" class="form-control" id="user_id" name="user_id" required>
                                <div class="form-text"></div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="content" class="form-label">Content</label>
                                <textarea class="form-control" name="content" id="content" cols="30" rows="3"></textarea>
                                <div class="form-text"></div>
                            </div>

                            <div class="mb-3">
                                <label for="board_article_id" class="form-label">BoardArticleId</label>
                                <input type="text" class="form-control" id="board_article_id" name="board_article_id" 
                                value="<?=$row['board_aid']?>">
                                <div class="form-text"></div>
                            </div>

                            <div class="mb-3">
                                <label for="parentid" class="form-label">ParentId</label>
                                <input type="text" class="form-control" id="parentid" name="parentid">
                                <div class="form-text"></div>
                            </div>

                            <button type="submit" class="btn btn-primary">新增</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include __DIR__ . '/parts/html-scripts.php'; ?>
<script>
    const user_id = document.form1.user_id;
    const user_id_msg = user_id.closest('.mb-3').querySelector('.form-text');
    
    const content = document.form1.content;
    const content_msg = content.closest('.mb-3').querySelector('.form-text');

    function checkForm(){
        let isPass = true; // 有沒有過檢查

        user_id_msg.innerText = ''; // 清空訊息
        content_msg.innerText = ''; // 清空訊息

        if(user_id.value<=0){
            // 如果不是空字串就檢查格式
            isPass = false;
            user_id_msg.innerText = '請輸入使用者id';
        }

        // TODO: 表單資料送出前,要做格式檢查
        
        if(content.value<=0){
            // 如果不是空字串就檢查格式
            isPass = false;
            content_msg.innerText = '請輸入內文';
        }

        if(isPass){
            const fd = new FormData(document.form1);

            fetch('board-comment-add-api.php',{
                method:'POST',
                body: fd
            }).then(r => r.json())
            .then(obj => {
                console.log(obj);
                if(obj.success){
                    alert('新增成功');
                    location.href = 'board-comment-list.php';
                } else {
                    alert('新增失敗');
                }
            })
        }
 
    }
</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>