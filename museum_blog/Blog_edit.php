<?php
require __DIR__ . '../../parts/connect_db.php';
$title = '編輯文章';
$pageName = 'edit';

function GetSQLValueString($theValue, $theType)
{
    switch ($theType) {
        case "string":
            $theValue = ($theValue != "") ?
                filter_var($theValue, FILTER_SANITIZE_ADD_SLASHES) : "";
            break;
        case "int":
            $theValue = ($theValue != "") ?
                filter_var($theValue, FILTER_SANITIZE_NUMBER_INT) : "";
            break;
    }
}

$options = [];
$sqlOption = sprintf("SELECT * FROM `blog_category`");
$options = $pdo->query($sqlOption)->fetchAll();

//從外部網址直接近來會重新導向
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
$sql = "SELECT * FROM blog_article
    JOIN `blog_category` 
    ON blog_article.category = blog_category.sn 
    JOIN `users` 
    ON blog_article.users_id = users.id
    WHERE article_id=$sid";
$row = $pdo->query($sql)->fetch();
if (empty($row)) {
    header('Location:blog_home.php');
    exit;
}

// if (isset($_POST["action"]) && ($_POST["action"] == "update")) {
//     $query_update = "UPDATE blog_article SET
//     title=?, content=?, visible=?, category=?,users_id=? WHERE article_id=?";
//     $stmt = $db_link->prepare($query_update);
//     $stmt->bind_param(
//         "ssiii",
//         GetSQLValueString($_POST["title"], "string"),
//         GetSQLValueString($_POST["content"], "string"),
//         GetSQLValueString($_POST["category"], "int"),
//         GetSQLValueString($_POST["users_id"], "int"),
//         GetSQLValueString($_POST["visible"], "int")
//     );
//     $stmt->execute();
//     $stmt->close();
// }


$query_RecBlog = "SELECT `article_id`, `title`, `created_time`, `content`, `visible`, `category`, `users_id`, `thema` FROM `blog_article`
JOIN `blog_category` 
ON blog_article.category = blog_category.sn 
WHERE article_id =?";
$stmt = $db_link->prepare($query_RecBlog);
$stmt->bind_param("i", $_GET["sid"]);
$stmt->execute();
$stmt->bind_result($article_id, $title, $created_time, $content, $visible, $category, $users_id, $thema);
$stmt->fetch();






?>

<?php include __DIR__ . '/Blog_part/html_blog_head.php'; ?>
<div class="content-wrapper h-100">
    <!-- 麵包屑 -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>編輯文章</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-warning btn-bg" href="Blog_home.php">
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
        <div class="card card-outline card-warning mt-20">

            <form name="form_article" method="POST" onsubmit="checkForm(event); return false;">
                <input type="hidden" name="article_id" value="<?= $row['article_id'] ?>">
                <form name="form_article" method="POST" action="Blog_edit-api.php">
                    <div class="card-header">
                        <label for="title" class="form-label">文章標題</label>
                        <input type="text" class="form-control form-control-lg" id="title" name="title" placeholder="請輸入標題" aria-label="文章標題" value="<?= htmlentities($row['title']) ?>" require>
                        <div style="color:red" class="form-text"></div>
                    </div>
                    <div class="card-body">
                        <label for="content" class="form-label">文章內容</label>
                        <textarea id="content" name="content"><?= $row['content'] ?></textarea>
                        <div class="form-text"></div>
                    </div>
                    <div class="card-footer">
                        <div class="input-group mb-5">
                            <label class="input-group-text" for="category">文章分類</label>
                            <select class="form-select" id="category" name="category">
                                <!-- <option value="<?php echo $category; ?>"></option> -->
                                <?php foreach ($options as $c) : ?>
                                    <option value="<?= $c['sn'] ?>" <?php if ($category == $c['sn']) {
                                                                        echo "selected";
                                                                    } ?>><?= $c['thema'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="bd-example">
                            <label for="users_id" class="form-label">用戶id</label>
                            <input type="text" class="form-control  mb-5" id="user_id" name="users_id" value="<?php echo $users_id; ?>" require>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="visible" id="visible" value="1" <?php if ($visible == "1") {
                                                                                                                        echo "checked";
                                                                                                                    } ?>>
                                <label class="form-check-label" for="visible">顯示</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="visible" id="invisible" value="0" <?php if ($visible == "0") {
                                                                                                                            echo "checked";
                                                                                                                        } ?>>
                                <label class="form-check-label" for="invisible">
                                    不顯示
                                </label>
                            </div>
                            <div class="form-text"></div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning btn-bg m-2">
                        修改文章
                    </button>

                </form>
        </div>
    </div>
</div>

<script>
    tinymce.init({
        selector: 'textarea',
        height: '60vh',
        plugins: "image",
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

        if (title.value.length < 3) {
            isPass = false;
            title_msg.innerText = '標題過短，請重新輸入'
        }


        if (isPass) {
            const fd = new FormData(document.form_article);
            fetch('Blog_edit-api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert('編輯成功');
                        location.href = 'Blog_home.php';
                    } else {
                        alert('編輯失敗');
                    }
                })
        }
    }
</script>


<!--側邊選單-->
<?php include __DIR__ . '../../parts/nav.php'; ?>
<?php include __DIR__ . '../../parts/html-foot.php'; ?>