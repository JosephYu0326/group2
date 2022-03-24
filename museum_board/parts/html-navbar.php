<style>
    .navbar-light .navbar-nav .nav-link.active {
        background:#292b2c;
        color: white;
        border-radius: 5px;
    }
    .navbar-light .navbar-nav .nav-link2.active {
        background: #C7C7E2	;
        color: white;
        border-radius: 5px;
    }
    .navbar{
        border-bottom: 1px solid rgba(102, 102, 102,0.5);
    }
</style>
<div class="content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/group2/museum_board/board-article-list.php">留言板</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'board-article-list' ? 'active' : '' ?>" aria-current="page" href="board-article-list.php">文章列表</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'board-comment-list' ? 'active' : '' ?>" aria-current="page" href="board-comment-list.php">留言列表</a>
                    </li>
                    
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link nav-link2 <?= $pageName == 'board-article-add' ? 'active' : '' ?>" href="board-article-add.php">
                            新增文章
                            <i class="fas fa-plus-circle"></i>
                        </a>
                        
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
