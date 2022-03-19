<style>
    .navbar-light .navbar-nav .nav-link.active {
        background-color: #6969fc;
        color: white;
        border-radius: 5px;
        font-weight: 800;

    }
</style>
<div class="content-wrapper">
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">單位名</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName=='home' ? 'active' : '' ?>" aria-current="page" href="home_.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName=='ab-list' ? 'active' : '' ?>" href="ab-list.php">活動主列表</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName=='ab-add' ? 'active' : '' ?>" href="ab-add.php">新增活動</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName=='ab-list-guest' ? 'active' : '' ?>" href="ab-list-guest.php">嘉賓列表</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName=='ab-add-guest' ? 'active' : '' ?>" href="ab-add-guest.php">新增嘉賓</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName=='ab-list-org' ? 'active' : '' ?>" href="ab-list-org.php">主辦單位列表</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName=='ab-add-org' ? 'active' : '' ?>" href="ab-add-org.php">新增主辦單位</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName=='ab-list-types' ? 'active' : '' ?>" href="ab-list-types.php">活動類型列表</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName=='ab-add-types' ? 'active' : '' ?>" href="ab-add-types.php">新增活動類型</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName=='ab-list-ticket' ? 'active' : '' ?>" href="ab-list-ticket.php">票券價格&類型</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName=='ab-add-ticket' ? 'active' : '' ?>" href="ab-add-ticket.php">新增票券</a>
                    </li>
                    

                </ul>

            </div>
        </div>
    </nav>
</div>
</div>
<aside class="main-sidebar sidebar-dark-primary">

    <a href="#" class="brand-link ">
        後台主頁
    </a>

    <div class="sidebar" position-fixed>
    </div>
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
                <a href="#" class="nav-link text-white">
                <i class="nav-icon fas fa-comments"></i>
                    <p>討論區</p>
                </a>
            </li>

    </nav>
    </div>
</aside>
