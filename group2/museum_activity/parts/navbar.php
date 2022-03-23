<style>
    .navbar-light .navbar-nav .nav-link.active {
        background-color: #292b2c;
        color: white;
        border-radius: 5px;
        font-weight: 800;

    }
    .navbar{
        border-bottom: 1px solid rgba(102, 102, 102,0.5);
    }
</style>
<div class="content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-light  ">
        <div class="container-fluid">
        <a class="navbar-brand" href="/group2/museum_activity/ab-list.php">活動</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'ab-list' ? 'active' : '' ?>" href="ab-list.php">活動主列表</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'ab-add' ? 'active' : '' ?>" href="ab-add.php">新增活動</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'ab-list-guest' ? 'active' : '' ?>" href="ab-list-guest.php">嘉賓列表</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'ab-add-guest' ? 'active' : '' ?>" href="ab-add-guest.php">新增嘉賓</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'ab-list-org' ? 'active' : '' ?>" href="ab-list-org.php">主辦單位列表</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'ab-add-org' ? 'active' : '' ?>" href="ab-add-org.php">新增主辦單位</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'ab-list-types' ? 'active' : '' ?>" href="ab-list-types.php">活動類型列表</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'ab-add-types' ? 'active' : '' ?>" href="ab-add-types.php">新增活動類型</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'ab-list-ticket' ? 'active' : '' ?>" href="ab-list-ticket.php">票券價格&類型</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'ab-add-ticket' ? 'active' : '' ?>" href="ab-add-ticket.php">新增票券</a>
                    </li>


                </ul>

            </div>
        </div>
    </nav>
</div>