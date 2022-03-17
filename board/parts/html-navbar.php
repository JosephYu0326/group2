<style>
    .navbar-light .navbar-nav .nav-link.active {
        background: #B3D9D9;
        color: white;
        border-radius: 5px;
    }
    .navbar-light .navbar-nav .nav-link2.active {
        background: #C7C7E2	;
        color: white;
        border-radius: 5px;
    }
</style>
<aside class="main-sidebar sidebar-dark-primary position-fixed">

    <a href="#" class="brand-link ">
        後台主頁
    </a>
    <div class="sidebar"></div>
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item ">
                <a href="#" class="nav-link text-white">
                    <i class="nav-icon fas fa-user-alt"></i>
                    <p>會員</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white">
                    <i class="nav-icon fas fa-icons"></i>
                    <p>活動</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white">
                    <i class="nav-icon fas fa-th"></i>
                    <p>商品</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white">
                    <i class="nav-icon fas fa-ticket-alt"></i>
                    <p>票券</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="Blog_home.php" class="nav-link text-white">
                    <i class="nav-icon fas fa-book"></i>
                    <p>文章</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="board-article-list.php" class="nav-link text-white">
                    <i class="nav-icon fas fa-comments"></i>
                    <p>討論區</p>
                </a>
            </li>
    </nav>
</aside>
<div class="content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">留言板</a>
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
