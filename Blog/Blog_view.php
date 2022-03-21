<?php
require __DIR__ . '/conect_DB.php';
$title = '文章檢視';
$pageName = 'view';
$query_RecArticle = "SELECT `article_id`, `title`, `created_time`, `content`, `visible`, `category`, `users_id`, `thema`, `nickname`, `username` FROM `blog_article`
JOIN `blog_category` 
ON blog_article.category = blog_category.sn 
JOIN `users` 
ON blog_article.users_id = users.id
WHERE article_id =?";
$stmt = $db_link->prepare($query_RecArticle);
$stmt->bind_param("i", $_GET["sid"]);
$stmt->execute();
$stmt->bind_result($article_id, $title, $created_time, $content, $visible, $category, $users_id, $thema, $nickname, $username);
$stmt->fetch();

// 留言
$query_RecComment = "SELECT `blog_comment_id`, `Blog_comment_content`, `COMMENT_time`, `nickname`, `username` FROM `blog_comment`
JOIN `users` 
ON blog_comment.user_id = users.id
JOIN `blog_article` 
ON blog_comment.article_id = blog_article.article_id
WHERE blog_article.article_id =?";

$stmt = $pdo->prepare($query_RecComment);
 //$stmt->bind_param( "i",  $_GET["sid"]);
$stmt->execute([
  $_GET["sid"]
]);
$comments = $stmt->fetchAll();

?>

<?php include __DIR__ . '/Blog_part/html_blog_head.php'; ?>

<div class="content-wrapper h-100">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">

        </div>
        <div class="col-sm-6">
          <a class="btn btn-warning btn-bg" href="Blog_home.php">
            <i class="fas fa-reply"></i>
            回文章列表
          </a>
        </div>
      </div>
    </div>
  </section>
  <!-- 文章顯示卡片 -->
  <div class="card" style="width: 80vw; margin:30px;">
    <!-- <svg class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false">
      <title>Placeholder</title>
      <rect width="100%" height="100%" fill="#868e96"></rect><text x="50%" y="50%" fill="#dee2e6" dy=".3em">Image cap</text>
    </svg> -->

    <div class="card-header p-4">
      <h1><?php echo $title; ?></h1>
    </div>
    <div class="card-body ">
      <div class="card-text text-align" style="min-height:60vh;">
        <?php echo $content; ?>
      </div>
    </div>
    <div class="card-body">
      <ul class="list-group list-group-flush">
        <li class="list-group-item">用戶ID：<?php echo $username; ?></li>
        <li class="list-group-item">用戶暱稱：<?php echo $nickname; ?></li>
        <li class="list-group-item">文章分類：<?php echo $thema; ?></li>
        <li class="list-group-item"><?php echo '創建時間：' . $created_time; ?></li>
      </ul>
    </div>
    <div class="card-footer">
      <a class="btn btn-info btn-sm" href="Blog_edit.php?sid=<?php echo $article_id; ?>">
        <i class="fas fa-pencil-alt">
        </i>修改
      </a>
      <!-- <a class="btn btn-danger btn-sm" href="Blog_delete.php?article_id=<?php echo $article_id; ?>
                            " onclick="return confirm (`確定刪除「<?= $r['title'] ?>」?`)">
        <i class="fas fa-trash">
        </i>
      </a> -->
    </div>

    <div class="card card-secondary">
      <div class="card-header">
        回應
      </div>
    </div>
    <div class="card">
      <?php foreach ($comments as $r) : ?>
      <div class="card-header">
      <?= $r['blog_comment_id'] ?>樓
      <a href="Blog_comment-delete.php?blog_comment_id=<?= $r['blog_comment_id'] ?>
                            " onclick="return confirm (`確定刪除留言「<?= $r['blog_comment_id'] ?>」?`)" class="btn btn-sm btn-danger">刪除</a>
      </div>
      <div class="card-body">
        <h5 class="content-title"><?= $r['nickname'] ?>：</h5>
        <p class="content-text"><?= $r['Blog_comment_content'] ?></p>
      </div>
      <?php endforeach ?>
    </div>
  </div>
</div>


<script>

</script>
<!--側邊選單-->
<?php include __DIR__ . '/Blog_part/nav.php'; ?>
<?php include __DIR__ . '/Blog_part/html_blog_foot.php'; ?>