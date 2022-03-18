<?php
require __DIR__ . '/parts/connect_db.php';
$title = '修改文章';

$sid = isset($_GET['board_aid']) ? intval($_GET['board_aid']):0;
$sid2 = isset($_GET['board_pid']) ? intval($_GET['board_pid']):0;

$sql = "SELECT * FROM board_articles WHERE board_aid = $sid";
$sql2 = "SELECT * FROM board_photos WHERE board_pid = $sid2";

$row = $pdo->query($sql)->fetch();
$row2 = $pdo->query($sql2)->fetch();
if(empty($row)){
    header('Location: board-article-list.php'); // 找不到資炓轉向列表頁
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
    .myimg{
        width: 100%;
    }

</style>
<div class="content-wrapper">
    <div class="row justify-content-center align-items-center py-5">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">修改文章</h5>
                    <br>
                    <br>
                    <form name="form1" method="post" novalidate onsubmit="checkForm(); return false;">
                        <input type="hidden" name="board_aid" value="<?= $row['board_aid'] ?>">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">* UserId</label>
                            <input type="text" class="form-control" id="user_id" name="user_id" required
                            value="<?= htmlentities($row['user_id']) ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">* Title</label>
                            <input type="text" class="form-control" id="title" name="title" required
                            value="<?= htmlentities($row['title']) ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">*Content</label>
                            <textarea type="text" class="form-control" id="content" name="content"><?= $row['content']?></textarea>
                            <div class="form-text"></div>
                        </div>

                        <input type="hidden" id="pic_name" name="pic_name">
                        <img class="mb-2" src="<?= empty($row2['img']) ? '' : '/board/image/'. $row2['img'] ?>" alt="" id="editimg" style="width: 100%;">

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" onclick="avatar.click()">上傳照片</button>

                            <br>
                            <br>
                            
                            <div class="artnum" name="board_aid">文章編號：<?= $row['board_aid'] ?></div>
                        </div>
                        <br>
                        
                        <a href="javascript: remove_pic(<?= $row2['board_pid']?>)">
                            刪除圖片
                        </a>
                        
                        <br>
                        <br>

                        <button type="submit" class="btn btn-primary">修改</button>
                    </form>
                    <form name="image_form" onsubmit="return false;" style="display: none;">
                        <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png">
                    </form>

                </div>
            </div>
        </div>
    </div>





</div>
<?php include __DIR__ . '/parts/html-scripts.php'; ?>
<script src="./js/jquery-3.6.0.min.js"></script>
<script>
    function remove_pic(board_pid){
        if(confirm(`確定要刪除編號為 ${board_pid} 的資料嗎?`)){
            const url = 'board-photos-delete.php?board_pid=' + board_pid;
            console.log(this);
            $.get(url, function (data){
                editimg.src = '';
                pic_name.value = '';
            });
        }
    }

    const title = document.form1.title; // DOM element
    const title_msg = title.closest('.mb-3').querySelector('.form-text');

    const content = document.form1.content;
    const content_msg = content.closest('.mb-3').querySelector('.form-text');


    function checkForm(){
        let isPass = true; // 有沒有通過檢查

        title_msg.innerText = '';  // 清空訊息
        content_msg.innerText = '';  // 清空訊息

        // TODO: 表單資料送出之前, 要做格式檢查

        if(name.value){
            isPass = false;
            title_msg.innerText = '請填寫標題'
        }
        if(content.value==""){
            // 如果不是空字串就檢查格式
            content_msg.innerText = '請輸入內文';
        }

        if(isPass){
            const fd = new FormData(document.form1);

            fetch('board-article-edit-api.php', {
                method: 'POST',
                body: fd
            }).then(r => r.json())
            .then(obj => {
                console.log(obj);
                if(obj.success){
                    alert('修改成功');
                    location.href = 'board-article-list.php';
                } else {
                    alert('沒有修改');
                }
            
            })


        }


    }


</script>

<script>
    const avatar = document.querySelector('#avatar');
    function sendData(){
        const fd2 = new FormData(document.image_form);

        fetch('board-photos-add-api.php',{
            method:'POST',
            body:fd2
        }).then(r=>r.json())
        .then(obj=>{
            console.log(obj);
            if(obj.success && obj.filename){
                editimg.src = './image/' + obj.filename;
                pic_name.value = obj.filename;
            }
        })
    }

    avatar.onchange = sendData;


</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>