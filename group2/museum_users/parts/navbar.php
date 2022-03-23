<style>
    .navbar-light .navbar-nav .nav-link.active {
        background-color: #292b2c;
        color: white;
        border-radius: 5px;
        font-weight: 800;
    }
    .container{
        background-color: white;
    }
    .navbar{
        border-bottom: 1px solid rgba(102, 102, 102,0.5);
    }
</style>
<div class=" content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <a class="navbar-brand" href="/group2/museum_users/ab-list.php">會員</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName=='ab-list' ? 'active' : '' ?>" href="ab-list.php"><i class="fas fa-list-ul"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName=='ab-add' ? 'active' : '' ?>" href="ab-add.php"><i class="fas fa-user-plus"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>