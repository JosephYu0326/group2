<style>
    .navbar-light .navbar-nav .nav-link.active {
        background-color: #00f;
        color: white;
        border-radius: 5px;
    }
</style>
<div class="content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Team2</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'home' ? 'active' : '' ?>" aria-current="page" href="home_.php">首頁</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'products_list' ? 'active' : '' ?>" href="products_list.php">商品庫列表</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'sale_photo_list' ? 'active' : '' ?>" href="sale_photo_list.php">商品圖庫</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'discount_photo_list' ? 'active' : '' ?>" href="discount_photo_list.php">全站優惠圖庫</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'products_add' ? 'active' : '' ?>" href="products_add.php">新增商品資料</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'sale_photo_add' ? 'active' : '' ?>" href="sale_photo_add.php">新增商品圖</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == '' ? 'active' : '' ?>" href="discount_photo_add.php">新增全站優惠圖</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
</div>