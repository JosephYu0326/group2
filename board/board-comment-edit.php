<?php
require __DIR__ . '/parts/connect_db.php';
$title = '修改留言';

$sid = isset($_GET['board_cid']) ? intval($_GET['board_cid']):0;

$sql = "SELECT * FROM board_comments WHERE board_cid = $sid";
$row = $pdo->query($sql)->fetch();
if(empty($row)){
    header('Location: board-comment-list.php'); // 找不到資炓轉向列表頁
    exit;
}


?>
<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/html-navbar.php'; ?>
<style>
    form .mb-3 .form-text{
        color: red;
    }
    .artnum{
        color: #ccc;
        font-size: 14px;
    }

</style>
<div class="content-wrapper">
    <div class="row justify-content-center align-items-center py-5">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">修改留言</h5>
                    <br>
                    <br>
                    <form name="form2" method="post" novalidate onsubmit="checkForm(); return false;">
                        <input type="hidden" name="board_cid" value="<?= $row['board_cid'] ?>">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">*UserId</label>
                            <input type="text" class="form-control" id="user_id" name="user_id" required
                            value="<?= htmlentities($row['user_id']) ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">*Content</label>
                            <textarea type="text" class="form-control" id="content" name="content"><?= $row['content']?></textarea>
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="board_article_id" class="form-label">*BoardArticleId</label>
                            <input type="text" class="form-control" id="board_article_id" name="board_article_id" required
                            value="<?= htmlentities($row['board_article_id']) ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="parentid" class="form-label">*ParentId</label>
                            <input type="text" class="form-control" id="parentid" name="parentid" required
                            value="<?= htmlentities($row['parentid']) ?>">
                            <div class="form-text"></div>
                        </div>
                        
                        <br>

                        <button type="submit" class="btn btn-primary">修改</button>
                    </form>

                </div>
            </div>
        </div>
    </div>





</div>
<?php include __DIR__ . '/parts/html-scripts.php'; ?>
<script>

    const content = document.form2.content;
    const content_msg = content.closest('.mb-3').querySelector('.form-text');

    function checkForm(){
        let isPass = true; // 有沒有通過檢查

        content_msg.innerText = '';  // 清空訊息

        // TODO: 表單資料送出之前, 要做格式檢查

        if(content.value==""){
            // 如果不是空字串就檢查格式
            content_msg.innerText = '請輸入內文';
        }

        if(isPass){
            const fd = new FormData(document.form2);

            fetch('board-comment-edit-api.php', {
                method: 'POST',
                body: fd
            }).then(r => r.json())
            .then(obj => {
                console.log(obj);
                if(obj.success){
                    alert('修改成功');
                    location.href = 'board-comment-list.php';
                } else {
                    alert('沒有修改');
                }
            
            })

        }


    }


</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>